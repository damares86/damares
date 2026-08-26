<?php
declare(strict_types=1);

/**
 * Shared persistence and filesystem services used by the legacy modules.
 *
 * The public properties are intentionally kept for backwards compatibility with
 * the existing procedural pages. New code should prefer explicit methods.
 */
class Common
{
    public $conn;
    public $stmt;
    public $table;
    public $where;
    public $fields;
    public $id;
    public $prx = '';
    public $operation;
    public $origin;
    protected string $prefix = '';

    private const IDENTIFIER_PATTERN = '/\A[A-Za-z_][A-Za-z0-9_]*\z/';

    public function __construct(PDO $db)
    {
        $this->conn = $db;
        $this->loadPrefix();
    }

    protected function loadPrefix(): void
    {
        $prefix = '';
        $prefixFile = __DIR__ . '/../core/prefix.php';

        if (is_file($prefixFile)) {
            require $prefixFile;
            $prefix = (string) ($prefix ?? '');
        }

        $this->prefix = trim($prefix, '_');
        $this->prx = $this->prefix === '' ? '' : $this->prefix . '_';
    }

    public function getTableName(string $baseTable): string
    {
        return $this->tableName($baseTable);
    }

    protected function tableName(?string $table = null): string
    {
        $table ??= (string) $this->table;
        $this->assertIdentifier($table);

        return $this->prx . $table;
    }

    protected function assertIdentifier(string $identifier): void
    {
        if (!preg_match(self::IDENTIFIER_PATTERN, $identifier)) {
            throw new InvalidArgumentException(sprintf('Invalid SQL identifier: %s', $identifier));
        }
    }

    protected function valueFor(string $field): mixed
    {
        $this->assertIdentifier($field);

        if (!property_exists($this, $field)) {
            throw new InvalidArgumentException(sprintf('Unknown model field: %s', $field));
        }

        return $this->{$field};
    }

    protected function executeQuery(string $query, array $parameters = []): PDOStatement
    {
        $statement = $this->conn->prepare($query);

        foreach ($parameters as $name => $value) {
            $statement->bindValue(
                (string) $name,
                $value,
                is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR
            );
        }

        $statement->execute();

        return $statement;
    }

    public function showError(PDOStatement $statement): void
    {
        error_log(implode(' | ', $statement->errorInfo()));
    }

    public function insert(array $fields): bool
    {
        $fields = $this->normalizeFields($fields);
        $columns = implode(', ', $fields);
        $placeholders = implode(', ', array_map(static fn (string $field): string => ':' . $field, $fields));
        $parameters = $this->parametersFor($fields);

        $query = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->tableName(),
            $columns,
            $placeholders
        );

        $this->executeQuery($query, $parameters);

        return true;
    }

    public function update(array $fields, string $where): bool
    {
        $fields = $this->normalizeFields($fields);
        $this->assertIdentifier($where);

        $assignments = implode(', ', array_map(
            static fn (string $field): string => $field . ' = :' . $field,
            $fields
        ));
        $parameters = $this->parametersFor($fields);
        $parameters[':' . $where] = $this->valueFor($where);

        $query = sprintf(
            'UPDATE %s SET %s WHERE %s = :%s',
            $this->tableName(),
            $assignments,
            $where,
            $where
        );

        $this->executeQuery($query, $parameters);

        return true;
    }

    public function showAll(
        string $orderBy,
        ?int $limit = null,
        ?int $offset = null,
        string $ascDesc = 'ASC'
    ): PDOStatement {
        $this->assertIdentifier($orderBy);
        $pagination = $this->pagination($limit, $offset);

        $query = sprintf(
            'SELECT * FROM %s ORDER BY %s %s%s',
            $this->tableName(),
            $orderBy,
            $this->direction($ascDesc),
            $pagination['sql']
        );

        return $this->executeQuery($query, $pagination['parameters']);
    }

    public function showAllLimitDesc(string $orderBy, int $limit): PDOStatement
    {
        $this->assertIdentifier($orderBy);

        if ($limit < 1) {
            throw new InvalidArgumentException('The limit must be greater than zero.');
        }

        return $this->executeQuery(
            sprintf('SELECT * FROM %s ORDER BY %s DESC LIMIT :limit', $this->tableName(), $orderBy),
            [':limit' => $limit]
        );
    }

    public function showAllWhere(
        string $orderBy,
        array $where,
        ?int $limit = null,
        ?int $offset = null,
        string $ascDesc = 'ASC'
    ): PDOStatement {
        $this->assertIdentifier($orderBy);
        $where = $this->normalizeFields($where);
        $conditions = implode(' AND ', array_map(
            static fn (string $field): string => $field . ' = :' . $field,
            $where
        ));
        $parameters = $this->parametersFor($where);
        $pagination = $this->pagination($limit, $offset);

        $query = sprintf(
            'SELECT * FROM %s WHERE %s ORDER BY %s %s%s',
            $this->tableName(),
            $conditions,
            $orderBy,
            $this->direction($ascDesc),
            $pagination['sql']
        );

        return $this->executeQuery($query, $parameters + $pagination['parameters']);
    }

    public function showFieldsUnion(
        string $orderBy,
        string $table1,
        string $table2,
        array $fields
    ): PDOStatement {
        $this->assertIdentifier($orderBy);
        $this->assertIdentifier($table1);
        $this->assertIdentifier($table2);
        $fields = $this->normalizeFields($fields);
        $columns = implode(', ', $fields);

        $query = sprintf(
            'SELECT %s FROM %s UNION SELECT %s FROM %s ORDER BY %s ASC',
            $columns,
            $this->tableName($table1),
            $columns,
            $this->tableName($table2),
            $orderBy
        );

        return $this->executeQuery($query);
    }

    public function itemExists(string $item): bool
    {
        $this->assertIdentifier($item);
        $query = sprintf(
            'SELECT 1 FROM %s WHERE %s = :%s LIMIT 1',
            $this->tableName(),
            $item,
            $item
        );

        return $this->executeQuery($query, [':' . $item => $this->valueFor($item)])->fetchColumn() !== false;
    }

    public function countItem(string $item): int
    {
        $this->assertIdentifier($item);
        $query = sprintf(
            'SELECT COUNT(*) FROM %s WHERE %s = :%s',
            $this->tableName(),
            $item,
            $item
        );

        return (int) $this->executeQuery($query, [':' . $item => $this->valueFor($item)])->fetchColumn();
    }

    public function countAll(): int
    {
        return (int) $this->executeQuery(
            sprintf('SELECT COUNT(*) FROM %s', $this->tableName())
        )->fetchColumn();
    }

    public function delete(string $field): bool
    {
        $this->assertIdentifier($field);
        $query = sprintf(
            'DELETE FROM %s WHERE %s = :%s',
            $this->tableName(),
            $field,
            $field
        );

        $this->executeQuery($query, [':' . $field => $this->valueFor($field)]);

        return true;
    }

    public function dropTable(string $tableToDelete): bool
    {
        $this->assertIdentifier($tableToDelete);
        $this->conn->exec('DROP TABLE ' . $this->tableName($tableToDelete));

        return true;
    }

    public function cloneTable(string $originalTable, string $newTable, string $primaryKey): bool
    {
        $originalTable = $this->tableName($originalTable);
        $newTable = $this->tableName($newTable);
        $this->assertIdentifier($primaryKey);

        $this->conn->beginTransaction();
        try {
            $this->conn->exec(sprintf('CREATE TABLE %s AS SELECT * FROM %s', $newTable, $originalTable));
            $this->conn->exec(sprintf('ALTER TABLE %s ADD PRIMARY KEY (%s)', $newTable, $primaryKey));
            $this->conn->commit();
        } catch (Throwable $exception) {
            $this->conn->rollBack();
            throw $exception;
        }

        return true;
    }

    public function chmod_R(string $path, int $fileMode): bool
    {
        if (!file_exists($path)) {
            return false;
        }

        if (is_file($path)) {
            return chmod($path, $fileMode);
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $item) {
            if (!chmod($item->getPathname(), $fileMode)) {
                return false;
            }
        }

        return chmod($path, $fileMode);
    }

    public function copyDirectory(string $source, string $destination): bool
    {
        if (!is_dir($source)) {
            return false;
        }

        if (!is_dir($destination) && !mkdir($destination, 0755, true) && !is_dir($destination)) {
            return false;
        }

        $sourceLength = strlen(rtrim($source, DIRECTORY_SEPARATOR));
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $relativePath = substr($item->getPathname(), $sourceLength + 1);
            $target = rtrim($destination, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $relativePath;

            if ($item->isDir()) {
                if (!is_dir($target) && !mkdir($target, 0755, true) && !is_dir($target)) {
                    return false;
                }
            } elseif (!copy($item->getPathname(), $target)) {
                return false;
            }
        }

        return true;
    }

    public function rmdir_recursive(string $directory): bool
    {
        if (!is_dir($directory)) {
            return false;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $item) {
            if ($item->isDir()) {
                rmdir($item->getPathname());
            } else {
                unlink($item->getPathname());
            }
        }

        return rmdir($directory);
    }

    public function commaToPoint(string|int|float $number): string
    {
        return str_replace(',', '.', (string) $number);
    }

    public function pointToComma(string|int|float $number): string
    {
        return str_replace('.', ',', (string) $number);
    }

    public function getBaseUrlBefore(string $stopDir = 'admin'): string
    {
        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (int) ($_SERVER['SERVER_PORT'] ?? 0) === 443;
        $protocol = $https ? 'https://' : 'http://';
        $host = (string) ($_SERVER['HTTP_HOST'] ?? 'localhost');
        $uri = parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH) ?: '/';
        $segments = explode('/', trim($uri, '/'));
        $basePath = [];

        foreach ($segments as $segment) {
            if ($segment === $stopDir) {
                break;
            }
            if ($segment !== '') {
                $basePath[] = $segment;
            }
        }

        return $protocol . $host . '/' . ($basePath === [] ? '' : implode('/', $basePath) . '/');
    }

    private function normalizeFields(array $fields): array
    {
        if ($fields === []) {
            throw new InvalidArgumentException('At least one field is required.');
        }

        $normalized = array_values(array_map(static fn ($field): string => (string) $field, $fields));
        foreach ($normalized as $field) {
            $this->assertIdentifier($field);
        }

        return $normalized;
    }

    private function parametersFor(array $fields): array
    {
        $parameters = [];
        foreach ($fields as $field) {
            $parameters[':' . $field] = $this->valueFor($field);
        }

        return $parameters;
    }

    private function direction(string $direction): string
    {
        $direction = strtoupper($direction);
        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            throw new InvalidArgumentException('Sort direction must be ASC or DESC.');
        }

        return $direction;
    }

    private function pagination(?int $limit, ?int $offset): array
    {
        if ($limit !== null && $limit < 0 || $offset !== null && $offset < 0) {
            throw new InvalidArgumentException('Pagination values cannot be negative.');
        }

        if ($limit === null && $offset === null) {
            return ['sql' => '', 'parameters' => []];
        }

        $sql = $limit === null
            ? ' LIMIT 18446744073709551615'
            : ' LIMIT :limit';
        if ($offset !== null) {
            $sql .= ' OFFSET :offset';
        }

        $parameters = [];
        if ($limit !== null) {
            $parameters[':limit'] = $limit;
        }
        if ($offset !== null) {
            $parameters[':offset'] = $offset;
        }

        return ['sql' => $sql, 'parameters' => $parameters];
    }
}
