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

$module = $plugin->showAll('id');
foreach($module as $row){
    $plugin->pluginname = $row['pluginname'] ;
        if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
            $scan = scandir("plugins/".$row['pluginname']."/class");
            $exclude = array('..', '.','.gitkeep');
            foreach($scan as $file){
            if (!in_array($file,$exclude)) {
                $item = pathinfo($file);
                include "class/plugin/".$item['basename']."";
            }
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
	$stmt=$verify->showAll('id');
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	$secret=$row['secret'];
	// Costruire il POST request:      
	
	$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
	$recaptcha_secret = $secret;
	$recaptcha_response = $_POST['recaptcha_response'];
	
	// Istanziare e decodificare la richiesta POST:      
	
	$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
	$recaptcha = json_decode($recaptcha);
	
	// Azioni da compiere basate sul punteggio ottenuto:      
	
	if ($recaptcha->score >= 0.5) {

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
            
            if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
                $stmt = $role->showAllWhere('id',['id']);
                foreach($stmt as $row){
                    header("Location: ".$row['redirect']."");
                    exit;
                }
            }

            $plugin->pluginname = "file_for_role" ; 
            
            if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
                // TODO
                // spostamento su una pagina con i file
            }
                
            header("Location: ../");
            exit;
            
        } else {
            
            header("Location: ../../login/auth-login.php?msg=errUserPsw");
            exit;
        }
    }else{
		header("Location: ../../login/auth-login.php?err=errRecaptcha");
		exit;
	}

}else{
	header("Location: ../../login/auth-login.php?msg=errPost");
	exit;
}
?>
