<?php

require __DIR__."/coreConfig.php";

// get the form data
$postpass = $_POST['password'];

$auth->email = $_POST['email'];


// check if the given email exist in db
$email_exists = $auth->emailExists();

// match the email and the password
if($email_exists && password_verify($postpass,$auth->password)){
    
    session_start();
    
    $accountroles->accounts_id = $auth->id; 

    
    $role_id = $accountroles->showAccountRolesId();
    $role->id = $role_id ;
    
    // set session data
    $_SESSION['loggedin'] = true ;
    $_SESSION['account_id'] = $auth->id;
    $_SESSION['role_id'] = $role_id;
    $_SESSION['rolename'] = $role->showRolenameById();
    $_SESSION['username'] = $auth->username;
    
    
    // update the login log time
    $time=date("Y.m.d, G:i:s");
    $auth->updateLog($time);
           
    header("Location: ../");
    exit;
    
} else {
    
    header("Location: ../../auth-login.php?msg=errUserPsw");
    exit;
}
