<?php
    require '../admin/vendor/autoload.php';		// If installed via composer
    $debug = new \bdk\Debug(array(
    	'collect' => true,
    	'output' => true,
    ));

spl_autoload_register('autoloader');

function autoloader($class){
	include("../admin/class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

// recall of all the classes
$files=glob("../admin/class/*.php", GLOB_BRACE);
rsort($files); 
// creation of the file with all the initialization of the classes
if(!is_file('../admin/inc/class_initialize.php')){
    $file_handle = fopen('../admin/inc/class_initialize.php', 'w');
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
chmod('../admin/inc/class_initialize.php',0777);
}

require "../admin/inc/class_initialize.php" ;

if(isset($_COOKIE['damares-login'])){
    $pieces = explode(",", $_COOKIE['damares-login']);
    $auth->id = $pieces[0];
    $id = $pieces[0];
    $auth->auth_token = $pieces[1];
    if($auth->checkCookie()>0){
                     
        session_start();
        $accountroles->account_id = $id; 
        
        $account->id = $id ;

        $stmt = $account->showAllWhere('id',['id']);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $role_id = $accountroles->showAccountRolesId();
        $role->id = $role_id ;
        
        // set session data
        $_SESSION['loggedin'] = true ;
        $_SESSION['account_id'] = $row['id'];
        $_SESSION['role_id'] = $role_id;
        $_SESSION['rolename'] = $role->showRolenameById();
        $_SESSION['username'] = $row['username'];
        $_SESSION['avatar'] = $row['avatar'];
        
        // update the login log time
        $time=date("Y.m.d, G:i:s");
        $auth->updateLog($time);
        
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

        if($role->id == 1 || $role->id == 2 ){
            header("Location: ../admin/");
            exit;
        }else{
            header("Location: ../home.php?log=yes");
            exit;
        }
      
    }
}

$setting->name="lang" ;
$stmt = $setting->showByName();
$lang = $stmt['value'];

foreach (glob("../admin/locale/$lang/*.php") as $row){
    require "$row";
}


$plugin->pluginname = "account_register" ;
$reg = "";



if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
    $reg = true ;
}



?>

<!DOCTYPE html>
<html lang="en">
    
    <head>
    <!--
    ##############    Salomon    ###############
    #                                          #
    #           A multipurpose WebApp          #
    #               by DM WebLab               #
    #   Website: https://www.dmweblab.com      #
    #   GitHub: https://github.com/damares86   #
    #                                          #
    ############################################
    -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Salomon - WebApp for conventions and conferences">
  <meta name="author" content="DM WebLab">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

  <!-- <meta name="theme-color" content="#0134d4"> -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <!-- Title -->
  
  <!-- Favicon -->
  <link rel="icon" href="../assets/img/favicon.ico">
  <link rel="apple-touch-icon" href="img/icons/icon-96x96.png">
  <link rel="apple-touch-icon" sizes="152x152" href="../assets/img/icons/icon-152x152.png">
  <link rel="apple-touch-icon" sizes="167x167" href="../assets/img/icons/icon-167x167.png">
  <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/icons/icon-180x180.png">
  
  <!-- Style CSS -->
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="../assets/css/custom.css">
  
  <!-- Web App Manifest -->
  <link rel="manifest" href="../manifest.json">
