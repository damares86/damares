<?php

$quiz->table = "quiz";
$stmt = $quiz->showAll('id');

?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$quiz_all_header?></h3>
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
          <?=$quiz_all_header?>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>


<!-- Basic Tables start -->
<section class="section">
  <div class="card">
    <div class="card-header"><?=$quiz_all_title?> &nbsp; &nbsp; &nbsp; 
                    <a href="index.php?p=addQuiz" class="btn icon icon-left btn-success"
                        ><i data-feather="plus-circle"></i> <?=$add_quiz_title?></a
                      ></div>
    <div class="card-body">
      <table class="table" id="table1">
        <thead>
          <tr>
            <th><?=$quiz_all_name?></th>
            <th><?=$quiz_all_rel?></th>
            <th><?=$quiz_all_result?></th>
            <th><?=$quiz_all_active?></th>
            <th><?=$common_actions?></th>
          </tr>
        </thead>
        <tbody>
          
        <?php

        $quiz_active="";

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          $class="";
          $quiz_active=$quiz_all_active_no;

          if($row['active']==1){
            $class="class=\"bg-success text-white\"";
            $quiz_active=$quiz_all_active_yes;
          }
          $quiz_name = str_replace("_"," ",$row['quiz_name']);
          $quiz_name = ucfirst($quiz_name);
          ?>
          <tr <?=$class?>>
            <td><?=$quiz_name?></td>
            <td>
              <?php
                $quiz->table="quiz_relation";
                $quiz->quiz_id = $row['id'];
                $stmt1 = $quiz->showAllWhere('id',['quiz_id']);
                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                extract($row1);

                $relation->table = "relations";
                $relation->id= $row1['relation_id'];
                $stmt2 = $relation->showAllWhere('id',['id']);
                $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
                extract($row2);
                echo $row2['relations_name'];
              ?>          
            </td>
            <td>

              <?php

                $quiz->quiz_id = $row['id'] ;
                $quiz->table="quiz_scores" ;
                $stmt3 = $quiz->showAllWhere('id',['quiz_id']) ;
                $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
                if($row3){
              ?>
                <a href="../quiz_results.php?id=<?=$row['id']?>" target="_blank" class="btn btn-success"
                > <?=$quiz_all_result?></a>
              <?php
                }

              ?>


            </td>
            <td>
              <?=$quiz_active?>
            </td>
            <td>
              <a href="index.php?p=editQuiz&idToMod=<?=$row['id']?>" class="btn icon btn-warning"
                ><i class="bi bi-pencil-square"></i
              ></a>
              &nbsp; &nbsp;
              <a href="#" class="btn icon btn-danger"
                data-bs-toggle="modal"
                data-bs-target="#danger<?=$row['id']?>"><i class="bi bi-trash"></i>
              </a>
                  <!--Danger theme Modal -->
                  <div
                              class="modal fade text-left"
                              id="danger<?=$row['id']?>"
                              tabindex="-1"
                              role="dialog"
                              aria-labelledby="myModalLabel120"
                              aria-hidden="true"
                            >
                              <div
                                class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                role="document"
                              >
                                <div class="modal-content">
                                  <div class="modal-header bg-danger">
                                    <h5
                                      class="modal-title white"
                                      id="myModalLabel120"
                                    >
                                      <?=$common_modal_title_sure?>
                                    </h5>
                                    <button
                                      type="button"
                                      class="close"
                                      data-bs-dismiss="modal"
                                      aria-label="Close"
                                    >
                                      <i data-feather="x"></i>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <?=$quiz_all_modal_body?>
                                  </div>
                                  <div class="modal-footer">
                                    <button
                                      type="button"
                                      class="btn btn-light-secondary"
                                      data-bs-dismiss="modal"
                                    >
                                      <i class="bx bx-x d-block d-sm-none"></i>
                                      <span class="d-none d-sm-block"
                                        ><?=$common_modal_cancel?></span
                                      >
                                    </button>
                                      <span class="d-none d-sm-block"
                                        ><a href="core/mngQuiz.php?idToDel=<?=$row['id']?>" class="btn btn-danger ml-1">
                                          <?=$common_modal_confirm?>
                                        </a></span
                                      >
                                  </div>
                                </div>
                              </div>
                            </div>
            </td>
          </tr>
                          

                        

        <?php
        }
        ?>



        </tbody>
      </table>
    </div>
  </div>
</section>
