<?php

require '../vendor/autoload.php';		// If installed via composer
$debug = new \bdk\Debug(array(
	'collect' => true,
	'output' => true,
));

session_start();
session_destroy();

spl_autoload_register('autoloader');

function autoloader($class){
	include("../class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

require "../inc/class_initialize.php" ;

if(isset($_COOKIE['damares-login'])){
    $pieces = explode(",", $_COOKIE['damares-login']);
    echo "pieces<br>";
    print_r($pieces);
    $id = $pieces[0];
    $account->id = $pieces[0];
    $token = "none";
    $account->auth_token = "none";


    $account->update(['auth_token'],'id');

    unset($_COOKIE['damares-login']);
    setcookie("damares-login", '', time() - 3600,"/");
}


// Redirect to the login page:
header('Location: ../index.php');
?>