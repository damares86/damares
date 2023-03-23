<?php

require "inc/header.php" ;
$op=filter_input(INPUT_GET,"op");

$plugin->pluginname = "use_recaptcha" ;
$mng = "mngRegister";

if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
    $mng = "mngRegisterRecap";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - damares</title>
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
            <h1 class="auth-title"><?=$login_signup?></h1>
            <p class="auth-subtitle mb-5"><?=$reg_desc?></p>

            <form action="../admin/core/<?=$mng?>.php" method="POST" data-parsley-validate>
                <div class="form-group position-relative has-icon-left mb-4">
                    <div class="form-check mandatory">
                        <input type="text" class="form-control form-control-xl" name="email" placeholder="Email" data-parsley-required="true">
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <div class="form-check mandatory">
                        <input type="text" class="form-control form-control-xl" name="username" placeholder="Username" data-parsley-required="true">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <div class="form-check mandatory">
                        <input type="password" id="first-password" name="password" class="form-control form-control-xl" placeholder="Password" data-parsley-required="true">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="reg_form" value="1">
                <div class="form-group position-relative has-icon-left mb-4">
                    <div class="form-check mandatory">
                        <input type="password" class="form-control form-control-xl" placeholder="Confirm Password" data-parsley-equalto="#first-password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5"><?=$login_signup?></button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p class='text-gray-600'><?=$reg_account?> <a href="auth-login.php" class="font-bold"><?=$reg_account_button?></a>.</p>
            </div>
            <?php
             }else if($op=="reg"){
                 $email=filter_input(INPUT_GET, "email");
                 $register->email=$email;
                 $token=filter_input(INPUT_GET, "token");
                 $register->token=$token;
                 $curDate=date("Y-m-d H:i:s");
                 
                 $regTmp="";
                 $stmt = $register->showAllWhere('id',['token','email']);
                 foreach($stmt as $row){
                     $regTmp = $row['token'];
                    }

                if(!$regTmp){	
                    // token non c'è
                    ?>       
                    
                    <a href="auth-register.php"><?=$reg_noreg?></a>				

                <?php	
                }else{

                    $stmt = $register->showAllWhere('id',['email']);
                    foreach($stmt as $row){
                    $expDate=$row['expDate'];
                    // dati recuperati da email e da passare alla funzione per inserire
                    if($expDate>=$curDate){

                        $account->username = $row['username'];
                        $account->password = $row['password'];
                        $account->email = $row['email'];
                        $account->avatar = "default.png" ;
                        
                        if($account->insert(['username','password','email','avatar'])){
                            
                            //get the default role from settings
                            $setting->name="reg_role" ;
                            $stmt1 = $setting->showByName();
                            $default_role = $stmt1['value'];

                            $role->rolename = $default_role ;
                            $stmt2 = $role->showIdByRolename();
                            $role_id ="";

                            foreach($stmt2 as $row2){
                                $role_id = $row2['id'];
                            }
                            
                            $accountroles->role_id = $role_id ;
                            $insertedId = "" ;
                            
                            // $account->email = filter_input(INPUT_POST,"email") ;                            
                            $stmt3= $account->showAllWhere('id',['email']);
                            while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
                                extract($row3);
                                $insertedId = $row3['id'];
                            }
                            
                            $accountroles->account_id = $insertedId ;

                            // success, insert the role in accountsRoles table
                            if($accountroles->insert(['account_id','role_id'])){
                                
                                //success
                                header("Location: auth-login.php?msg=accountReg");
                                exit;

                            }else{

                                // failed, delete the user inserted

                                header("Location: auth-register.php?err=accountNoReg");
                                exit;
                            }

                        }else{
                            ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?=$reg_errreg?>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="Close"
                                ></button>
                            </div>
                        <?php
                        }
                    }
                }
            }
                  
                
                    }else{
                        ?>

                        <div class="alert alert-danger">
                            <?=$reg_token?>
                        </div>
                        <a href="auth-register.php"><?=$reg_back?></a>
    
                    <?php
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
