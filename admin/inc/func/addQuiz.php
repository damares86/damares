<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$add_quiz_header?></h3>
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
          <?=$add_quiz_header?>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>

<section class="section">
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                <h4 class="card-title"><?=$add_quiz_title?></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngQuiz.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3 pt-3">
                                <label><?=$add_quiz_name?>  <span class="text-danger">*</span></label><br>
                            </div>
                            <div class="col-md-9 pt-3">
                                <div class="form-group">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" placeholder="Nome del quiz" name="name" data-parsley-required="true"/>
                                    </div>
                                </div>
                            </div>

                        <div class="col-md-3">
                            <label><?=$add_quiz_relation?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">

                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                    <select class="form-select" name="relation" id="basicSelect"
                                        data-parsley-required="true">
                                        <?php
                                            $relation->table = "relations" ;
                                            $stmt = $relation->showAll('id');
                                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                extract($row);
                                        ?>

                                                <option value="<?=$row['id']?>"><?=$row['relations_name']?></option>
                                        
                                        <?php
                                            }
                                        ?>
                                        
                                        
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 border-top p-3">
                            <h4><?=$add_quiz_question?></h4>
                        </div>
                        <div class="row" id="dynamic_field">
                        <div class="row" id="row1">                
                            <div class="col-md-3 pt-3 border-top">
                                <label><?=$add_quiz_question?>  <span class="text-danger">*</span></label><br>
                                <!-- <button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button> -->
                            </div>
                            <div class="col-md-9 pt-3 border-top">
                                <div class="form-group">
                                    <div class="position-relative">
                                        <textarea 
                                        rows="3" 
                                        class="form-control" 
                                        name="q_1" 
                                        data-parsley-required="true"><?=$add_quiz_question_text?></textarea>
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
                                                <input class="form-check-input" type="radio" name="a_1[]" value="0"> <?=$add_quiz_ok?>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Risposta" name="o_1[]" data-parsley-required="true"/>
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
                                                <input class="form-check-input" type="radio" name="a_1[]" value="1"> <?=$add_quiz_ok?>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Risposta" name="o_1[]" data-parsley-required="true"/>
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
                                                <input class="form-check-input" type="radio" name="a_1[]" value="2"> <?=$add_quiz_ok?>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Risposta" name="o_1[]"/>
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
                                                <input class="form-check-input" type="radio" name="a_1[]" value="3"> <?=$add_quiz_ok?>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Risposta" name="o_1'[]" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                         </div>
                        </div>
                         <button type="button" name="add" id="add" class="btn btn-success w-25"><?=$add_quiz_more?></button>
                        </div>

                        <input type="hidden" name="operation" value="add">
                        <input type="hidden" name="origin" value="addQuiz">
                        <input type="hidden" name="counter" value="1" id="counter">
                      
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