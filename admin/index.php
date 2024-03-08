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
                    
          <?php
            }
          ?>
        </div>

        <?php
          include "inc/footer.php" ;
        ?>

      
