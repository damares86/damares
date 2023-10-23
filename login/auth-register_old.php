<?php
require "inc/header.php";
$op="";

if(filter_input(INPUT_GET,"op")){
  $op=filter_input(INPUT_GET,"op");
}

$plugin->pluginname = "recaptcha" ;
$mng = "mngRegister";

if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
    $mng = "mngRegisterRecap";
    require "../admin/inc/recaptcha.php";
}

?>
  <title><?=$reg_title?> - Salomon</title>
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
      <?php
      if($op==""){
      ?>
      <!-- Register Form -->
      <div class="register-form mt-4">
        <h6 class="mb-3 text-center"><?=$login_signup?></h6>
        
        <form action="../admin/core/<?=$mng?>.php" method="POST" data-parsley-validate>

          <?php

              require "../admin/core/accountDetails.php";

              $counter=0;
              foreach($account_details as $item){

                  $label = "account_add_$item";

                  $item_label = ucfirst($item);
                  
              ?>

            <div class="form-group mb-3">  
              <label class="form-label"><?=$item_label?> <span class="text-danger">*</span></label>
                  <div class="mandatory">
                      <div class="position-relative">
                      <?php
                            if($item=="qualifica"){
                            ?>
                        <div class="form-check px-4">
                            <input class="form-check-input form-check-success" type="radio" name="<?=$item?>" 
                                checked>
                            <label class="form-check-label" for="successRadio">Strutturato</label>
                        </div>
                        <div class="form-check px-4">
                            <input class="form-check-input form-check-success" type="radio" name="<?=$item?>"
                                >
                            <label class="form-check-label" for="successRadio">Specializzando</label>
                        </div>
                            <?php    
                            }else{
            
                                $type="text";
                                if($item=="birth"){
                                    $type="date";
                                }
                            ?>
                            <input
                            type="<?=$type?>"
                            class="form-control"
                            placeholder="<?=$item_label?>"
                            name="<?=$item?>"
                            data-parsley-required="true"

                            />
                            <?php
                            }
                            ?>


                      </div>
                  </div>
              </div>

              <?php
                  $counter++;

              }

              $counter=0;
              foreach($account_details_opt as $item){

                  $label = "account_add_$item";
                  $item_label = ucfirst($item);
              ?>
              <div class="form-group mb-3">  
                <label class="form-label"><?=$item_label?> <?=$account_add_optional?></label>
                  <div class="position-relative">
                      <?php
                          $type="text";
                          if($item=="birth"){
                              $type="date";
                          }
                      ?>
                      <input
                      type="<?=$type?>"
                      class="form-control"
                      placeholder="<?=$item?>"
                      name="<?=$item?>"

                      />

                  </div>
              </div>
          

              <?php
                  $counter++;

              }

            ?>
            <!-- <div class="form-group text-start mb-3">
              <label class="form-label">Username <span class="text-danger">*</span></label>
            <div class="mandatory">
              <input type="text" class="form-control" name="username" placeholder="Username" data-parsley-required="true">
            </div>
          </div> -->

          <div class="form-group text-start mb-3">
              <label class="form-label">Email <span class="text-danger">*</span></label>
            <div class="mandatory">
              <input class="form-control" name="email" type="text" placeholder="Email" data-parsley-required="true">
            </div>
          </div>

          <div class="form-group text-start mb-3 position-relative">
              <label class="form-label">Password <span class="text-danger">*</span></label>
              <div class="mandatory">
              <input class="form-control" name="password" id="psw-input" type="password" placeholder="Password"  data-parsley-required="true">

                <div class="position-absolute" id="password-visibility">
                  <i class="bi bi-eye"></i>
                  <i class="bi bi-eye-slash"></i>
                </div>
              </div>
          </div>

          <div class="form-group text-start mb-3 position-relative">
              <label class="form-label"><?=$reg_conf_psw_ph?> <span class="text-danger">*</span></label>
              <div class="mandatory">
              <input class="form-control" name="password" id="psw-input2" type="password" placeholder="<?=$reg_conf_psw_ph?>" data-parsley-equalto="#psw-input">

                <!-- <div class="position-absolute" id="password-visibility">
                  <i class="bi bi-eye"></i>
                  <i class="bi bi-eye-slash"></i>
                </div> -->
              </div>
          </div>
          <input type="hidden" name="reg_form" value="1">

          <div class="form-check mb-3">
            <div class="mandatory">
              <input class="form-check-input" id="checkedCheckbox" type="checkbox" value="" data-parsley-required="true">
              <label class="form-check-label text-muted fw-normal" for="checkedCheckbox"><?=$reg_agree_1?>
              <a href="#"><?=$reg_agree_2?></a><?=$reg_agree_3?>
              <a href="#"><?=$reg_agree_4?></a></label>
            </div>
          </div>
          <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
          <button class="btn btn-primary w-100" type="submit"><?=$login_signup?></button>
        </form>
      </div>

      <!-- Login Meta -->
      <div class="login-meta-data text-center">
        <p class="mt-3 mb-0"><?=$reg_account?> <a class="stretched-link" href="auth-login.php"><?=$reg_account_button?></a></p>
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
                    
                    <p class="mt-5"><a href="auth-register.php"><?=$reg_noreg?></a></p>

                <?php	
                }else{

                  $stmt = $register->showAllWhere('id',['email']);
                  foreach($stmt as $row){
                  $expDate=$row['expDate'];
                  // dati recuperati da email e da passare alla funzione per inserire
                  if($expDate>=$curDate){

                      $account->username = $row['username'];
                      $account->password = $row['password'];
                      $email = $row['email'];
                      $account->email = $row['email'];
                      $account->avatar = "default.png" ;
                      $account->details = $row['details'] ;
                      $account->details_opt = $row['details_opt'] ;
                      
                      if($account->insert(['username','password','email','avatar','details','details_opt'])){
                          
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
                              $account->email=$email;
                              $account->deleteFromTable('email','register_account_temp');
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

  <?php
require "inc/footer.php";
?>