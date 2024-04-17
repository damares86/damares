<?php
##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

spl_autoload_register('autoloader');

function autoloader($class){
    include("../class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

include "../inc/class_initialize.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
// 	$stmt=$verify->showAll('id');
// 	$row=$stmt->fetch(PDO::FETCH_ASSOC);
// 	$secret=$row['secret'];
// 	// Costruire il POST request:      
	
// 	$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
// 	$recaptcha_secret = $secret;
// 	$recaptcha_response = $_POST['recaptcha_response'];
	
// 	// Istanziare e decodificare la richiesta POST:      
	
// 	$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
// 	$recaptcha = json_decode($recaptcha);
	
// 	// Azioni da compiere basate sul punteggio ottenuto:      
	
// 	if ($recaptcha->score >= 0.5) {

        // get the form data
        $postpass = $_POST['password'];

        $username = $_POST['username'];
        $customer->username = $username;
        
        $customer->table = 'customers' ;

        $stmt = $customer->showAllWhere('id',['username']) ;
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row) ;

        // match the email and the password
        if($stmt->rowCount()>0 && password_verify($postpass,$row['password'])){
    
            // if($_POST['remember']){
            //     $token = md5($username);
            //     $addToken= substr(md5(uniqid(rand(),1)),3,10);
            //     $token = $token . $addToken;
                
            //     $customer->table = 'customers' ;
            //     $customer->username = $username ;
            //     $customer->auth_token =  $token ;
                
            //     // auth token and last login update
            //     $time=date("Y.m.d, G:i:s");
            //     $customer->last_login =  $time ;

            //     $customer->update(['auth_token','last_login'],'username') ;

            //     setcookie("damares-customer-login", $auth->id . "," . $token, time()+(60 * 60 *24 * 365 *10 ),"/");
                
            // }
            
            session_start();
                        
            // set session data
            $_SESSION['customer_loggedin'] = true ;
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
        
            $plugin->pluginname = "file_for_role" ; 
            
            if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
                // TODO
                // spostamento su una pagina con i file
            }

            header("Location: ../../index_xs.php");
            exit;
            
        } else {
            
            header("Location: ../../login.php?err=errUserPsw");
            exit;
        }
    // }else{
	// 	header("Location: ../../login/auth-login.php?err=errRecaptcha");
	// 	exit;
	// }

}else{
	header("Location: ../../login.php?msg=errPost");
	exit;
}
?>
