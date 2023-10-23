<?php
require "inc/header.php";
    
$plugin->pluginname = "recaptcha" ;
$mng="mngAuth";

if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
    $mng = "mngAuthRecap";
    require "../admin/inc/recaptcha.php";
}
?>
  <title><?=$login_titlebar?> - Salomon</title>
</head>
<body>
  

  <!-- Preloader -->
  <div id="preloader">
    <div class="dot-loader text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <div class="login-back-button">
    <a href="../index.php">
      <i class="bi bi-arrow-left-short"></i>
    </a>
  </div>

  <!-- Login Wrapper Area -->
  <div class="login-wrapper d-flex align-items-center justify-content-center">
    <div class="custom-container">
      <?php

            require "../inc/alert.php";
      ?>
      <div class="text-center px-4">
        <img class="login-intro-img" src="../assets/img/logo_gct_2023.jpg" alt="">
      </div>

      <!-- Register Form -->
      <div class="register-form mt-4">
        <h6 class="mb-3 text-center"><?=$login_title?></h6>

        <form action="../admin/core/<?=$mng?>.php"  method="POST" data-parsley-validate>
          <div class="form-group">
            <div class="mandatory">
              <input class="form-control" type="email" name="email" id="email" placeholder="Email" data-parsley-required="true">
            </div>
          </div>

          <div class="form-group position-relative">
            <div class="mandatory">
              <input class="form-control" name="password" id="psw-input" type="password" placeholder="Password"  data-parsley-required="true">
              <div class="position-absolute" id="password-visibility">
                <i class="bi bi-eye"></i>
                <i class="bi bi-eye-slash"></i>
              </div>
            </div>
          </div>
          <div class="form-group position-relative">
            <div class="form-check mb-3">
              <input class="form-check-input" name="remember" value="remember_me" id="checkedCheckbox" type="checkbox">
              <label class="form-check-label text-muted fw-normal" for="checkedCheckbox"><?=$login_remember?></label>
            </div>
          </div>
          <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
          <button class="btn btn-primary w-100" type="submit"><?=$login_button?></button>
        </form>
      </div>

      <!-- Login Meta -->
      <div class="login-meta-data text-center">
        <a class="stretched-link forgot-password d-block mt-3 mb-1" href="auth-forgot-password.php"><?=$login_forgot?></a>
        <?php
          if($reg){
        ?>  
        <p class="mb-0"><?=$login_reg?> <a class="stretched-link" href="auth-register.php"><?=$login_signup?></a></p>
        <?php
          }
        ?>
      </div>
    </div>
  </div>

<?php
require "inc/footer.php";
?>