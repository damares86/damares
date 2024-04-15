<?php

require "login-header.php";

?>
   <div class="row p-3">
    <div class="col-3 d-none d-md-block">&nbsp;</div>

    <div class="col-6">
        <?php

        // require of all alert files
        require "login-alert.php";
        ?>

      <h1 class="auth-title"><?=$login_button?></h1>
      <br>
      <!-- <p class="auth-subtitle mb-5">
        <?=$login_desc?>
      </p> -->

      <form action="admin/core/mngAuthCustomer.php" method="POST">
        <div class="form-group position-relative has-icon-left mb-4">
          <input
            type="text"
            class="form-control form-control-xl"
            placeholder="Username"
            name="username"
          />
          <div class="form-control-icon">
            <i class="bi bi-person"></i>
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
          <!-- <div class="form-check form-check-lg d-flex align-items-end">
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
          </div> -->
        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
          <?=$common_submit?>
        </button>
      </form>
      <br>
      
          <p>
          <a class="font-bold" href="forgot-password.php"
            ><?=$login_forgot?></a
          >
        </p>
      </div>
      <div class="col-3 d-none d-md-block">&nbsp;</div>

    </div>

    
    <?php
    require "login-footer.php";
    ?>
  </body>
</html>