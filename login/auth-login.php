<?php
require '../admin/vendor/autoload.php';		// If installed via composer
$debug = new \bdk\Debug(array(
	'collect' => true,
	'output' => true,
));


include "../admin/class/Database.php";
include "../admin/class/Common.php";
include "../admin/class/Setting.php";

$database = new Database();
$db = $database->getConnection();
$setting= new Setting($db);

$setting->name="lang" ;
$stmt = $setting->showByName();
$lang = $stmt['value'];

foreach (glob("../admin/locale/$lang/*.php") as $row){
    require "$row";
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
    <link
      rel="shortcut icon"
      href="../admin/assets/images/logo/favicon.svg"
      type="image/x-icon"
    />
    <link
      rel="shortcut icon"
      href="../admin/assets/images/logo/favicon.png"
      type="image/png"
    />
  </head>

  <body>
    <div id="auth">
      <div class="row h-100">
        <div class="col-lg-5 col-12">
          <div id="auth-left">
            <div class="auth-logo">
              <a href="../index.php"
                ><img src="../admin/assets/images/logo/logo.svg" alt="Logo"
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

            <form action="../admin/core/mngAuth.php" method="POST">
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
              <!-- <div class="form-check form-check-lg d-flex align-items-end">
                <input
                  class="form-check-input me-2"
                  type="checkbox"
                  value=""
                  id="flexCheckDefault"
                />
                <label
                  class="form-check-label text-gray-600"
                  for="flexCheckDefault"
                >
                  Keep me logged in
                </label>
              </div> -->
              <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                <?=$login_button?>
              </button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
              <!-- <p class="text-gray-600">
                Don't have an account?
                <a href="auth-register.html" class="font-bold">Sign up</a>.
              </p> -->
              <!-- <p> -->
                <a class="font-bold" href="auth-forgot-password.php"
                  ><?=$login_forgot?></a
                >
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
          <div id="auth-right"></div>
        </div>
      </div>
    </div>
    <script src="../admin/assets/js/bootstrap.js"></script>
    <script src="../admin/assets/js/app.js"></script>
    <script src="../admin/assets/js/pages/dashboard.js"></script>
    <script src="../admin/assets/extensions/jquery/jquery.min.js"></script>
    <script src="../admin/assets/extensions/parsleyjs/parsley.min.js"></script>
    <script src="../admin/assets/js/pages/parsley.js"></script>
  </body>
</html>
