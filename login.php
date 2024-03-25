<?php

require "login-header.php";
$plugin->pluginname = "recaptcha" ;
$mng = "mngAuth";

if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
    $mng = "mngAuthRecap";
    require "admin/inc/recaptcha.php";
}

?>
   <div class="row p-3">
    

             <?php
 
             // require of all alert files
             require "login-alert.php";
             ?>

            <h1 class="auth-title">Login</h1>
            
            <!-- <p class="auth-subtitle mb-5">
              <?=$login_desc?>
            </p> -->

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
                <div class="form-check form-check-lg d-flex align-items-end">
                  <input
                    class="form-check-input remember me-2"
                    type="checkbox"
                    value="remember_me"
                    name="remember"
                    id="flexCheckDefault"
                  />
                  <label
                    class="form-check-label text-gray-600"
                    for="flexCheckDefault"
                  >
                  Ricordami su questo computer 
                  </label>
                </div>
              <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                Login
              </button>
            </form>
            <div class="text-center mt-3 text-lg fs-4">
              <?php
                if($reg){
              ?>  
                  <?=$login_reg?>
                <a class="font-bold">
                  <a href="auth-register.php" class="font-bold"><?=$login_signup?></a>.
                </p>
              <?php
                }
                ?>
               <p>
                <a class="font-bold" href="auth-forgot-password.php"
                  >Password dimenticata</a
                >
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
          <div id="auth-right">
            &nbsp;
            <!-- <img src="img/visual.jpg" class="h-100"> -->
          </div>
        </div>
        </div>
      </div>
    </div>
    <?php
    require "inc/footer.php";
    ?>
  </body>
</html>