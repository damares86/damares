<?php

require "inc/header.php";

// require "inc/sidebar.php";

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
    
    <?php

    require "inc/alert.php" ;

    $q_id = filter_input(INPUT_GET,'id');
    $quiz->table = 'quiz' ;
    $quiz->id = $q_id ;
    $stmt1 = $quiz->showAllWhere('id',['id']);
    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    extract($row1);
    $name = ucfirst($row1['quiz_name']);
    $name = str_replace("_", " ", $name );
    ?>


    <div class="card bg-lightt mb-3">
      <div class="card-body">
        <div class="text-left">
          <div class="service-text text-info">
            <h3 class=" text-info"><?=$name?></h3>
            <?php

              $quiz->quiz_id = $q_id ;
              $quiz->table = "quiz_scores";
              $stmt2 = $quiz->showAllWhere('id',['quiz_id']) ;
              $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
              extract($row2);
              
              $account->id = $row2['winner_id'] ;
              $stmt3 = $account->showAllWhere('id',['id']); 
              $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
              extract($row3);
              $details=unserialize($row3['details']);

              
            ?>
            <h6 class="my-5 p-2 bg-success"><?=$quiz_fe_winner?>: <span class="font-weight-bold text-decoration-underline"><?=$details[0]['nome']?> <?=$details[1]['cognome']?></h6>
            <div>
                <?php
            
                  require "quiz/q_$q_id/qna.php";
                  for($i=0;$i<count($quiz);$i++){
                    $question = $quiz[$i]['q'];
                    $idx = $quiz[$i]['a'];
                    $ans_ok = $quiz[$i]['o'][$idx];
                ?>    
                <div class="card bg-info bg-gradient mb-3 p-3">
                  <h4 class="text-light"><?=$question?></h4>
                  <p class="text-light"><b><?=$quiz_fe_answer?>:</b> <?=$ans_ok?></p>
                </div>
                <?php

                  }


                ?>
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