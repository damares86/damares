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

$plugin->pluginname = "questions" ;
$qea = false;
if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
    $qea = true ;
}

$plugin->pluginname = "quiz" ;
$quiz = false;
// if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
//     $quiz = true ;
// }

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
    </div> -

    <div class="pt-3"></div>

    <div class="container">
    
    <?php

    require "inc/alert.php" ;

    $page_origin=filter_input(INPUT_GET,"p");
 
    $sess_id = filter_input(INPUT_GET,"id");
    $session->id= $sess_id;
    $session->table = "sessions";
    $stmt1 = $session->showAllWhere('id',['id']);
    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    extract($row1);

     
    if($lang=="it"){
      $newDate=date("d/m/Y", strtotime($row1['date']));
      }else{
        $newDate=date("Y/m/d", strtotime($row1['date']));
      }
      $st_arr=explode(":",$row1['start_time']);
      $et_arr=explode(":",$row1['end_time']);

      $st= $st_arr[0].":".$st_arr[1];
      $et= $et_arr[0].":".$et_arr[1];
      
      $session->table = "location";
      $session->id = $row1['location_id'];

      $active_sess=$row1['active'];

      $stmt2=$session->showAllWhere('id',['id']);
      $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
      extract($row2);
    ?>
<a class="p-3 mb-5 back-link" href="<?=$page_origin?>.php"><i class="bi bi-arrow-left-circle"></i> <?=$rel_fe_back?></a>

    <h3 class="text-center mt-3"><?=$row1['sessions_name']?></h3>
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
            
          <div class="col-sm-4 text-center text-sm-left">
          <?php

          if($rating){
            $rate->cat_name = "sessions" ;
            $rate->table = "rate_cat";
            
            $stmt3 = $rate->showAllWhere('id',['cat_name']);
            $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
            extract($row3);
            
            $rate->table="item_rate";
            $rate->rate_cat_id=$row3['id'];
            $rate->item_id = $sess_id;
            $stmt4=$rate->showAllWhere('id',['item_id','rate_cat_id']);
            $row4=$stmt4->fetch(PDO::FETCH_ASSOC);
            extract($row4);

            $item_rate_id=$row4['id'];
            if($row4['rate_active']==1){
              
              if(!$cookie_rating || !in_array($row4['id'],$cookie_rating)){
          ?>
          <div class="col-12">
          <form action="admin/core/mngRate.php" method="POST">
            <div class="rating-card-three text-center">
              <div class="stars">
                <input class="stars-checkbox" id="first-star" type="radio" name="star" value="5">
                <label class="stars-star" for="first-star">
                  <svg class="star-icon" id="star1" version="1.1" xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 53.867 53.867"
                  style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve">
                  
                        <polygon
                          points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 10.288,52.549 13.467,34.013 0,20.887 18.611,18.182">
                        </polygon>
                      </svg>
                    </label>

                    <input class="stars-checkbox" id="second-star" type="radio" name="star" value="4">
                    <label class="stars-star" for="second-star">
                      <svg class="star-icon" id="star2" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 53.867 53.867"
                        style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve">
                        <polygon
                          points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 10.288,52.549 13.467,34.013 0,20.887 18.611,18.182">
                        </polygon>
                      </svg>
                    </label>

                    <input class="stars-checkbox" id="third-star" type="radio" name="star" value="3">
                    <label class="stars-star" for="third-star">
                      <svg class="star-icon" id="star3" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 53.867 53.867"
                        style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve">
                        <polygon
                          points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 10.288,52.549 13.467,34.013 0,20.887 18.611,18.182">
                        </polygon>
                      </svg>
                    </label>

                    <input class="stars-checkbox" id="fourth-star" type="radio" name="star" value="2">
                    <label class="stars-star" for="fourth-star">
                      <svg class="star-icon" id="star4" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 53.867 53.867"
                        style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve">
                        <polygon
                          points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 10.288,52.549 13.467,34.013 0,20.887 18.611,18.182">
                        </polygon>
                      </svg>
                    </label>

                    <input class="stars-checkbox" id="fifth-star" type="radio" name="star" value="1">
                    <label class="stars-star" for="fifth-star">
                      <svg class="star-icon" id="star5" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 53.867 53.867"
                        style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve">
                        <polygon
                          points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 10.288,52.549 13.467,34.013 0,20.887 18.611,18.182">
                        </polygon>
                      </svg>
                    </label>
                  </div>

                  <input type="hidden" name="idToMod" value="<?=$sess_id?>">
                  <input type="hidden" name="idOrigin" value="<?=$sess_id?>">
                  <input type="hidden" name="origin" value="session-details">
                  <input type="hidden" name="p" value="sessions">
                  <input type="hidden" name="operation" value="rateFe">
                  <input type="hidden" name="rate_cat" value="sessions">

                  <button class="btn btn-success my-3" type="submit"><?=$fe_button?></button>
                </div>
              </form>
          </div>
          <?php
            }else{
              // $rate->table = "rate";
              // $rate->item_rate_id = $item_rate_id ;
              // $stmt5 = $rate->showAllWhere('id',['item_rate_id']);
              // $row5 = $stmt4->fetch(PDO::FETCH_ASSOC);
              // extract($row4);
              // $vote_rate = $row4['star_vote'];
          ?>
          <!-- <div class="col d-none d-lg-block">&nbsp;</div>
          <div class="col-12 col-lg-4 py-3">
             <div class="rating-card-one">
              <div class="d-flex align-items-center justify-content-center">
                <div class="rating"> -->

                  <?php
                  // for($i=1;$i<6;$i++){
                  //   $fill="star-fill";
                  //   $ceil = ceil($vote_rate);

                  //   if($ceil==$i&&$ceil!=$vote_rate){
                  //     $fill="star-half";
                  //   }else if($ceil<$i){
                  //     $fill="star";
                  //   }

                  ?>

                    <!-- <a href="#"><i class="bi bi-<?=$fill?>"></i></a> -->

                  <?php
                  // }
                  // $votes = $fe_votes;
                  // if($row4['vote_number']==1){
                  //   $votes = $fe_vote;
                  // }
                  ?>

                <!-- </div>
              </div>
              <span><?=$row4['vote_number']?> <?=$votes?></span>
            </div>
          </div>
          <div class="col d-none d-lg-block">&nbsp;</div> -->

            <?php
            }
          }
          }
          ?>
          </div>
      </div>
    </div>
    <div class="card service-card bg-light mb-3">
      
      <div class="card-body">
        <div class="align-items-center">
          <ul class="nav nav-tabs" id="bootstrapTab" role="tablist">
            <li class="nav-item me-2" role="presentation">
              <button class="nav-link active" id="speakers-tab" data-bs-toggle="tab" data-bs-target="#speakers" type="button"
                role="tab" aria-controls="speakers" aria-selected="true"><?=$rel_fe_relations?></button>
            </li>
          <?php
          if($qea && $active_sess==1){
          ?>
            <li class="nav-item me-2" role="presentation">
              <button class="nav-link" id="question-tab" data-bs-toggle="tab" data-bs-target="#question" type="button"
                role="tab" aria-controls="question" aria-selected="true">Domande</button>
            </li>
          <?php
          } 
          if($quiz){
            ?>
              <li class="nav-item me-2" role="presentation">
                <button class="nav-link" id="question-tab" data-bs-toggle="tab" data-bs-target="#question" type="button"
                  role="tab" aria-controls="question" aria-selected="true">Quiz</button>
              </li>
            <?php
            } 
          ?>
          </ul>

          <div class="tab-content p-3 border-top-0 bg-white" id="bootstrapTabContent">

          <!-- tab speakers -->

            <div class="tab-pane fade show active" id="speakers" role="tabpanel" aria-labelledby="speakers-tab">
            <div class="row">

          </div>
          <?php

$rel_id_str = $row1['relations_id'];
$rel_id=explode(",",$rel_id_str);

foreach($rel_id as $item){

  $relation->id = $item;
  $relation->table = "relations";

  $stmt5 = $relation->showAllWhere('id',['id']);
  while($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)){

    extract($row5);

  ?>

    <div class="card session-card bg-light mb-3">
      <div class="card-body sessions">
        <div class="align-items-center">
          <div class="row p-3">
            <div class="col-md-7">
              <h5 class=" text-info"><?=$row5['relations_name']?></h5>
            </div>
            <div class="col-md-5 text-right">
                      <p><?=$rel_fe_location?>: <b>
                        <?php
                        
                        $session->id = $row5['location'];
                        $session->table = "location";
                        $stmt6 = $session->showAllWhere('id',['id']);
                        $row6=$stmt6->fetch(PDO::FETCH_ASSOC);
                        extract($row6);
                        echo $row6['location_name'];
                        ?>
                        
                      </b><br>
                      <?=$rel_fe_time?>: <b><?=$st?> - <?=$et?></b></p>
            </div>
          </div>
          <div class="row mt-3 p-3">
            <div class="col-md-8">
              <b><?=$rel_fe_speakers?>:</b>

              <?php

                $speakers_str=$row5['speakers_id'];
                $speakers_arr=explode(",",$speakers_str); 
                $count=0;
                foreach($speakers_arr as $sp){

                  $session->id=$sp;
                  $stmt7=$session->showAllWhereTable('speakers_name','speakers',['id']);
                  $row7=$stmt7->fetch(PDO::FETCH_ASSOC);
                  if($count>0){
                  echo ", ";
                  }
                  echo $row7['speakers_name'];
                  $count++;
          
                }
                ?>

            </div>
            <div class="col-md-4">
            <a class="btn m-1 goto btn-creative btn-primary" href="relation-details.php?id=<?=$item?>&p=session-details&ipsess=<?=$sess_id?>"><?=$rel_fe_button_details?></a>
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

            <!-- tab question -->

            <div class="tab-pane fade" id="question" role="tabpanel" aria-labelledby="question-tab">
              <div class="row">
                <div class="col-12 my-3">

                  <form action="admin/core/mngQuestions.php" method="POST">
                    <div class="form-group">
                      <label class="form-label" for="question-form"><?=$quest_fe_insert?></label>
                      <textarea class="form-control" id="question-form" name="question-form" cols="1" rows="1" placeholder="<?=$quest_fe_insert_ph?>"></textarea>
                    </div>
                    
                    <input type="hidden" name="account_id" value="<?=$_SESSION['account_id']?>">
                    <input type="hidden" name="session_id" value="<?=$sess_id?>">
                    <input type="hidden" name="operation" value="add">
                    <input type="hidden" name="p" value="<?=$page_origin?>">


                    <button class="btn btn-primary w-100 d-flex align-items-center justify-content-center" type="submit">
                      <?=$common_submit?>
                      <i class="bi bi-arrow-right fz-16 ms-1"></i>
                    </button>
                  </form>

                </div>

                <div class="col-12 mt-3  py-3 border-top">
                  <div class="row">
                  <?php
                    $question->table="questions";
                    $question->session_id = $sess_id ;
                    $stmt5 = $question->showAllWhere('id',['session_id']);
                    
                    while($row5=$stmt5->fetch(PDO::FETCH_ASSOC)){
                        extract($row5);
                        if($row5['approved']==1){
                          $account->table = "accounts";
                          $account->id=$row5['account_id'];
                          $stmt6 = $account->showAllWhere('id',['id']);
                          $row6=$stmt6->fetch(PDO::FETCH_ASSOC);
                          extract($row6);
                          $details=unserialize($row['details']);
                          $details_opt=unserialize($row['details_opt']);
                          $account_name= $details[0]['nome']." ".$details[1]['cognome'];

                      ?>

                        <div class="col-12 bg-info p-3 m-3 rounded">
                          <p class="text-white"><b><?=$account_name?>:</b><br> <?=$row5['question']?></p>
                        </div>
                                            
                      <?php  
                        }
                    }
                    
                    ?>
                    </div>

                </div>

              </div>


            </div>
          </div>

  
         
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