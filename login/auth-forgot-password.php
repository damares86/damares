<?php

spl_autoload_register('autoloader');

function autoloader($class){
    include("../admin/class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

include "../admin/inc/class_initialize.php" ;

$op=filter_input(INPUT_GET,"op");

$plugin->pluginname = "use_recaptcha" ;
$recap = $plugin->itemExists('pluginname');
$mng = "mngPass";

if($recap){
    $stmt=$plugin->showAllWhere('id',['pluginname']);
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if($row['active']==1){
        $mng = "mngPassRecap";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password - Mazer Admin Dashboard</title>
    <link rel="stylesheet" href="../admin/assets/css/main/app.css">
    <link rel="stylesheet" href="../admin/assets/css/pages/auth.css">
    <link rel="shortcut icon" href="../admin/assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="../admin/assets/images/logo/favicon.png" type="image/png">
</head>

<body>
    <div id="auth">
        
<div class="row h-100">
    <div class="col-lg-7 col-12">
        <div id="auth-left">
            <div class="auth-logo">
                <a href="../index.php"><img src="../admin/assets/images/logo/logo.svg" alt="Logo"></a>
            </div>
            <?php
                if($op==""){
            ?>
            <h1 class="auth-title">Forgot Password</h1>
            <p class="auth-subtitle mb-5">Input your email and we will send you reset password link.</p>

            <form action="../admin/core/mngPass.php" method="POST"  data-parsley-validate>
                <div class="form-group position-relative has-icon-left mb-4">
                    <div class="form-check mandatory">
                        <input type="email" name="email" class="form-control form-control-xl" placeholder="Email"
                                        data-parsley-required="true">
                        <!-- <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div> -->
                    </div>
                </div>
				<input type="hidden" name="resetForm" value="resetForm" />

                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Send</button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p class='text-gray-600'>Remember your account? <a href="auth-login.php" class="font-bold">Log in</a>.
                </p>
            </div>
           
            <?php
            }else if($op=="reset"){
                $email=filter_input(INPUT_GET, "email");
                $account->email=$email;
                $token=filter_input(INPUT_GET, "token");
                $account->token=$token;
                $curDate=date("Y-m-d H:i:s");
                
                $pswTmp = $account->getPswTmpData();

                if(!$pswTmp['token']){	
                    
            ?>


            
                <a href="login.php"><-- <?=$log_back?></a>				


                <?php	
                }else{
                    $account->getExpDate();
                    $expDate=$account->expDate;
                    if($expDate>=$curDate){
                ?>	

            <h1 class="auth-title">Choose the new Password</h1>

            <form action="../admin/core/mngPass.php" method="POST">
              <div class="form-group position-relative has-icon-left mb-4">
                <input
                  type="password"
                  class="form-control form-control-xl"
                  placeholder="Password"
                  name="password"
                />
                <div class="form-control-icon">
                  <i class="bi bi-shield-lock"></i>
                </div>
              </div>
			<input type="hidden" name="resetMail" value="resetMail" />
			<input type="hidden" name="email" value="<?=$email?>" />

              <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Send</button>

            </form>

                <?php
                    } else {
                ?>

                    <div class="alert alert-danger">
                        Token expired
                    </div>
                    <a href="login.php"><-- <?=$log_back?></a>

                <?php
                    }
                }
                
                $account->deleteFromTable('email','password_reset_temp');
            } 
         ?>
        </div>
    </div>
    <div class="col-lg-5 d-none d-lg-block">
        <div id="auth-right">

        </div>
    </div>
</div>

    </div>
</body>

</html>
