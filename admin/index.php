<?php
require "inc/header.php";
?>

<body>
  <script src="assets/js/initTheme.js"></script>
  <div id="app">


    <div id="main" class="layout-horizontal">
      <?php
      include "inc/topbar.php";
      ?>
      <div class="content-wrapper container">

        <div class="page-heading">
          <h3>Damares <?= $common_dashboard ?></h3>
        </div>
        <div class="page-content">
          
          <?php

          require "inc/alert.php";

          if (filter_input(INPUT_GET, "p")) {
            include "inc/func/$page.php";
          } else {

          ?>




            <section class="row">
              <?php
              $homeBlocks = $home->showAll('id');
              foreach ($homeBlocks as $block) {
              ?>
                <div class="col-12 col-lg-<?= $block['size'] ?>">
                  <div class="card">
                    <?php
                    require "inc/home/" . $block['content'];
                    ?>
                  </div>
                </div>

              <?php
              }
              ?>
            </section>

          <?php
          }
          ?>
        </div>
      </div>
      <?php
      include "inc/footer.php";
      ?>