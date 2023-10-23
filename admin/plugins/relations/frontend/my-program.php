<?php

require "inc/header.php";

require "inc/sidebar.php";
 
?>

  <div class="page-content-wrapper">

    <!-- Tiny Slider One Wrapper -->
    <div class="tiny-slider-one-wrapper">
      <div class="tiny-slider-one">
        <!-- Single Hero Slide -->
        <div>
          <div class="single-hero-slide bg-overlay" style="background-image: url('assets/img/visual.jpg')">
            <div class="h-100 d-flex align-items-center text-center">
              <div class="container">
                <h3 class="text-white mb-1">Convention Star Wars</h3>
                <p class="text-white mb-4">15-19 Luglio 2023</p>
                <?php
                $file->id = 1 ;
                $stmt = $file->showAllWhere('id',['id']);
                foreach($stmt as $item){
                ?>
                  <a class="btn btn-creative btn-light" href="admin/uploads/<?=$item['filename']?>">Program</a>
                <?php
                }
              ?>
              </div>
            </div>
          </div>
        </div>

      
      </div>
    </div>

    <div class="pt-3"></div>

    <div class="container">

    <h4 class="text-center my-3"><?=$fe_side_myprogram?></h4>
    
    <?php

    require "inc/alert.php" ;
    
    $relation->table = "relations";
    $stmt = $relation->showAll('start_time');

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

      extract($row);

      $rel_id=$row['id'];

      if(isset($_COOKIE['damares-program'])){
        $data = json_decode($_COOKIE['damares-program'],true);
        if(in_array($rel_id,$data)){     
      

        $st_arr=explode(":",$row['start_time']);
        $et_arr=explode(":",$row['end_time']);

        $st= $st_arr[0].":".$st_arr[1];
        $et= $et_arr[0].":".$et_arr[1];

    ?>
        <div class="card session-card bg-lightt mb-3">
            <div class="card-body">
              <div class="align-items-center">
                <div class="row">
                  <div class="col-md-7">
                    <h5 class=" text-info"><?=$row['relations_name']?></h5>
                  </div>
                  <div class="col-md-5 text-right">
                            <p><?=$rel_fe_location?>: <b><?=$row['location']?></b><br>
                            <?=$rel_fe_time?>: <b><?=$st?> - <?=$et?></b></p>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-6">
                    <b><?=$rel_fe_speakers?>:</b>

                    <?php

                      $speakers_str=$row['speakers_id'];
                      $speakers_arr=explode(",",$speakers_str); 
                      $count=0;
                      foreach($speakers_arr as $sp){

                        $session->id=$sp;
                        $stmt1=$session->showAllWhereTable('speakers_name','speakers',['id']);
                        $row1=$stmt1->fetch(PDO::FETCH_ASSOC);
                        if($count>0){
                        echo ", ";
                        }
                        echo $row1['speakers_name'];
                        $count++;
                
                       }
                      ?>

                  </div>
                  <div class="col-md-6">
                  <a class="btn m-1 goto btn-creative btn-primary" href="relation-details.php?id=<?=$row['id']?>&p=my-program"><?=$rel_fe_button_details?></a>
                  <a class="btn m-1 btn-creative btn-danger" href="admin/core/mngRelations.php?rel_id=<?=$rel_id?>&op=del">
                    <i class="bi bi-trash"></i>
                  </a>
                  </div>
                </div>
              </div>
            </div>
          </div>



    <?php
        }
      }else{
    ?>
    <h5 class="text-center mt-5"><?=$fe_no_program ?></h5>
    <?php
    break;
      }
    }
    ?>

  </div>

    <div class="pb-3"></div>
  </div>

  
<?php
require "inc/footer.php";
?>