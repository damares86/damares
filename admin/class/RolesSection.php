<?php
declare(strict_types=1);

class RolesSection extends Common
{
    public $table = 'rolesSection';
    public $section_id;
    public $role_id;

    public function insertRoleSection(): bool
    {
        $query = sprintf(
            'INSERT INTO %s (section_id, role_id) VALUES (:section_id, :role_id)',
            $this->tableName()
        );
        $this->executeQuery($query, [
            ':section_id' => $this->section_id,
            ':role_id' => $this->role_id,
        ]);

        return true;
    }

    public function showAllPermission(): PDOStatement
    {
        return $this->executeQuery(
            sprintf('SELECT * FROM %s WHERE role_id = :role_id ORDER BY id ASC', $this->tableName()),
            [':role_id' => $this->role_id]
        );
    }
}
