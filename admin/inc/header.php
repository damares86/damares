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

// check if the user is logged in

if (!isset($_SESSION['loggedin']) && !isset($_SESSION['account_id'])) {
  header('Location: ../auth-login.php?msg=noLogin');
  exit;
}

require __DIR__."/config.php";

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - damares</title>

    <link rel="stylesheet" href="assets/css/main/app.css" />
    <link rel="stylesheet" href="assets/css/main/app-dark.css" />
    <link
      rel="shortcut icon"
      href="assets/images/logo/favicon.svg"
      type="image/x-icon"
    />
    <link
      rel="shortcut icon"
      href="assets/images/logo/favicon.png"
      type="image/png"
    />
    <link
      rel="stylesheet"
      href="assets/extensions/choices.js/public/assets/styles/choices.css"
    />
    <link rel="stylesheet" href="assets/css/shared/iconly.css" />
    <link rel="stylesheet" href="assets/css/custom.css" />
  </head>