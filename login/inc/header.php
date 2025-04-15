<?php
// require '../admin/vendor/autoload.php';		// If installed via composer
// $debug = new \bdk\Debug(array(
// 	'collect' => true,
// 	'output' => true,
// ));
if (!is_file('../admin/class/Database.php')) {
  require "../admin/inc/dbdata.php";
  exit;
}

spl_autoload_register('autoloader');

function autoloader($class)
{
  include("../admin/class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

// recall of all the classes
$files = glob("../admin/class/*.php", GLOB_BRACE);
rsort($files);

require "../admin/inc/class_initialize.php";

session_start();

// if (!isset($_SESSION['loggedin']) && !isset($_SESSION['account_id'])) {
//   require "../admin/inc/check_cookie.php";
//   header('Location: ../login/auth-login.php?err=noLogin');
//   exit;
// } else if (isset($_COOKIE['damares-login'])) {
//   $pieces = explode(",", $_COOKIE['damares-login']);
//   $auth->id = $pieces[0];
//   $id = $pieces[0];
//   $auth->auth_token = $pieces[1];

//   if ($auth->checkCookie() > 0) {
//     header("Location: ../login/auth-login.php?err=noLogin");
//     exit;
//   }
// }

// if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] ==1){

//   if($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2){
//     header("Location: ../admin");
//     exit;
//   }


//   $plugin->pluginname = "role_redirect" ;

//   if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
//       $role->id = $_SESSION['role_id'] ;
//       $stmt = $role->showAllWhere('id',['id']);
//       foreach($stmt as $row){
//           if($row['redirect']!="none"){
//               header("Location: ".$row['redirect']."");
//               exit;
//           }
//       }
//   }

// }else if(isset($_COOKIE['damares-login'])){

$setting->name = "role_redirect";
$stmt = $setting->showAllWhere('id', ['name']);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$redir = $row['value'];

if (isset($_COOKIE['damares-login'])) {
  $pieces = explode(",", $_COOKIE['damares-login']);
  $auth->id = $pieces[0];
  $id = $pieces[0];
  $auth->auth_token = $pieces[1];
  if ($auth->checkCookie() > 0) {

    session_start();
    $accountroles->account_id = $id;

    $account->id = $id;

    $stmt = $account->showAllWhere('id', ['id']);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $role_id = $accountroles->showAccountRolesId();
    $role->id = $role_id;

    // set session data
    $_SESSION['loggedin'] = true;
    $_SESSION['account_id'] = $row['id'];
    $_SESSION['internal'] = 1;
    $_SESSION['role_id'] = $role_id;
    $_SESSION['rolename'] = $role->showRolenameById();
    $_SESSION['username'] = $row['username'];
    $_SESSION['avatar'] = $row['avatar'];

    // update the login log time
    $time = date("Y.m.d, G:i:s");
    $auth->updateLog($time);

    $plugin->pluginname = "role_redirect";

    if ($redir == 1) {
      $stmt = $role->showAllWhere('id', ['id']);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      extract($row);
      if ($row['redirect'] != "none") {
        header("Location: " . $row['redirect'] . "");
        exit;
      } else {
        header("Location: ../admin/");
        exit;
      }
    }
  }
} else if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
  if ($redir == 1) {
    $stmt = $role->showAllWhere('id', ['id']);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);
    if ($row['redirect'] != "none") {
      header("Location: " . $row['redirect'] . "");
      exit;
    } else {
      header("Location: ../admin/");
      exit;
    }
  }
}
$setting->name = "lang";
$stmt = $setting->showByName();
$lang = $stmt['value'];

foreach (glob("../admin/locale/$lang/*.php") as $row) {
  require "$row";
}


$plugin->pluginname = "account_register";
$reg = "";

$op = "";

if (filter_input(INPUT_GET, "op")) {
  $op = filter_input(INPUT_GET, "op");
}

if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {
  $reg = true;
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $login_titlebar ?> - damares</title>
  <link rel="stylesheet" href="../admin/assets/css/main/app.css" />
  <link rel="stylesheet" href="../admin/assets/css/pages/auth.css" />
  <link rel="stylesheet" href="../admin/assets/css/custom.css">
  <link
    rel="shortcut icon"
    href="../admin/assets/images/logo/favicon.ico"
    type="image/x-icon" />
  <link
    rel="shortcut icon"
    href="../admin/assets/images/logo/favicon.ico"
    type="image/png" />

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
  <div id="auth">
    <div class="row h-100">
      <div class="col-lg-5 col-12">
        <div id="auth-left">
          <div class="auth-logo">
            <a href="../index.php"><img src="../admin/assets/images/logo/damares_logo.png" alt="Logo" /></a>
          </div>

          <?php

          // require of all alert files
          require "inc/alert.php";
          ?>