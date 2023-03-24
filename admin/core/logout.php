<?php
session_start();
session_destroy();

spl_autoload_register('autoloader');

function autoloader($class){
	include("../admin/class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

require "../admin/inc/class_initialize.php" ;

if(isset($_COOKIE['damares-login'])){
    $pieces = explode(",", $_COOKIE['damares-login']);
    $account->id = $pieces[0];
    $account->auth_token = $pieces[1];

    $account->update(['auth_token'],'id');

    setcookie("damares-login", "", time() - 3600);
}


// Redirect to the login page:
header('Location: ../index.php');
?>