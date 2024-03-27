<?php

if(isset($_COOKIE['damares-customer-login'])){
    $pieces = explode(",", $_COOKIE['damares-customer-login']);
    $auth->id = $pieces[0];
    $id = $pieces[0];
    $auth->auth_token = $pieces[1];
    if($auth->checkCookie()>0){
                     
        session_start();

        $customer->id = $id;
        $customer->table = 'customers';
  
        $stmt = $customer->showAllWhere('id', ['username']);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
  
        // last login update
        $time = date("Y.m.d, G:i:s");
        $customer->id = $id;
        $customer->last_login = $time;
        $customer->table = 'customers';
  
        $customer->update(['last_login'], 'id');
  
        $_SESSION['customer_loggedin'] = true;
        $_SESSION['customer_id'] = $row['id'];
        $_SESSION['customer_username'] = $username;
        $_SESSION['customer_name'] = $row['name'];
        
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

        // if($role->id == 1 || $role->id == 2 ){
            // header("Location: admin/");
            // exit;
        // }else{
        //     header("Location: home.php");
        //     exit;
        // }
      
    } else {
    header("Location: login.php?err=noLogin");
    exit;
    }
}