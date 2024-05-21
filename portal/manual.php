<?php
require "inc/header.php";

if (!filter_input(INPUT_GET, 'prod')) {
  header('Location: index.php');
  exit;
}
$page_id = filter_input(INPUT_GET,'page');
?>

<body>
  <?php

  // DA MODIFICARE AGGIUNGENDO IL VINCOLO DELL'UTENZA

  $luna->table = 'luna_products';
  $prod_id = filter_input(INPUT_GET, 'prod');
  $luna->id = $prod_id;
  $stmt4 = $luna->showAllWhere('id', ['id']);

  while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
    extract($row4);
  ?>
    <script src="../admin/assets/js/initTheme.js"></script>
    <div id="app">

      <?php
      include "inc/sidebar.php";
      ?>

      <div id="main">

        <div class="content-wrapper container">

        <div class="page-heading">

          <h4>Manuale di <?= $row4['name'] ?></h4>

        </div>
        <div class="page-content">
          
          <section class="row">
            
            <div class="col-12">
              <div class="card shadow">
                <?php
                    $luna->table = 'luna_pages_'.$prod_id ;
                    $luna->id = $page_id ;
                    $page_stmt = $luna->showAllWhere('id',['id']) ;
                    $page_row = $page_stmt->fetch(PDO::FETCH_ASSOC);
                    extract($page_row) ;
                    
                    ?>
                  <div class="card-header">
                    <h5><?=$page_row['title']?></h5>
                  </div>
                  <div class="card-content p-4">
                  <?php
                    $label = 'hasParagraph_'.$page_row['id'];
                    if($$label){
                  ?>
                    <div class="row">
                      <div class="col-4 p-2 bg-info rounded m-3">
                        <ul>
                      <?php

                        $par_array = [] ;
                        foreach($pages_data['paragraph'] as $paragraph){
                          if($paragraph['child_id'] == $page_id){

                            foreach($paragraph['id'] as $par_id){

                              $luna->table = 'luna_pages_'.$prod_id ;
                              $luna->id = $par_id ;
                              $par_stmt = $luna->showAllWhere('id',['id']);
                              $par_row = $par_stmt->fetch(PDO::FETCH_ASSOC);
                              extract($par_row) ;
                              $par_array[] = $par_row['id'];
                        ?>
                          <li><a href="#par_<?=$par_id?>"><?=$par_row['title']?></a></li>
                        <?php
                            }


                          }
                        }
                      ?>
                        </ul>

                      </div>
                      
                    </div>
                  <?php
                    }
                  ?>
                 <p> <?=$page_row['content']?></p>

                  <?php
                  if(count($par_array)>0){

                    foreach($par_array as $par){

                      $luna->table = 'luna_pages_'.$prod_id ;
                      $luna->id = $par ;
                      $par_stmt1 = $luna->showAllWhere('id',['id']);
                      $par_row1 = $par_stmt1->fetch(PDO::FETCH_ASSOC);
                      extract($par_row1) ;
                  ?>
                    <h6><?=$par_row1['title']?></h6>
                    <p><?=$par_row1['content']?></p>

                  <?php
                    }

                  }

                  ?>
                  </div>

                </div>
              </div>

            </section>
          <?php
        }
          ?>

          </div>
        </div>

        <?php
        include "inc/footer.php";
        ?>