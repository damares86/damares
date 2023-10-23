<?php

require "inc/header.php";

require "inc/sidebar.php";
$plugin->pluginname = "rating_system" ;
$rating = false;
$cookie_rating="";
// if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
//     $rating = true ;
//     if(isset($_COOKIE['damares-rate'])){
//       $cookie_rating=json_decode($_COOKIE['damares-rate'],true);
//     }
// }

$plugin->pluginname = "questions" ;
$qea = false;
if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
    $qea = true ;
}
$plugin->pluginname = "quiz" ;
$quiz_plugin = false;
if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
    $quiz_plugin = true ;
}

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

 
    $rel_id = filter_input(INPUT_GET,"id");
    $relation->id= $rel_id;
    $relation->table = "relations";
    $stmt = $relation->showAllWhere('id',['id']);
    $page_origin=filter_input(INPUT_GET,"p");
    $sess_id="";
    if(filter_input(INPUT_GET,"ipsess")){
      $id_num=filter_input(INPUT_GET,"ipsess");
      $sess_id="?id=$id_num";
    }
    // print_r($_COOKIE);
    // exit;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      extract($row);
      if($lang=="it"){
        $newDate=date("d/m/Y", strtotime($row['date']));
      }else{
        $newDate=date("Y/m/d", strtotime($row['date']));
      }
      $st_arr=explode(":",$row['start_time']);
      $et_arr=explode(":",$row['end_time']);

      $st= $st_arr[0].":".$st_arr[1];
      $et= $et_arr[0].":".$et_arr[1];

      $session->table = "location";
      $session->id = $row['location'];
      $stmt2=$session->showAllWhere('id',['id']);
      $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
      extract($row2);
    ?>
<a class="p-3 mb-5 back-link" href="<?=$page_origin?>.php<?=$sess_id?>"><i class="bi bi-arrow-left-circle"></i> <?=$rel_fe_back?></a>

    <h3 class="text-center mt-3"><?=$row['relations_name']?></h3>
    <div class="card service-card bg-light mb-3">
      <div class="card-body">
        <div class="align-items-center">
          <div class="row">
            <div class="col-sm-4 text-center text-sm-left">
              <p class="text-dark"><?=$rel_fe_date?>: <b><?=$newDate?></b><br>           
              <?=$rel_fe_time?>: <b><?=$st?> - <?=$et?></b></p>
            </div>
            <div class="col-sm-4 text-center text-sm-left">
              <p class="text-dark">
                <?=$rel_fe_location?>: <b><?=$row2['location_name']?></b>
              </p>
            </div>
            <div class="col-sm-4 text-center text-sm-left border rounded">
              <?php
              $data=[];
                if(isset($_COOKIE['damares-program'])){
                  $data = json_decode($_COOKIE['damares-program'],true);
                }
                  if(isset($data)&&in_array($rel_id,$data)){
              ?>
                <?=$rel_fe_program_saved?>
              <?php
                }else{

              ?>
              <?=$rel_fe_program_add?><br>
              <a class="btn btn-info my-3" href="admin/core/mngRelations.php?rel_id=<?=$rel_id?>&page=relations" type="submit">
                <?=$rel_fe_program_button?>
              </a>
              <?php
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card service-card bg-light mb-3">
      
      <div class="card-body">
        <div class="align-items-center">
          <ul class="nav nav-tabs" id="bootstrapTab" role="tablist">
            <li class="nav-item me-2" role="presentation">
              <button class="nav-link active" id="speakers-tab" data-bs-toggle="tab" data-bs-target="#speakers" type="button"
                role="tab" aria-controls="speakers" aria-selected="true"><?=$sess_fe_speakers?></button>
            </li>
          <?php

          if($quiz_plugin){
            ?>
              <li class="nav-item me-2" role="presentation">
                <button class="nav-link" id="quiz-tab" data-bs-toggle="tab" data-bs-target="#quiz" type="button"
                  role="tab" aria-controls="quiz" aria-selected="true">Quiz</button>
              </li>
            <?php
            } 
          ?>
          </ul>

          <div class="tab-content p-3 border-top-0 bg-white" id="bootstrapTabContent">

          <!-- tab speakers -->

            <div class="tab-pane fade show active" id="speakers" role="tabpanel" aria-labelledby="speakers-tab">
            <div class="row">
            <div class="col text-dark">
              <b><?=$sess_fe_speakers?>:</b>
            </div>
          </div>
          <?php

            $speakers_str=$row['speakers_id'];
            $speakers_arr=explode(",",$speakers_str); 
           

            foreach($speakers_arr as $sp){
              $session->id=$sp;
              $stmt3=$session->showAllWhereTable('speakers_name','speakers',['id']);
              $row3=$stmt3->fetch(PDO::FETCH_ASSOC);

              $col_name="col-md-5";
              $col_file="col-md-7";
         
            ?>
          <div class="row border-bottom border-dark py-3">

            <div class="<?=$col_name?>">
              <div class="text-white badge-avater-wrap d-flex align-items-center my-3">
                <a class="me-2 badge-avater badge-avater-lg" href="speakers-details.php?id=<?=$row3['id']?>&p=relation-details&rel_id=<?=$rel_id?>&page_link=<?=$page_origin?>">
                  <img class="img-circle" src="uploads/<?=$row3['avatar']?>" alt="">
                </a>
                <a href="speakers-details.php?id=<?=$row3['id']?>&p=relation-details&rel_id=<?=$rel_id?>&page_link=<?=$page_origin?>">
                  <?=$row3['speakers_name']?>
                </a>
              </div>
            </div>
            <div class="<?=$col_file?>">
              <p class="text-dark"><?=$rel_fe_file?>:</p>
              <ul>
              
              <?php
                
                $relation->relation_id=$rel_id;
                $relation->speaker_id=$sp;
                $relation->table = "relations_speakers_doc";

                $stmt1 = $relation->showAllWhere('id',['relation_id','speaker_id']);

                
                while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                  extract($row1);
                  $relation->id=$row1['speaker_doc_id'];
                  $relation->table = "speakers_doc";
                  $stmt2=$relation->showAllWhere('id',['id']);
                  $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
                ?>
                  <li><a href="uploads/<?=$row2['speakers_doc_name']?>">- <?=$row2['label']?></a></li>
                <?php
                }
                ?>


              </ul>
            </div>
          </div>
          <?php
          
              }
            ?>
            
            </div>


            <!-- quiz tab -->
            <div class="tab-pane fade" id="quiz" role="tabpanel" aria-labelledby="quiz-tab">
                
                <?php
                  echo $rel_id ;
                  $quiz->relation_id = $rel_id ;
                  $quiz->table="quiz_relation";
                  $stmt7 = $quiz->showAllWhere('id',['relation_id']);
                  while($row7 = $stmt7->fetch(PDO::FETCH_ASSOC)){
                    print($row7);

                  }
                 

                ?>

            </div>
          </div>

  
         
        </div>
      </div>
    </div>

    <?php
    }

    ?>
                </div>
         
          </div>

    <div class="pb-3"></div>
  </div>

  
<?php
require "inc/footer.php";
?>