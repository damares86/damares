<?php
declare(strict_types=1);

class Role extends Common
{
    public $table = 'roles';
    public $rolename;
    public $redirect;

    public function showRolenameById(): string|false
    {
        $query = sprintf('SELECT rolename FROM %s WHERE id = :id LIMIT 1', $this->tableName());
        $row = $this->executeQuery($query, [':id' => $this->id])->fetch(PDO::FETCH_ASSOC);

        return $row === false ? false : (string) $row['rolename'];
    }

    public function showIdByRolename(): PDOStatement
    {
        return $this->executeQuery(
            sprintf('SELECT id FROM %s WHERE rolename = :rolename', $this->tableName()),
            [':rolename' => $this->rolename]
        );
    }

    public function roleExists(): bool
    {
        return $this->itemExists('rolename');
    }
}
