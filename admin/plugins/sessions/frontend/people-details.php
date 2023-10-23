<?php

require "inc/header.php";

require "inc/sidebar.php";
 
?>

  <div class="page-content-wrapper">

      <div class="pt-3"></div>

    <div class="container">
    
    <?php

    require "inc/alert.php" ;
    $page_origin=filter_input(INPUT_GET,"p");
    $rel = "";
    if(filter_input(INPUT_GET,'rel_id')){
      $rel_id=filter_input(INPUT_GET,'rel_id');
      $link=filter_input(INPUT_GET,"page_link");
      $rel = "?id=$rel_id&p=$link";

    }
      
    ?>

    <a class="p-3 back-link" href="<?=$page_origin?>.php<?=$rel?>"><i class="bi bi-arrow-left-circle"></i> <?=$rel_fe_back?></a>

    <div class="team-member-wrapper direction-rtl mt-3">
      <div class="container">
          <?php
            $sp_id = filter_input(INPUT_GET,'id');
            $session->id = $sp_id ;
            $session->table = "people";

            $stmt1 = $session->showAllWhere('id',['id']);

            while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
              extract($row1);
          ?>
          <div class="card bg-light bg-gradient mb-3">
            <div class="card-body">
              <div class="row text-center">
                <div class="col speaker-details">
                    <h2 class="text-dark"><?=$row1['people_name']?></h2>
                    <?php
                      // if($row1['avatar']!="default.png"){
                    ?>
                    <img src="admin/uploads/avatar/<?=$row1['avatar']?>" alt="">
                    <?php
                    // }
                    ?>
                  </div>
                </div>
              </div>
              <div class="row p-3">
                <p><?=$row1['description']?></p>
              </div>
            </div>
          </div>

          <?php
            }
          ?>

        </div>
    </div>





  </div>

    <div class="pb-3"></div>
  </div>

  
<?php
require "inc/footer.php";
?>