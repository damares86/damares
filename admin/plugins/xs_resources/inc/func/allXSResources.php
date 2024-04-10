<?php
$xsresources->table = 'resources' ;
$stmt = $xsresources->showAll('id');

?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$xs_res_all_header?></h3>
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
          <?=$xs_res_all_header?>
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
    <div class="card-header"><?=$xs_res_all_title?> &nbsp; &nbsp; &nbsp; 
                    <a href="index.php?p=addXSResource" class="btn icon icon-left btn-success shadow"
                        ><i data-feather="plus-circle"></i> <?=$xs_res_all_add_button?></a
                      ></div>
    <div class="card-body">
      <table class="table" id="table1">
        <thead>
          <tr>
            <th><?=$xs_res_add_title_res?></th>
            <th><?=$xs_res_all_date?></th>
            <th><?=$xs_res_all_prod?></th>
            <th><?=$xs_res_add_lang?></th>
            <th><?=$xs_res_add_type?></th>
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
                $xsresources->table = 'product' ;
                $xsresources->id = $row['product_id'] ; 
                $stmt1 = $xsresources->showAllWhere('id',['id']) ;
                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ;
                echo $row1['product_name'] ;
              ?>
            </td>
            <td>
              <?php
                $xsresources->table = 'resource_lang' ;
                $xsresources->id = $row['lang_id'] ; 
                $stmt2 = $xsresources->showAllWhere('id',['id']) ;
                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC) ;
                echo $row2['resource_lang'] ;
              ?>
            </td>
            <td>
              <?php
                $xsresources->table = 'resource_type' ;
                $xsresources->id = $row['type_id'] ; 
                $stmt3 = $xsresources->showAllWhere('id',['id']) ;
                $row3 = $stmt3->fetch(PDO::FETCH_ASSOC) ;
                echo $row3['resource_type'] ;
              ?>
            </td>
            <td><a href="uploads/<?=$row['resource_name']?>" target="_blank">Link</a></td>
            <td>
              <a href="index.php?p=editXSResource&idToMod=<?=$row['id']?>" class="btn icon btn-warning"
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
                                    <?=$xs_res_all_modal_body?>
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
                                        ><a href="core/mngXSResources.php?idToDel=<?=$row['id']?>" class="btn btn-danger ml-1">
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
