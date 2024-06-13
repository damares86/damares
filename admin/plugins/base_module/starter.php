<?php

require '../vendor/autoload.php';		// If installed via composer
$debug = new \bdk\Debug(array(
	'collect' => true,
	'output' => true,
));

// get base configuration from damares

include("../../class/Database.php");
include("../../class/Common.php");
include("../../class/Plugin.php");

require "../core/prefix.php";

$database = new Database();
$db = $database->getConnection();
$plugin = new Plugin($db);

// here it's possibile to add some extra operations for the installation

if ($op == 'add') {

	// operations during the installation
	
}else if($op == 'rm'){
	
	// operations during the remove
	
}
require "config.php";
