<?php

require "inc/header.php";

require "inc/sidebar.php";
 
?>

  <div class="page-content-wrapper">

    <!-- Tiny Slider One Wrapper -->
    <div class="tiny-slider-one-wrapper">
      <div class="tiny-slider-one">
        
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
    
    <?php

    require "inc/alert.php" ;

    $session->table = "sessions";
    $stmt = $session->showAll('date');
    
    $sess_date=[];

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      extract($row);

      if(!in_array($row['date'],$sess_date)){
        $sess_date[]=$row['date'];
      }

    }

    ?>


    <h3 class="text-center"><?=$sess_fe_sessions?></h3>
    <div class="card session bg-gradient">
        <div class="card-body">
          <div class="colorful-tab">
            <ul class="nav p-1 mb-3 shadow-sm" id="affanTab3" role="tablist">
              <?php
              $count=0;
              $newDate="";
              foreach($sess_date as $item){
                
                $active="";
                $selected="false";
                if($count==0){
                  $active="active";
                  $selected="true";
                }
                $count++;
                
                if($lang=="it"){
                  $newDate=date("d-m", strtotime($item));
                }else{
                  $newDate=date("m-d", strtotime($item));
                }
                
                ?>
                
                <li class="nav-item" role="presentation">
                  <button class="btn btn-primary <?=$active?>" id="s_<?=$newDate?>-tab" data-bs-toggle="tab" data-bs-target="#s_<?=$newDate?>"
                    type="button" role="tab" aria-controls="<?=$newDate?>" aria-selected="<?=$selected?>"><?=$newDate?></button>
                </li>
                <?php
                }
                ?>
                </ul>

                <div class="tab-content shadow-sm p-3" id="affanTab3Content">

                  <?php
                $count1=0;
                foreach($sess_date as $item){
                  if($lang=="it"){
                    $newDate=date("d-m", strtotime($item));
                  }else{
                    $newDate=date("m-d", strtotime($item));
                  }
                  $session->table="location";
                  $stmt1 = $session->showAll('id');
                  
                  $loc=[];
                  $loc_id=[];

                
                  $active1="";
                  $selected="false";
                  if($count1==0){
                    $active1="show active";
                    $selected="true";
                  }
                  $count1++;

                  // cycle the locations
                  while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                    extract($row1);
                    $loc[]=$row1['location_name'];
                    $loc_id[]=$row1['id'];
                  }

                  ?>
                  <div class="text-white tab-pane fade <?=$active1?>" id="s_<?=$newDate?>" role="tabpanel" aria-labelledby="s_<?=$newDate?>-tab">
                      
                  <div class="card">
                      <div class="card-body">

                        <ul class="nav nav-tabs" id="bootstrapTab" role="tablist">
                          <?php
                          $countLoc=0;
                          foreach($loc_id as $locId){

                            $session->table="sessions";
                            $session->date = $item ;
                            $session->location_id=$locId;
                            $stmt6 = $session->showAllWhere('date',['date','location_id']);

                            $row6=$stmt6->fetch(PDO::FETCH_ASSOC);
                            if(is_array($row6)){

                              extract($row6);
                    
                              
                              $activeLoc="";
                              $selected="false";
                              if($countLoc==0){
                                $activeLoc="active";
                                $selected="true";
                              }
                              $countLoc++;

                              $session->table = "location";
                              $session->id = $locId;
                              $stmt4 = $session->showAllWhere('id',['id']);
                              $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
                              extract($row4);
                              $locName = $row4['location_name'];
                          ?>
                          
                          <li class="nav-item me-2" role="presentation">
                            <button class="nav-link <?=$activeLoc?>" id="l_<?=$locId?>_<?=$newDate?>_<?=$countLoc?>-tab" data-bs-toggle="tab" data-bs-target="#l_<?=$locId?>_<?=$newDate?>_<?=$countLoc?>" type="button"
                              role="tab" aria-controls="l_<?=$locId?>_<?=$newDate?>_<?=$countLoc?>" aria-selected="<?=$selected?>"><?=$locName?></button>
                          </li>

                          <?php
                              // }
                            }
                          }
          
                          ?>
                        </ul>

                        <div class="tab-content p-3 border-top-0" id="bootstrapTabContent">

                            <?php
                            
                            $countTab=0;
                            foreach($loc_id as $locId){
                              
                              
                              $activeTab="";
                              if($countTab==0){
                                  $activeTab="active";
                                }
                                $countTab++;
                                
                                $session->table = "sessions";
                                $session->date = $item ;
                                $session->location_id = $locId;
                                
                              $stmt2 = $session->showAllWhere('date',['date','location_id']);
                              ?>
                              <div class="tab-pane fade show <?=$activeTab?>" id="l_<?=$locId?>_<?=$newDate?>_<?=$countTab?>" role="tabpanel" aria-labelledby="l_<?=$locId?>_<?=$newDate?>_<?=$countTab?>-tab">
                                <?php
                              
                              // cycle the session with current date and location
                              while($row2= $stmt2->fetch(PDO::FETCH_ASSOC)){
                                extract($row2);
                                ?>

                                <h4 class="mt-3">
                                    <a href="session-details.php?id=<?=$row2['id']?>&p=calendar">
                                        <?=$row2['sessions_name']?></h4>
                                    </a>
                                <div class="row bg-info rounded text-white p-2">
                                <?php
                                
                                $relation_arr=explode(",",$row2['relations_id']);
                                foreach($relation_arr as $rel){

                                  $relation->table = "relations";
                                  $relation->id = $rel ;

                                  $stmt5 = $relation->showAllWhere('id',['id']);
                                  $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
                                  if(is_array($row5)){
                                    extract($row5);
    
                                    $st=date("H:i",strtotime($row5['start_time']));
                                    $et=date("H:i",strtotime($row5['end_time']));

                                  ?>
                                  <div class="row py-3">
                                    <div class="col-md-6">
                                      <h5 class="text-white"><?=$row5['relations_name']?></h5>
                                    </div>
                                    <div class="col-md-3">
                                      <p class="text-white"><?=$st?>-<?=$et?></p>
                                    </div>
                                    <div class="col-md-3">
                                      <a class="btn m-1 goto btn-white" href="relation-details.php?id=<?=$row5['id']?>&p=calendar"><?=$rel_fe_button_details?></a>
                                    </div>
                                  </div>
                                  

                                  <?php

                                }
                                else
                                {
                                  echo $rel_fe_norel;
                                }
                              }
                                ?>
                                </div>
                                <?php
                                // $session->table = "location";
                                // $session->id = $row2['location_id'];
                                // $stmt3 = $session->showAllWhere('id',['id']);
                                // $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
                                // extract($row3);
                                // $locationName = $row3['location_name'];
                              
                            }
                            ?>
                            </div>
                          <?php
                        
                        }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                  } 
                  ?>
                </div>
         
          </div>
        </div>
      </div>
  </div>

    <div class="pb-3"></div>
  </div>

  
<?php
require "inc/footer.php";
?>