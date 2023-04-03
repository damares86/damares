<?php
require "inc/funcHeader.php";

$allfiles = $rate->showAllTable('id','fileCat');

?>



<!-- Basic Tables start -->
<section class="section">
  <div class="card">
    <div class="card-header"><?=$file_all_title?> &nbsp; &nbsp; &nbsp; 
                    <a href="index.php?p=addFileRate" class="btn icon icon-left btn-success"
                        ><i data-feather="plus-circle"></i> <?=$file_all_add?></a
                      ></div>
    <div class="card-body">
      <table class="table" id="table1">
        <thead>
          <tr>
            <th><?=$file_all_label?></th>
            <th><?=$file_all_file?></th>
            <th>Categoria<?=$rate_all_cat?></th>
            <th>Punteggio<?=$rate_all_star?></th>
            <th><?=$common_link?></th>
            <th><?=$common_actions?></th>
          </tr>
        </thead>
        <tbody>
          
        <?php
        while($row = $allfiles->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          $file_id = $row['file_id'];
          $file->id = $row['file_id'];
          $rateFile = $file->showAllWhere('id',['id']);

          foreach($rateFile as $row1){

          ?>
          <tr>
            <td><?=$row1['label']?></td>
            <td><?=$row1['filename']?></td>
            <?php
              
              $rate->file_id = $file_id;
              $rate_cat = $rate->showCat() ;
              $rate->id = $rate_cat ;
              $stmt2 = $rate->showAllWhereTable('id','rate_cat',['id']);
              $row2 = $stmt2->fetch(PDO::FETCH_ASSOC) ;

            ?>
            <td>
              <?=$row2['cat_name']?>
            </td>
            <?php


              // $stmt3 = $rate->showStar() ;
              $stmt3 = $rate->showAllWhereTable('id','rate',['id']);
              $row3 = $stmt3->fetch(PDO::FETCH_ASSOC) ;
              $star = 0 ;

              if($row3['star']){
                $star = $row3['star'];
              }

            ?>
            <td>
              <?=$star?> / 5
            </td>
            <td>
              <a href="../uploads/ratefile/<?=$row1['filename']?>" target="_blank"><?=$common_link?></a>
            </td>
            <td>
              <a href="index.php?p=editFileRate&idToMod=<?=$row1['id']?>" class="btn icon btn-warning"
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
                                    <?=$file_all_modal_body?>
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
                                        ><a href="core/mngRate.php?idToDel=<?=$row1['id']?>" class="btn btn-danger ml-1"><?=$common_modal_confirm?></a></span
                                      >
                                  </div>
                                </div>
                              </div>
                            </div>
            </td>
          </tr>
                          

                        

        <?php
          }
      }

        ?>



        </tbody>
      </table>
    </div>
  </div>
</section>
