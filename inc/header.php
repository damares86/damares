<?php
require 'admin/vendor/autoload.php';		// If installed via composer
$debug = new \bdk\Debug(array(
	'collect' => true,
	'output' => true,
));

// check if database is configured

if(!is_file('admin/class/Database.php')){
  require "admin/inc/dbdata.php";
  exit;
}

require "admin/core/prefix.php";
require "admin/inc/version.php";

spl_autoload_register('autoloader');

function autoloader($class){
    include("admin/class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

// recall of all the classes
$files=glob("admin/class/*.php", GLOB_BRACE);
rsort($files); 

// creation of the file with all the initialization of the classes
if(!is_file('admin/inc/class_initialize.php')){
    $file_handle = fopen('admin/inc/class_initialize.php', 'w');
    fwrite($file_handle, '<?php');
    fwrite($file_handle, "\n");
    foreach ($files as $filename) {
        $nomefile = pathinfo($filename);
    $file=$nomefile['filename'];
    $file_var = strtolower($file);
    fwrite($file_handle, '$'.$file_var.' = new '.$file.'($db);');
    fwrite($file_handle, "\n");
}
if($prefix){
    fwrite($file_handle,'$common->prx = "'.$prefix.'_";') ;
    fwrite($file_handle, "\n");
}
fwrite($file_handle,"?>");
chmod('admin/inc/class_initialize.php',0777);
}

include "admin/inc/class_initialize.php";

session_start();



if (!isset($_SESSION['loggedin']) && !isset($_SESSION['account_id'])) {
  require "admin/inc/check_cookie.php" ;
  header('Location: login/auth-login.php?err=noLogin');
  exit;
}else if(isset($_COOKIE['damares-login'])){

  $pieces = explode(",", $_COOKIE['damares-login']);
  $auth->id = $pieces[0];
  $id = $pieces[0];
  $auth->auth_token = $pieces[1];

  if(!$auth->checkCookie()>0){
    header("Location: login/auth-login.php?err=noLogin");
    exit;
  }
}

$setting->name="lang" ;
$stmt = $setting->showByName();
$lang = $stmt['value'];

foreach (glob("locale/$lang/*.php") as $row){
    require "$row";
}

// prendo il nome del file (con estensione)
$file = basename($_SERVER['PHP_SELF']);
$page_name = pathinfo($file, PATHINFO_FILENAME);
$page_name=str_replace("_"," ", $page_name);
// metto la prima lettera maiuscola
$page_name=ucfirst($page_name);

if($file=="index.php"){
  $page_name = "Home";
}

?>

<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta http-equiv="x-ua-compatible" content="IE=edge">
	<meta name="author" content="DM WebLab">
	<meta name="description" content="WebApp Giornate Cardiologiche Torinesi">

	<!-- Font Imports -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">

	<!-- Core Style -->
	<link rel="stylesheet" href="assets/css/style.css">
	<!-- Font Icons -->
	<link rel="stylesheet" href="assets/css/font-icons.css">
	<!-- Plugins/Components CSS -->
	<link rel="stylesheet" href="assets/css/components/bs-switches.css">
	<link rel="stylesheet" href="assets/css/main.css">

	<!-- Custom CSS -->
	<link rel="stylesheet" href="assets/css/custom.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Document Title
	============================================= -->
	<title><?=$page_name?> - Giornate Cardiologiche Torinesi</title>

</head>