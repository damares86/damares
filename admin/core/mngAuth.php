<?php
declare(strict_types=1);

require_once __DIR__ . '/../core/prefix.php';

spl_autoload_register(static function (string $class): void {
    $classFile = __DIR__ . '/../class/' . $class . '.php';
    if (is_file($classFile)) {
        require_once $classFile;
    }
});

$database = new Database();
$db = $database->getConnection();
require_once __DIR__ . '/../inc/class_initialize.php';

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) ?: '';
$password = (string) (filter_input(INPUT_POST, 'password') ?? '');
$remember = isset($_POST['remember']);

$auth->email = $email;

if (!$auth->emailExists() || !password_verify($password, (string) $auth->password)) {
    header('Location: ../../index.php?err=errUserPsw');
    exit;
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
session_regenerate_id(true);

if ($remember) {
    $token = bin2hex(random_bytes(32));
    $account->email = $email;
    $account->auth_token = $token;
    $account->update(['auth_token'], 'email');

    setcookie('damares-login', $auth->id . ',' . $token, [
        'expires' => time() + (60 * 60 * 24 * 365 * 10),
        'path' => '/',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

$accountroles->account_id = $auth->id;
$roleId = $accountroles->showAccountRolesId();
if ($roleId === false) {
    header('Location: ../../index.php?err=errUserPsw');
    exit;
}

$role->id = $roleId;
$_SESSION['loggedin'] = true;
$_SESSION['account_id'] = $auth->id;
$_SESSION['internal'] = 1;
$_SESSION['role_id'] = $roleId;
$_SESSION['rolename'] = $role->showRolenameById();
$_SESSION['username'] = $auth->username;
$_SESSION['avatar'] = $auth->avatar;

$auth->updateLog(date('Y-m-d H:i:s'));

$setting->name = 'role_redirect';
$redirectSetting = $setting->showByName();
if ((int) ($redirectSetting['value'] ?? 0) === 1) {
    $roleData = $role->showAllWhere('id', ['id'])->fetch(PDO::FETCH_ASSOC);
    $redirect = (string) ($roleData['redirect'] ?? 'none');
    if ($redirect !== 'none') {
        header('Location: ' . $redirect);
        exit;
    }
}

header('Location: ../');
exit;
