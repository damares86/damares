<?php
declare(strict_types=1);

class Section extends Common
{
    public $table_parent = 'sectionParent';
    public $table_child = 'sectionChild';
    public $parent_id;
    public $link;
    public $label;
    public $icon;
    public $show_menu;

    public function countChild(int|string $id): int
    {
        $query = sprintf('SELECT COUNT(*) FROM %s WHERE parent_id = :id', $this->tableName($this->table_child));

        return (int) $this->executeQuery($query, [':id' => $id])->fetchColumn();
    }

    public function insertParent(): bool
    {
        $query = sprintf(
            'INSERT INTO %s (link, label, icon) VALUES (:link, :label, :icon)',
            $this->tableName($this->table_parent)
        );
        $this->executeQuery($query, [
            ':link' => $this->link,
            ':label' => $this->label,
            ':icon' => $this->icon,
        ]);

        return true;
    }

    public function insertChild(): bool
    {
        $query = sprintf(
            'INSERT INTO %s (link, label, icon, parent_id, show_menu) VALUES (:link, :label, :icon, :parent_id, :show_menu)',
            $this->tableName($this->table_child)
        );
        $this->executeQuery($query, [
            ':link' => $this->link,
            ':label' => $this->label,
            ':icon' => $this->icon,
            ':parent_id' => $this->parent_id,
            ':show_menu' => $this->show_menu,
        ]);

        return true;
    }

    public function showByLink(string $link, string $table): array|false
    {
        $query = sprintf('SELECT * FROM %s WHERE link = :link LIMIT 1', $this->tableName($table));

        return $this->executeQuery($query, [':link' => $link])->fetch(PDO::FETCH_ASSOC);
    }

    public function showById(string $table): array|false
    {
        $query = sprintf('SELECT * FROM %s WHERE id = :id LIMIT 1', $this->tableName($table));

        return $this->executeQuery($query, [':id' => $this->id])->fetch(PDO::FETCH_ASSOC);
    }

    public function showAllChild(): PDOStatement
    {
        return $this->executeQuery(
            sprintf('SELECT * FROM %s WHERE parent_id = :parent_id ORDER BY id ASC', $this->tableName($this->table_child)),
            [':parent_id' => $this->parent_id]
        );
    }

    public function deleteByLink(string $table): bool
    {
        $query = sprintf('DELETE FROM %s WHERE link = :link', $this->tableName($table));
        $this->executeQuery($query, [':link' => $this->link]);

        return true;
    }
}
