<?php
declare(strict_types=1);

class Plugin extends Common
{
    public $table = 'plugins';
    public $pluginname;
    public $description;
    public $installed;
    public $active;

    public function showPluginnameById(): string|false
    {
        $query = sprintf('SELECT pluginname FROM %s WHERE id = :id LIMIT 1', $this->tableName());
        $row = $this->executeQuery($query, [':id' => $this->id])->fetch(PDO::FETCH_ASSOC);

        return $row === false ? false : (string) $row['pluginname'];
    }

    public function isActive(): int|false
    {
        $query = sprintf('SELECT active FROM %s WHERE pluginname = :pluginname LIMIT 1', $this->tableName());
        $row = $this->executeQuery($query, [':pluginname' => $this->pluginname])->fetch(PDO::FETCH_ASSOC);

        return $row === false ? false : (int) $row['active'];
    }
}
