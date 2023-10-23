<?php
$session->table="people";
$people = $session->showAll('id');

?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$people_all_header?></h3>
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
          <?=$people_all_header?>
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
    <div class="card-header"><?=$people_all_title?> &nbsp; &nbsp; &nbsp; 
                    <a href="index.php?p=addPeople" class="btn icon icon-left btn-success"
                        ><i data-feather="plus-circle"></i> <?=$people_all_add?></a
                      ></div>
    <div class="card-body">
      <table class="table" id="table1">
        <thead>
          <tr>
            <th><?=$people_all_avatar?></th>
            <th><?=$common_name?></th>
            <th><?=$people_all_role?></th>
            <th><?=$common_actions?></th>
          </tr>
        </thead>
        <tbody>
          
        <?php
        while($row = $people->fetch(PDO::FETCH_ASSOC)){
          extract($row);
        ?>
          <tr>
            <td><div class="avatar bg-warning me-3">
                    <img src="uploads/avatar/<?=$row['avatar']?>" alt="" srcset="">
                </div></td>
            <td><?=$row['people_name']?></td>
            <td>
              <?php
                // get the id of the role from pivot table
                $session->table = "people_cat_id" ;
                $session->id = $row['id'] ;
                $stmt1 = $session->showAllWhere('id',['id']);
                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                extract($row1);

                $session->table = "people_cat";
                $session->id = $row1['cat_id'];
                $stmt2 = $session->showAllWhere('id',['id']);
                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                extract($row2);
                echo $row2['people_cat_name'];
              
              ?>
            </td>
            <td>
              <a href="index.php?p=editPeople&idToMod=<?=$row['id']?>" class="btn icon btn-warning"
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
                                    <?=$people_all_modal_body?>
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
                                        ><a href="core/mngPeople.php?idToDel=<?=$row['id']?>" class="btn btn-danger ml-1">
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
