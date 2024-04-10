<?php
require "inc/header.php";

$selVert = '';
$setting->name = "layout";
$stmt = $setting->showAllWhere('id', ['name']);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$layout = $row['value'];

?>

<body>
  <script src="assets/js/initTheme.js"></script>
  <div id="app">

    <?php
    $classHoriz = '';

    if ($layout == 'h') 
    {
      $classHoriz = ' class="layout-horizontal"';
    } 
    else if ($layout == 'v') 
    {
      include "inc/sidebar.php";
    }
    ?>

    <div id="main" <?= $classHoriz ?>>
      <?php
          if ($layout == 'h') 
          {
            include "inc/topbar.php";
      ?>
      <div class="content-wrapper container">
      <?php
      }
      ?>

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
                  <div class="card shadow">
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
          if ($layout == 'h') 
          {
          ?>    
          </div>
          <?php
          }
          ?>
      <?php
      include "inc/footer.php";
      ?>