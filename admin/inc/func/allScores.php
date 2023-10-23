<?php
$relation->table="speakers";
$speakers = $relation->showAll('id');

?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$speakers_all_header?></h3>
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
          <?=$speakers_all_header?>
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
    <div class="card-header"><?=$speakers_all_title?> &nbsp; &nbsp; &nbsp; 
                    <a href="index.php?p=addSpeaker" class="btn icon icon-left btn-success"
                        ><i data-feather="plus-circle"></i> <?=$speakers_all_add?></a
                      ></div>
    <div class="card-body">
      <table class="table" id="table1">
        <thead>
          <tr>
            <th><?=$speakers_all_avatar?></th>
            <th><?=$common_name?></th>
            <th><?=$common_actions?></th>
          </tr>
        </thead>
        <tbody>
          
        <?php
        while($row = $speakers->fetch(PDO::FETCH_ASSOC)){
          extract($row);
        ?>
          <tr>
            <td><div class="avatar bg-warning me-3">
                    <img src="uploads/avatar/<?=$row['avatar']?>" alt="" srcset="">
                </div></td>
            <td><?=$row['speakers_name']?></td>
            <td>
              <a href="index.php?p=editSpeaker&idToMod=<?=$row['id']?>" class="btn icon btn-warning"
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
                                    <?=$speakers_all_modal_body?>
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
                                        ><a href="core/mngSpeakers.php?idToDel=<?=$row['id']?>" class="btn btn-danger ml-1">
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
