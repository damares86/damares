<?php
// require '../admin/vendor/autoload.php';		// If installed via composer
// $debug = new \bdk\Debug(array(
// 	'collect' => true,
// 	'output' => true,
// ));


spl_autoload_register('autoloader');

function autoloader($class){
	include("../admin/class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

require "../admin/inc/class_initialize.php" ;

$setting->name="lang" ;
$stmt = $setting->showByName();
$lang = $stmt['value'];

foreach (glob("../admin/locale/$lang/*.php") as $row){
    require "$row";
}
?>