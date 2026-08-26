<?php
declare(strict_types=1);

class Auth extends Common
{
    public $table = 'accounts';
    public $username;
    public $password;
    public $email;
    public $avatar;
    public $last_login;
    public $token;
    public $expDate;
    public $auth_token;

    public function emailExists(): bool
    {
        if (!is_string($this->email) || filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }

        $query = sprintf(
            'SELECT id, username, password, email, avatar, last_login FROM %s WHERE email = :email LIMIT 1',
            $this->tableName()
        );
        $row = $this->executeQuery($query, [':email' => $this->email])->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return false;
        }

        $this->id = $row['id'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->email = $row['email'];
        $this->avatar = $row['avatar'];
        $this->last_login = $row['last_login'];

        return true;
    }

    public function updateLog(string $time): bool
    {
        $query = sprintf('UPDATE %s SET last_login = :last_login WHERE id = :id', $this->tableName());
        $this->executeQuery($query, [':last_login' => $time, ':id' => $this->id]);

        return true;
    }

    public function checkCookie(): int
    {
        $query = sprintf(
            'SELECT 1 FROM %s WHERE id = :id AND auth_token = :auth_token LIMIT 1',
            $this->tableName()
        );

        return $this->executeQuery($query, [
            ':id' => $this->id,
            ':auth_token' => $this->auth_token,
        ])->fetchColumn() === false ? 0 : 1;
    }
}
