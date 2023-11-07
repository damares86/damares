<?php

$question->table = "questions";
$question->approved = 0 ;
$stmt = $question->showAllWhere('id',['approved']);

?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$quest_all_header?></h3>
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
          <?=$quest_all_header?>
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
    <div class="card-header"><?=$quest_all_title?> &nbsp; &nbsp; &nbsp; 
                   </div>
    <div class="card-body">
      <table class="table" id="table1">
        <thead>
          <tr>
            <th><?=$quest_all_question?></th>
            <th><?=$quest_all_relation?></th>
            <th><?=$quest_all_account?></th>
            <th><?=$common_actions?></th>
          </tr>
        </thead>
        <tbody>
          
        <?php
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          
          // get relation name
          $session->table = "sessions";
          $session->id = $row['session_id'];
          $stmt1=$session->showAllWhere('id',['id']);
          $row1=$stmt1->fetch(PDO::FETCH_ASSOC);
          extract($row1);
          $session_name=$row1['sessions_name'];

          // get acocunt name
          $account->table = "accounts";
          $account->id=$row['account_id'];
          $stmt2 = $account->showAllWhere('id',['id']);
          $row2=$stmt2->fetch(PDO::FETCH_ASSOC);
          extract($row2);
          $account_name=$row2['username'];


        ?>
          <tr>
            <td><?=$row['question']?></td>
            <td><?=$session_name?></td>
            <td><?=$account_name?></td>
            <td>
              <a href="core/mngQuestions.php?idToApp=<?=$row['id']?>" class="btn icon btn-success"
                ><i class="bi bi-check-circle"></i
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
                                    <?=$quest_all_modal_body?>
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
                                        ><a href="core/mngQuestions.php?idToDel=<?=$row['id']?>" class="btn btn-danger ml-1">
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
