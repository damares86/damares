<?php

require "inc/header.php";

require "inc/sidebar.php";

$plugin->pluginname = "rating_system" ;
$rating = false;
$cookie_rating="";
if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
    $rating = true ;
    if(isset($_COOKIE['damares-rate'])){
      $cookie_rating=json_decode($_COOKIE['damares-rate'],true);
    }
}
 
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

    <h4 class="text-center my-3">Sessioni del giorno</h4>
    
    <?php

    require "inc/alert.php" ;
    
    $session->table = "sessions";
    
    $time = time();
    $day = date('Y-m-d 00:00:00',$time);

    $session->date = $day;
    $stmt = $session->showAllWhere('start_time',['date']);
    ?>

    <div class="container">
      <div class="card">
        <div class="card-body">
          <?php
          $session->table="sessions";
          $session->date = $day;
          $stmt1 = $session->itemExists('date');
          
          if($stmt1>0){
          ?>
          <div class="accordion accordion-flush accordion-style-one" id="accordionStyle1">

          <?php
          $i=0;
          while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            $exp="";
            $show="";
            if($i==0){
              $exp='aria-expanded="true"';
              $show="show";
            }
            extract($row);

              $st_arr=explode(":",$row['start_time']);
              $et_arr=explode(":",$row['end_time']);

              $st= $st_arr[0].":".$st_arr[1];
              $et= $et_arr[0].":".$et_arr[1];
          ?>
            <!-- Single Accordion -->
            <div class="accordion-item">
              <div class="accordion-header" id="accordionOne_<?=$i?>">
                <h6 data-bs-toggle="collapse" data-bs-target="#accordionStyleOne_<?=$i?>" <?=$exp?>
                  aria-controls="accordionStyleOne"><?=$row['sessions_name']?><i class="bi bi-chevron-down"></i></h6>
              </div>
              <div class="accordion-collapse collapse <?=$show?>" id="accordionStyleOne_<?=$i?>" aria-labelledby="accordionOne"
                data-bs-parent="#accordionStyle1">
                <div class="accordion-body">
                  <div class="row text-left">
                    <div class="col-md-5 text-left">
                        <p><?=$rel_fe_location?>: <b>
                          <?php
                          
                          $session->id = $row['location_id'];
                          $session->table = "location";
                          $stmt4 = $session->showAllWhere('id',['id']);
                          $row4=$stmt4->fetch(PDO::FETCH_ASSOC);
                          extract($row4);
                          echo $row4['location_name'];
                          ?>
                          
                        </b><br>
                        <?=$rel_fe_time?>: <b><?=$st?> - <?=$et?></b></p>
                    </div>
                    <div class="col-7 p-3 text-center">
                  <a class="btn m-1 goto btn-creative btn-primary w-50" href="session-details.php?id=<?=$row['id']?>&p=sessions">Vai alla sessione -></a>
                    </div>
          </div>
                  <?php

                  $rel_id_str = $row['relations_id'];
                  $rel_id=explode(",",$rel_id_str);

                  foreach($rel_id as $item){

                    $relation->id = $item;
                    $relation->table = "relations";

                    $stmt2 = $relation->showAllWhere('id',['id']);
                    while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){

                      extract($row2);

                    ?>

                      <div class="card session-card bg-light mb-3">
                        <div class="card-body">
                          <div class="align-items-center">
                            <div class="row">
                              <div class="col-md-7">
                                <h5 class=" text-info"><?=$row2['relations_name']?></h5>
                              </div>
                              <div class="col-md-5 text-right">
                              <a class="btn m-1 goto btn-creative btn-primary" href="relation-details.php?id=<?=$item?>&p=sessions"><?=$rel_fe_button_details?></a>
                              </div>
                            </div>
                           
                            </div>
                          </div>
                        </div>

                  <?php
                    }


                  }

                  ?>

                </div>
              </div>
            </div>
          <?php
          $i++;
          }
          ?>
          
          </div>
          <?php
          }else{
          ?>
          Nessuna sessione per oggi
          <?php
          }
          ?>
        </div>
      </div>
    </div>




    <?php
      // }
      
    ?>

  </div>

    <div class="pb-3"></div>
  </div>

  
<?php
require "inc/footer.php";
?>