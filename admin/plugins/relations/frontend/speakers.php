<?php

require "inc/header.php";

require "inc/sidebar.php";
 
?>

  <div class="page-content-wrapper">

   

    <div class="pt-3"></div>

    <div class="container">
    
    <?php

    require "inc/alert.php" ;
      
    ?>
    <h4 class="text-center my-5"><?=$sess_fe_speakers?></h4>
    <div class="team-member-wrapper direction-rtl">
      <div class="container">
        <div class="row g-3">
          <?php
            $stmt1 = $session->showAllTable('speakers_name','speakers');

            while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
              extract($row1);
          ?>

            <div class="col-6">
              <div class="card team-member-card shadow">
                <a href="speakers-details.php?id=<?=$row1['id']?>&p=speakers">
                <div class="card-body">
                  <!-- Member Image-->
                  <div class="team-member-img shadow-sm">
                    <img src="admin/uploads/avatar/<?=$row1['avatar']?>" alt="">
                  </div>
                  <!-- Team Info-->
                  <div class="team-info">
                      <h6 class="mb-1 fz-14"><?=$row1['speakers_name']?></h6>
                    </div>
                  </div>
                </div>
              </a>
            </div>


          <?php
            }
          ?>

          <!-- Single Team Member -->
        </div>
      </div>
    </div>

          <?php
            $session->table="people_cat";
            $stmt2 = $session->showAll('id');

            while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
              extract($row2);

          ?>
            <h4 class="text-center my-5"><?=$row2['people_cat_name']?></h4>
            <div class="team-member-wrapper direction-rtl">
              <div class="container">
              <div class="row g-3">

            <?php
              $session->table = "people_cat_id" ;
              $session->cat_id = $row2['id'];
              if($session->itemExists('cat_id')){
              $stmt3 = $session->showAllWhere('id',['cat_id']);

              

              while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
                extract($row3);
               
                $session->table="people";
                $session->id = $row3['people_id'];


                $stmt4 = $session->showAllWhere('id',['id']);
                $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
                extract($row4);
                  ?>


                          <div class="col-6">
                            <div class="card team-member-card shadow">
                              <a href="people-details.php?id=<?=$row4['id']?>&p=speakers">
                              <div class="card-body">
                                <!-- Member Image-->
                                <div class="team-member-img shadow-sm">
                                  <img src="admin/uploads/avatar/<?=$row4['avatar']?>" alt="">
                                </div>
                                <!-- Team Info-->
                                <div class="team-info">
                                    <h6 class="mb-1 fz-14"><?=$row4['people_name']?></h6>
                                  </div>
                                </div>
                              </div>
                            </a>
                          </div>


                        <?php
                    }
            
                  }else{
              echo "No ".$row2['people_cat_name'];
              }
            }
          ?>

          <!-- Single Team Member -->
        </div>
      </div>
    </div>





  </div>

    <div class="pb-3"></div>
  </div>

  
<?php
require "inc/footer.php";
?>