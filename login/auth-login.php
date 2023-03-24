<?php
  require "inc/header.php" ;

  $plugin->pluginname = "account_register" ;
  $reg = "";



  if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
      $reg = true ;
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?=$login_titlebar?> - damares</title>
    <link rel="stylesheet" href="../admin/assets/css/main/app.css" />
    <link rel="stylesheet" href="../admin/assets/css/pages/auth.css" />
    <link rel="stylesheet" href="../admin/assets/css/custom.css">
    <link
      rel="shortcut icon"
      href="../admin/assets/images/logo/favicon.ico"
      type="image/x-icon"
    />
    <link
      rel="shortcut icon"
      href="../admin/assets/images/logo/favicon.ico"
      type="image/png"
    />
    <?php
    
    $plugin->pluginname = "recaptcha" ;
    $mng="mngAuth";

    if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
        $mng = "mngAuthRecap";
        require "../admin/inc/recaptcha.php";
    }

    ?>
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
              <a href="../index.php"
                ><img src="../admin/assets/images/logo/damares_logo.png" alt="Logo"
              /></a>
            </div>

            <?php

            // require of all alert files
            $alert=glob("../admin/inc/alert/*.php", GLOB_BRACE);

            foreach($alert as $row){
                require "$row";
            }
            ?>

            <h1 class="auth-title"><?=$login_title?></h1>
            
            <p class="auth-subtitle mb-5">
              <?=$login_desc?>
            </p>

            <form action="../admin/core/<?=$mng?>.php" method="POST">
              <div class="form-group position-relative has-icon-left mb-4">
                <input
                  type="email"
                  class="form-control form-control-xl"
                  placeholder="Email"
                  name="email"
                />
                <div class="form-control-icon">
                  <i class="bi bi-envelope"></i>
                </div>
              </div>
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
              <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
              <div class="form-check form-check-lg d-flex align-items-end">
                <input
                  class="form-check-input me-2"
                  type="checkbox"
                  name="remember"
                  value=""
                  id="flexCheckDefault"
                />
                <label
                  class="form-check-label text-gray-600"
                  for="flexCheckDefault"
                >
                  Keep me logged in
                </label>
              </div>
              <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                <?=$login_button?>
              </button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
              <?php
                if($reg){
              ?>  
                <p class="text-gray-600">
                  <?=$login_reg?>
                  <a href="auth-register.php" class="font-bold"><?=$login_signup?></a>.
                </p>
              <?php
                }
              ?>
               <p>
                <a class="font-bold" href="auth-forgot-password.php"
                  ><?=$login_forgot?></a
                >
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
          <div id="auth-right">
            <img src="img/visual.jpg">
          </div>
        </div>
      </div>
    </div>
    <?php
    require "inc/footer.php";
    ?>
  </body>
</html>
