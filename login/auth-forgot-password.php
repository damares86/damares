<?php
require "inc/header.php";
$op=filter_input(INPUT_GET,"op");

    
$plugin->pluginname = "recaptcha" ;
$mng="mngPass";

if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
    $mng = "mngPassRecap";
    require "../admin/inc/recaptcha.php";
}
?>
  <title><?=$forgot_titlebar?> - Salomon</title>
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

  <?php

require "../inc/alert.php";
?>

  <!-- Login Wrapper Area -->
  <div class="login-wrapper d-flex align-items-center justify-content-center">
    <div class="custom-container">
      <div class="text-center px-4">
        <img class="login-intro-img" src="../assets/img/bg-img/37.png" alt="">
      </div>
  <?php
  if($op==""){
  ?>

      <!-- Register Form -->
      <div class="register-form mt-4">
        <h4 class="text-center"><?=$forgot_title?></h4>
        <p><?=$forgot_desc?></p>
        <form action="../admin/core/<?=$mng?>.php" method="POST"  data-parsley-validate>
          <div class="form-group text-start mb-3">
            <div class="mandatory">
              <input type="email" name="email" class="form-control" placeholder="Email" data-parsley-required="true">
				      <input type="hidden" name="resetForm" value="resetForm" />
            </div>
          </div>
          <button class="btn btn-primary w-100" type="submit"><?=$forgot_button?></button>
        </form>
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



  <div class="text-center px-4">  
      <a href="auth-login.php"><i class="bi bi-arrow-left-short"></i> <?=$forgot_back?></a>				
  </div>


      <?php	
      }else{
          $account->getExpDate();
          $expDate=$account->expDate;
          if($expDate>=$curDate){
      ?>	

  <h4><?=$forgot_choose?></h4>

  <form action="../admin/core/<?=$mng?>.php" method="POST"  data-parsley-validate>
    <div class="form-group position-relative has-icon-left mb-4">
      <div class="mandatory">
          <input
          type="password"
          class="form-control form-control-xl"
          placeholder="Password"
          name="password"
          data-parsley-required="true"
          />
      </div>
    </div>
    <input type="hidden" name="resetMail" value="resetMail" />
    <input type="hidden" name="email" value="<?=$email?>" />
    <input type="hidden" name="recaptcha_response" id="recaptchaResponse">


    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5"><?=$forgot_button?></button>

  </form>

      <?php
          } else {
      ?>

          <div class="alert alert-danger">
              <?=$forgot_token?>
          </div>
          <a href="login.php"><i class="bi bi-arrow-left-short"></i> <?=$log_back?></a>

      <?php
          }
      }
      
      $account->deleteFromTable('email','password_reset_temp');
  } 
?>    
</div>
</div>

<?php

require "inc/footer.php";
?>