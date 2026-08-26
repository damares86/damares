<?php
declare(strict_types=1);

class AccountRoles extends Common
{
    public $table = 'accountsRoles';
    public $account_id;
    public $role_id;
    public $redirect;

    public function showAccountRolesId(): int|false
    {
        $query = sprintf(
            'SELECT role_id FROM %s WHERE account_id = :account_id ORDER BY role_id ASC LIMIT 1',
            $this->tableName()
        );
        $row = $this->executeQuery($query, [':account_id' => $this->account_id])->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return false;
        }

        return $this->role_id = (int) $row['role_id'];
    }

    public function showRolesAccountId(): PDOStatement
    {
        return $this->executeQuery(
            sprintf('SELECT account_id FROM %s WHERE role_id = :role_id', $this->tableName()),
            [':role_id' => $this->role_id]
        );
    }

    public function countRoleAccounts(): int
    {
        return $this->countItem('role_id');
    }
}
