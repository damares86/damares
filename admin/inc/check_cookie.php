<?php

if(isset($_COOKIE['damares-login'])){
    $pieces = explode(",", $_COOKIE['damares-login']);
    $auth->id = $pieces[0];
    $auth->auth_token = $pieces[1];

    if($auth->checkCookie()){
        
        if($email_exists = $auth->emailExists()){
         
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
            
            if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
                $stmt = $role->showAllWhere('id',['id']);
                foreach($stmt as $row){
                    if($row['redirect']!="none"){
                        header("Location: ".$row['redirect']."");
                        exit;
                    }
                }
            }

            header("Location: ../admin/");
            exit;
        }
    }
}