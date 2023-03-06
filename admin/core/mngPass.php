<?php
require '../vendor/autoload.php';		// If installed via composer
$debug = new \bdk\Debug(array(
	'collect' => true,
	'output' => true,
));

spl_autoload_register('autoloader');

function autoloader($class){
	include("../class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

include "../inc/class_initialize.php";

$email = filter_input(INPUT_GET,"email");
print_r($email);
exit;