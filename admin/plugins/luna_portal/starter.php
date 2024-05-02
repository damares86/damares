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

$portal_dir = '../../portal/' ;

if(!is_dir($portal_dir)){
	$oldmask = umask(0);
	mkdir($portal_dir, 0777, true);
	umask($oldmask);
}

$json_dir = '../inc/luna_pages/' ;

if(!is_dir($portal_dir)){
	$oldmask = umask(0);
	mkdir($portal_dir, 0777, true);
	umask($oldmask);
}


// copy portal files
foreach (glob("../plugins/luna_portal/portal/*") as $row) {
    $item = pathinfo($row);
	
    if (copy('../plugins/luna_portal/portal/' . $item['basename'] . '', $portal_dir . $item['basename'] )) {
      chmod( $portal_dir . $item['basename'] . '', 0777);
    } else {
      $error++;
    }
  }

require "config.php" ;
