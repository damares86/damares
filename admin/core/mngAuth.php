<?php

spl_autoload_register('autoloader');

function autoloader($class){
	include("../class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

include "../inc/class_initialize.php";
// get the form data
$postpass = $_POST['password'];

$auth->email = $_POST['email'];


// check if the given email exist in db
$email_exists = $auth->emailExists();

// match the email and the password
if($email_exists && password_verify($postpass,$auth->password)){
    
    session_start();
    
    $accountroles->account_id = $auth->id; 

    
    $role_id = $accountroles->showAccountRolesId();
    $role->id = $role_id ;
    
    // set session data
    $_SESSION['loggedin'] = true ;
    $_SESSION['account_id'] = $auth->id;
    $_SESSION['role_id'] = $role_id;
    $_SESSION['rolename'] = $role->showRolenameById();
    $_SESSION['username'] = $auth->username;
    $_SESSION['avatar'] = $auth->avatar;
    
    // update the login log time
    $time=date("Y.m.d, G:i:s");
    $auth->updateLog($time);

    $plugin->pluginname = "role_redirect" ;
    $redir = $plugin->itemExists('pluginname');    
           
    if($redir){
        $stmt = $role->showAllWhere('id',['id']);
        foreach($stmt as $row){
            header("Location: ".$row['redirect']."");
            exit;
        }
    }

    $plugin->pluginname = "file_for_role" ;
    $ffr = $plugin->itemExists('pluginname');    
           
    if($ffr){
        // TODO
        // $stmt = $role->showAllWhere('id',['id']);
        // foreach($stmt as $row){
        //     header("Location: ".$row['redirect']."");
        //     exit;
        // }
    }

    header("Location: ../");
    exit;
    
} else {
    
    header("Location: ../../auth-login.php?msg=errUserPsw");
    exit;
}
