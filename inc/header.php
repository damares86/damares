<?php
require 'vendor/autoload.php';		// If installed via composer
$debug = new \bdk\Debug(array(
	'collect' => true,
	'output' => true,
));

// check if database is configured

if(!is_file('class/Database.php')){
  require "inc/dbdata.php";
  exit;
}

session_start();

if (!isset($_SESSION['loggedin']) && !isset($_SESSION['account_id'])) {
  require "inc/check_cookie.php" ;
  header('Location: ../login/auth-login.php?err=noLogin');
  exit;
}else if(isset($_COOKIE['damares-login'])){

  $pieces = explode(",", $_COOKIE['damares-login']);
  $auth->id = $pieces[0];
  $id = $pieces[0];
  $auth->auth_token = $pieces[1];

  if(!$auth->checkCookie()>0){
    header("Location: ../login/auth-login.php?err=noLogin");
    exit;
  }

  $role->id = $_SESSION['role_id'] ;

  $plugin->pluginname = "role_redirect" ;
  
  if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
      $stmt = $role->showAllWhere('id',['id']);
      foreach($stmt as $row){
          if($row['redirect']!="none"){
              header("Location: ".$row['redirect']."");
              exit;
          }
      }
  }

}

require "core/prefix.php";
require __DIR__."/version.php";

spl_autoload_register('autoloader');

function autoloader($class){
    include("class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

// recall of all the classes
$files=glob("class/*.php", GLOB_BRACE);
rsort($files); 

// creation of the file with all the initialization of the classes
if(!is_file('inc/class_initialize.php')){
    $file_handle = fopen('inc/class_initialize.php', 'w');
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
chmod('inc/class_initialize.php',0777);
}

include "inc/class_initialize.php";

// get the p from url if exists
if(filter_input(INPUT_GET,"p")){
    $page = filter_input(INPUT_GET,"p");
}else{
    $page = "dashboard";
}

$pageLabel = "" ;
$pageId = "" ;

$parent = $section->showByLink($page,'sectionParent');
$child = $section->showByLink($page,'sectionChild');

if($parent){
    $pageLabel = $parent['label'] ;
    $pageLink = $parent['link'] ;
    $pageId = $parent['id'] ;
}else if($child){
    $pageLabel = $child['label'] ;
    $pageLink = $child['link'] ;
    $pageId = $child['id'] ;
}else{
    $pageLabel = "" ;
    $pageLink = "" ;
    $pageId = "" ;
}

$setting->name="lang" ;
$stmt = $setting->showByName();
$lang = $stmt['value'];

foreach (glob("locale/$lang/*.php") as $row){
    require "$row";
}


?>