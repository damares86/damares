<?php
// require 'admin/vendor/autoload.php';		// If installed via composer
// $debug = new \bdk\Debug(array(
// 	'collect' => true,
// 	'output' => true,
// ));

// if(!is_file('../admin/class/Database.php')){
//   require "../admin/inc/dbdata.php";
//   exit;
// }

spl_autoload_register('autoloader');

function autoloader($class)
{
  include("admin/class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

// recall of all the classes
$files = glob("admin/class/*.php", GLOB_BRACE);
rsort($files);

require "admin/inc/class_initialize.php";

session_start();
if (!isset($_SESSION['customer_loggedin'])) 
{

  require 'admin/inc/customer_check_cookie.php';
  // header('Location: login.php?err=noLogin');
  // exit;
}
else if (isset($_COOKIE['damares-customer-login']))
{
    $pieces = explode(",", $_COOKIE['damares-customer-login']);
    $customer->id = $pieces[0];
    $id = $pieces[0];
    $customer->auth_token = $pieces[1];
    
    if (!$customer->checkCookie() > 0) {
      header("Location: login.php?err=noLogin");
      exit;
    }
    
      // redirect tofix
      // $plugin->pluginname = "role_redirect";

      // if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {
      //   $stmt = $role->showAllWhere('id', ['id']);
      //   foreach ($stmt as $row) {
      //     if ($row['redirect'] != "none") {
      //       header("Location: " . $row['redirect'] . "");
      //       exit;
      //     }
      //   }
      // }

      // header("Location: index_xs.php");
      // exit;
   
  }

$setting->name = "lang";
$stmt = $setting->showByName();
$lang = $stmt['value'];

foreach (glob("admin/locale/$lang/*.php") as $row) {
  require "$row";
}


// $plugin->pluginname = "account_register" ;
// $reg = "";

// $op="";

// if(filter_input(INPUT_GET,"op")){
//   $op=filter_input(INPUT_GET,"op");
// }

// if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
//     $reg = true ;
// }



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - XStream Labs</title>
  <link rel="stylesheet" href="admin/assets/css/main/app.css" />
  <link rel="stylesheet" href="admin/assets/css/pages/auth.css" />
  <link rel="stylesheet" href="admin/assets/css/custom.css">
  <link rel="shortcut icon" href="admin/assets/images/logo/favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="admin/assets/images/logo/favicon.ico" type="image/png" />

  <!--
    ##############    Damares    ###############
    #                                          #
    #    A backend project by DM WebLab        #
    #   Website: https://www.dmweblab.com      #
    #   GitHub: https://github.com/damares86   #
    #                                          #
    ############################################
    -->

</head>

<body>
  <div class="container">
    <div class="row p-3">
      <div class="col-12 p-3 text-center">
        <a href="../index.php"><img src="admin/assets/images/logo/damares_logo.png" alt="Logo" class="w-25" /></a>
      </div>

    </div>