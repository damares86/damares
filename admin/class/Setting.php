<?php
declare(strict_types=1);

class Setting extends Common
{
    public $table = 'settings';
    public $name;
    public $value;

    public function showByName(): array|false
    {
        $query = sprintf('SELECT * FROM %s WHERE name = :name ORDER BY id ASC LIMIT 1', $this->tableName());

        return $this->executeQuery($query, [':name' => $this->name])->fetch(PDO::FETCH_ASSOC);
    }

    public function updateValue(): bool
    {
        $query = sprintf('UPDATE %s SET value = :value WHERE name = :name', $this->tableName());
        $this->executeQuery($query, [':value' => $this->value, ':name' => $this->name]);

        return true;
    }
}
