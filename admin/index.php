<?php
  require "inc/header.php" ;
?>

  <body>
    <script src="assets/js/initTheme.js"></script>
    <div id="app">
     
      <?php
        include "inc/sidebar.php" ;
      ?>

      <div id="main">
        <header class="mb-3">
          <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
          </a>
        </header>

        <div class="page-content">
          <?php

            require "inc/alert.php";

            if(filter_input(INPUT_GET,"p")){
              include "inc/func/$page.php";
            }else{
              
              ?>
          
          <!--
            <script src="script/packery.pkgd.min.js"></script>
          <div class="grid" data-packery='{ "itemSelector": ".grid-item", "gutter": 10 }'>

          
            <div class="grid-item">...</div>
            <div class="grid-item grid-item--width2">...</div>
            <div class="grid-item">...</div>
            ...
          </div>

          -->
          
          <div class="page-heading">
                <h3>Damares <?=$common_dashboard?></h3>
              </div>
          <section class="row">
            
            <?php
                  $homeBlocks = $home->showAll('id');
                  foreach($homeBlocks as $block){
                    ?>
                  <div class="col-12 col-lg-<?=$block['size']?>">
                    <div class="card">
                      <?php
                      require "inc/home/".$block['content'];
                      ?>
                    </div>
                  </div>

                <?php
                  }
                ?>
          </section>
                    

             <!--    <div class="row">
              <div class="col-6 col-lg-3 col-md-6">
                  <div class="card">
                    <div class="card-body px-4 py-4-5">
                      <div class="row">
                        <div
                          class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
                        >
                          <div class="stats-icon purple mb-2">
                            <i class="iconly-boldShow"></i>
                          </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                          <h6 class="text-muted font-semibold">
                            Profile Views
                          </h6>
                          <h6 class="font-extrabold mb-0">112.000</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
               
              </div> -->
          <?php
            }
          ?>
        </div>

        <?php
          include "inc/footer.php" ;
        ?>

      
