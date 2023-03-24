<?php
require '../vendor/autoload.php';		// If installed via composer
$debug = new \bdk\Debug(array(
	'collect' => true,
	'output' => true,
));

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

$module = $plugin->showAll('id');
foreach($module as $row){
    $plugin->pluginname = $row['pluginname'] ;
        if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
            $scan = scandir("plugins/".$row['pluginname']."/class");
            $exclude = array('..', '.','.gitkeep');
            foreach($scan as $file){
            if (!in_array($file,$exclude)) {
                $item = pathinfo($file);
                include "class/plugin/".$item['basename']."";
            }
        }
    }
}
