<?php
$gamresources->table = 'resources' ;
$stmt = $gamresources->showAll('id');

?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$gam_all_file_header?></h3>
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
          <?=$gam_all_file_header?>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>


<!-- Basic Tables start -->
<section class="section">
  <div class="card shadow">
    <div class="card-header"><?=$gam_all_file_title?> &nbsp; &nbsp; &nbsp; 
                    <a href="index.php?p=addGamResource" class="btn icon icon-left btn-success shadow"
                        ><i data-feather="plus-circle"></i> <?=$gam_all_file_add?></a
                      ></div>
    <div class="card-body">
      <table class="table" id="table1">
        <thead>
          <tr>
            <th><?=$gam_all_file_name?></th>
            <th><?=$gam_all_file_date?></th>
            <th><?=$gam_all_file_type?></th>
            <th><?=$gam_all_file_cat?></th>
            <th><?=$common_link?></th>
            <th><?=$common_actions?></th>
          </tr>
        </thead>
        <tbody>
          
        <?php
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
        ?>
          <tr>
            <td><?=$row['title']?></td>
            <td><?=$row['resource_date']?></td>
            <td>
              <?php
                $gamresources->table = 'resource_type' ;
                $gamresources->id = $row['type_id'] ; 
                $stmt3 = $gamresources->showAllWhere('id',['id']) ;
                $row3 = $stmt3->fetch(PDO::FETCH_ASSOC) ;
                echo $row3['type'] ;
              ?>
            </td>
            <td>
              <?php
                $gamresources->table = 'resource_cat' ;
                $gamresources->id = $row['cat_id'] ; 
                $stmt2 = $gamresources->showAllWhere('id',['id']) ;
                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC) ;
                echo $row2['cat'] ;
              ?>
            </td>

            <td><a href="uploads/<?=$row['resource_name']?>" target="_blank">Link</a></td>
            <td>
              <a href="index.php?p=editGamResource&idToMod=<?=$row['id']?>" class="btn icon btn-warning shadow"
                ><i class="bi bi-pencil-square"></i
              ></a>
              &nbsp; &nbsp;
              <a href="#" class="btn icon btn-danger shadow"
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
                                    <?=$gam_all_file_modal_body?>
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
                                        ><a href="core/mngGamResources.php?idToDel=<?=$row['id']?>" class="btn btn-danger ml-1">
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
