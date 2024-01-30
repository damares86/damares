<?php

require '../vendor/autoload.php';		// If installed via composer
$debug = new \bdk\Debug(array(
	'collect' => true,
	'output' => true,
));

include("../../class/Database.php");
include("../../class/Common.php");
include("../../class/Plugin.php");

require "../core/prefix.php";

$database = new Database();
$db = $database->getConnection();
$plugin = new Plugin($db);

require "config.php" ;
