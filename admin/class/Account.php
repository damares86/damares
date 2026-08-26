<?php
declare(strict_types=1);

class Account extends Common
{
    public $table = 'accounts';
    public $username;
    public $email;
    public $password;
    public $avatar;
    public $last_login;
    public $token;
    public $expDate;
    public $auth_token;
    public $details;
    public $details_opt;

    public function getPswTmpData(): array|false
    {
        $query = sprintf(
            'SELECT * FROM %s WHERE token = :token AND email = :email LIMIT 1',
            $this->tableName('password_reset_temp')
        );

        return $this->executeQuery($query, [
            ':token' => $this->token,
            ':email' => $this->email,
        ])->fetch(PDO::FETCH_ASSOC);
    }

    public function getPswTmpDataByEmail(): array|false
    {
        $query = sprintf(
            'SELECT * FROM %s WHERE email = :email LIMIT 1',
            $this->tableName('password_reset_temp')
        );

        return $this->executeQuery($query, [':email' => $this->email])->fetch(PDO::FETCH_ASSOC);
    }

    public function getExpDate(): void
    {
        $row = $this->getPswTmpDataByEmail();
        $this->expDate = $row['expDate'] ?? null;
    }

    public function getLastLogin(): PDOStatement
    {
        return $this->executeQuery(
            sprintf('SELECT * FROM %s ORDER BY last_login DESC LIMIT 3', $this->tableName())
        );
    }
}
