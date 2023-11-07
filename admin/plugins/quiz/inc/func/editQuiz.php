<?php

use bdk\Debug\Utility\Php;

    $quiz_id = filter_input(INPUT_GET,"idToMod") ;
    $quiz->id = $quiz_id;
    $quiz->table="quiz";
    $stmt = $quiz->showAllWhere('id',['id']);
?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$quiz_edit_header?></h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav
        aria-label="breadcrumb"
        class="breadcrumb-header float-start float-lg-end"
      >
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?=$common_dashboard?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
          <?=$quiz_edit_header?>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>

<?php

$row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);
    $counter = $row['counter'];
    $name=$row['quiz_name'];
    $uc_name=str_replace("_"," ",$name);
    $uc_name=ucfirst($uc_name);
    $active=$row['active'];
    
    $active_bg="danger";
    $checked="";
    
    if($active==1){
        $active_bg="success";
        $checked="checked";
    }

    $quiz->table="quiz_relation";
    $quiz->quiz_id=$quiz_id;
    $stmt1=$quiz->showAllWhere('id',['quiz_id']);
    $row1=$stmt1->fetch(PDO::FETCH_ASSOC);
    extract($row1);
    $relation_id=$row1['relation_id'];
    

    require "../quiz/q_$quiz_id/qna.php";
    

?>

<section class="section">
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                <h4 class="card-title"><?=$quiz_edit_title?>: "<?=$name?>"</h4>
                </div>
                <div class="card-content">
                <div class="card-body">

                <form class="form form-horizontal" action="core/mngQuiz.php" method="POST"  enctype="multipart/form-data">

                        <div class="row mb-3 text-white border-bottom pb-3">
                            <div class="col-md-3 bg-<?=$active_bg?> py-2">
                                <label><?=$quiz_all_active?></label>
                            </div>
                            <div class="col-md-2 bg-<?=$active_bg?> py-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input delete" type="checkbox" name="activeQuiz" id="flexSwitchCheckDefault" <?=$checked?>>
                                </div>
                            </div>
                            <div class="col-md-2 p-1 d-flex justify-content-end">
                                <button
                                type="submit"
                                class="btn btn-primary me-1 mb-1"
                                >
                                <?=$common_update?>
                                </button>
                            </div>                        
                        </div>
                        <input type="hidden" name="operation" value="editActive">
                        <input type="hidden" name="origin" value="editQuiz">
                        <input type="hidden" name="idToMod" value="<?=$quiz_id?>">

                    </form>

                    <form class="form form-horizontal" action="core/mngQuiz.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3 pt-3">
                                <label><?=$add_quiz_name ?>  <span class="text-danger">*</span></label><br>
                            </div>
                            <div class="col-md-9 pt-3">
                                <div class="form-group">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" placeholder="Nome del quiz" name="name" value="<?=$uc_name?>" data-parsley-required="true"/>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="quiz_id" value="<?=$quiz_id?>">

                        <div class="col-md-3">
                            <label><?=$add_quiz_rel ?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">

                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                    <select class="form-select" name="relation" id="basicSelect"
                                        data-parsley-required="true">
                                        <?php
                                            $relation->table = "relations" ;
                                            $stmt2 = $relation->showAll('id');
                                            while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                                                $selected="";
                                                extract($row2);

                                                if($row2['id']==$relation_id){
                                                    $selected="selected";
                                                }
                                        ?>

                                                <option value="<?=$row2['id']?>" <?=$selected?>><?=$row2['relations_name']?></option>
                                        
                                        <?php
                                            }
                                        ?>
                                        
                                        
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 border-top p-3">
                            <h4><?=$add_quiz_questions?></h4>
                        </div>
                        <div class="row" id="dynamic_field">
                        
                        <?php
                            $count=1;
                            foreach($quiz as $item){
                        ?>

                        <div class="row" id="row<?=$count?>">                
                            <div class="col-md-3 pt-3 border-top">
                                <label><?=$add_quiz_question?>  <span class="text-danger">*</span></label><br>
                                <div class="form-check form-switch quiz">
                                    <input class="form-check-input delete" type="checkbox" name="check_<?=$count?>" id="flexSwitchCheckDefault" >
                                    <label class="form-check-label text-danger" for="flexSwitchCheckDefault">Elimina </label>
                                </div>
                            </div>
                            <div class="col-md-9 pt-3 border-top">
                                <div class="form-group">
                                    <div class="position-relative">
                                        <textarea 
                                        rows="3" 
                                        class="form-control" 
                                        name="q_<?=$count?>" 
                                        data-parsley-required="true"><?=$item['q']?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 pt-3">
                                <label><?=$add_quiz_answer?></label>
                            </div>
                            <div class="col-md-9 pt-3">
                                <div class="form-group">
                                    <div class="form-check mandatory">
                                        <div class="position-relative">
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <label>1 <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-10">
                                                <?php
                                                    $a_checked="";
                                                    if($item['a']==0){
                                                        $a_checked="checked";
                                                    }
                                                    $opt=" ";
                                                    if($item['o'][0]!="null"){
                                                        $opt=$item['o'][0];
                                                    }
                                                ?>
                                                <input class="form-check-input" type="radio" name="a_<?=$count?>[]" value="0" <?=$a_checked?>> <?=$add_quiz_ok?>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Risposta" name="o_<?=$count?>[]" value="<?=$opt?>" data-parsley-required="true"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check mandatory">
                                        <div class="position-relative">
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <label>2 <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-10">
                                                <?php
                                                    $a_checked="";
                                                    if($item['a']==1){
                                                        $a_checked="checked";
                                                    }
                                                    $opt=" ";
                                                    if($item['o'][1]!="null"){
                                                        $opt=$item['o'][1];
                                                    }
                                                ?>
                                                <input class="form-check-input" type="radio" name="a_<?=$count?>[]" value="1" <?=$a_checked?>> <?=$add_quiz_ok?>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Risposta" name="o_<?=$count?>[]" value="<?=$opt?>" data-parsley-required="true"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check mandatory">
                                        <div class="position-relative">
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <label>3 </label>
                                            </div>
                                            <div class="col-md-10">
                                                <?php
                                                    $a_checked="";
                                                    if($item['a']==2){
                                                        $a_checked="checked";
                                                    }
                                                    $opt=" ";
                                                    if($item['o'][2]!="null"){
                                                        $opt=$item['o'][2];
                                                    }
                                                ?>
                                                <input class="form-check-input" type="radio" name="a_<?=$count?>[]" value="2" <?=$a_checked?>> <?=$add_quiz_ok?>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Risposta" name="o_<?=$count?>[]" value="<?=$opt?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check mandatory">
                                        <div class="position-relative">
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <label>4 </label>
                                            </div>
                                            <div class="col-md-10">
                                                <?php
                                                    $a_checked="";
                                                    if($item['a']==3){
                                                        $a_checked="checked";
                                                    }
                                                    $opt=" ";
                                                    if($item['o'][3]!="null"){
                                                        $opt=$item['o'][3];
                                                    }
                                                ?>
                                                <input class="form-check-input" type="radio" name="a_<?=$count?>[]" value="3" <?=$a_checked?>> <?=$add_quiz_ok?>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Risposta" name="o_<?=$count?>[]"  value="<?=$opt?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                         </div>

                         <?php
                            $count++;
                            }
                         ?>

                        </div>
                         <button type="button" name="add" id="add" class="btn btn-success w-25"><?=$add_quiz_more?></button>
                        </div>

                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="origin" value="editQuiz">
                        <input type="hidden" name="counter" value="<?=$counter?>" id="counter">
                      
                        <div class="col-12 d-flex justify-content-end">
                            <button
                            type="submit"
                            class="btn btn-primary me-1 mb-1"
                            >
                            <?=$common_submit?>
                            </button>
                            <button
                            type="reset"
                            class="btn btn-light-secondary me-1 mb-1"
                            >
                            <?=$common_reset?>
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?=$common_info?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>