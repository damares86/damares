<?php


session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: ../../login/auth-login.php?err=noLogin');
    exit;
}

spl_autoload_register('autoloader');

function autoloader($class){
	include("../class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

include "../inc/class_initialize.php";

$setting->name = "debug" ;
$dbg = $setting->showAllWhere('id',['name']);
$row = $dbg->fetch(PDO::FETCH_ASSOC);
extract($row);

if($row['value']==1){
	require '../vendor/autoload.php';		// If installed via composer
	$debug = new \bdk\Debug(array(
		'collect' => true,
		'output' => true,
	));
}