<?php

require "inc/header.php" ;
$op=filter_input(INPUT_GET,"op");

$plugin->pluginname = "use_recaptcha" ;
$mng = "mngPass";

if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
    $mng = "mngPassRecap";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$forgot_titlebar?> - damares</title>
    <link rel="stylesheet" href="../admin/assets/css/main/app.css">
    <link rel="stylesheet" href="../admin/assets/css/pages/auth.css">
    <link rel="stylesheet" href="../admin/assets/css/custom.css">
    <link rel="shortcut icon" href="../admin/assets/images/logo/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="../admin/assets/images/logo/favicon.ico" type="image/png">

        <!--
    ##############    Damares    ###############
    #                                          #
    #    A backend project by DM WebLab        #
    #   Website: https://www.dmweblab.com      #
    #   GitHub: https://github.com/damares86   #
    #                                          #
    ############################################
    -->
    
</head>

<body>
    <div id="auth">
        
<div class="row h-100">
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <div class="auth-logo">
                <a href="../index.php"><img src="../admin/assets/images/logo/damares_logo.png" alt="Logo"></a>
            </div>
            <?php


                // require of all alert files
                $alert=glob("../admin/inc/alert/*.php", GLOB_BRACE);

                foreach($alert as $row){
                    require "$row";
                }

                if($op==""){
            ?>
            <h1 class="auth-title"><?=$forgot_title?></h1>
            <p class="auth-subtitle mb-5"><?=$forgot_desc?></p>

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

                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5"><?=$forgot_button?></button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p class='text-gray-600'><?=$forgot_back?> <a href="auth-login.php" class="font-bold"><?=$login_title?></a>.
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

            <h1 class="auth-title"><?=$forgot_choose?></h1>

            <form action="../admin/core/mngPass.php" method="POST"  data-parsley-validate>
              <div class="form-group position-relative has-icon-left mb-4">
                <div class="form-check mandatory">
                    <input
                    type="password"
                    class="form-control form-control-xl"
                    placeholder="Password"
                    name="password"
                    data-parsley-required="true"
                    />
                </div>
                <div class="form-control-icon">
                  <i class="bi bi-shield-lock"></i>
                </div>
              </div>
			<input type="hidden" name="resetMail" value="resetMail" />
			<input type="hidden" name="email" value="<?=$email?>" />

              <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5"><?=$forgot_button?></button>

            </form>

                <?php
                    } else {
                ?>

                    <div class="alert alert-danger">
                        <?=$forgot_token?>
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
    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right">

            <img src="img/visual.jpg">
        </div>
    </div>
</div>
    <?php
        require "inc/footer.php" ;
    ?>
    </div>
</body>

</html>
