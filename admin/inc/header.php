<?php
// require 'vendor/autoload.php';		// If installed via composer
// $debug = new \bdk\Debug(array(
// 	'collect' => true,
// 	'output' => true,
// ));

// check if database is configured

if(!is_file('class/Database.php')){
  require "inc/dbdata.php";
  exit;
}

session_start();


// check if the user is logged in
require __DIR__."/config.php";

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


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?=$common_dashboard?> - damares</title>

    <!--
    ##############    Damares    ###############
    #                                          #
    #    A backend project by DM WebLab        #
    #   Website: https://www.dmweblab.com      #
    #   GitHub: https://github.com/damares86   #
    #                                          #
    ############################################
    -->
    
    <link rel="stylesheet" href="assets/css/main/app.css" />
    <link rel="stylesheet" href="assets/css/main/app-dark.css" />
    <link
      rel="shortcut icon"
      href="assets/images/logo/favicon.ico"
      type="image/x-icon"
    />
    <link
      rel="shortcut icon"
      href="assets/images/logo/favicon.ico"
      type="image/png"
    />
    <link
      rel="stylesheet"
      href="assets/extensions/choices.js/public/assets/styles/choices.css"
    />
    <link rel="stylesheet" href="assets/css/shared/iconly.css" />
    <link rel="stylesheet" href="assets/css/custom.css" />
  </head>