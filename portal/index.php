<?php
require "inc/header.php";


?>

<body>
  <script src="../admin/assets/js/initTheme.js"></script>
  <div id="app">

  <?php
      include "inc/sidebar.php";
    ?>

    <div id="main">
     
      <div class="content-wrapper container">
     
      <?php 
      if($page == 'dashboard')
      {
      ?>
        <div class="page-heading">
          <h3>Damares <?= $common_dashboard ?></h3>
        </div>
      <?php
      }
      ?>
        <div class="page-content">

          <?php

        //   require "inc/alert.php";

          if (filter_input(INPUT_GET, "p")) {
            include "inc/func/$page.php";
          } else {

          ?>




            <section class="row">

                <div class="col-12">
                  <div class="card shadow">
					<h4>Benvenuto</h4>
                  </div>
                </div>

              <?php
              }
              ?>
            </section>

        </div>
        </div>

      <?php
      include "inc/footer.php";
      ?>