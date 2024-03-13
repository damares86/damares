<?php

$product_id = filter_input(INPUT_GET,"idToMod");
$xsproduct->id = $product_id ;
$xsproduct->table = 'product' ;

$stmt = $xsproduct->showAllWhere('id',['id']);
$row = $stmt->fetch(PDO::FETCH_ASSOC) ;
extract($row);
$prod_name = $row['product_name'];
$prod_id = $row['id'];
?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Modifica prodotto</h3>
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
          Modifica prodotto
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
                <h4 class="card-title">Modifica un prodotto</h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngXSProduct.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>

                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3">
                            <label><?=$common_name?><span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nome"
                                        id="first-name"
                                        name="name"
                                        data-parsley-required="true"
                                        value="<?=$prod_name?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="idToMod" value="<?=$product_id?>">
                        <input type="hidden" name="oldProdName" value="<?=$row['product_name']?>">
                        <input type="hidden" name="origin" value="editXSProduct">

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

        <?php
          $xsproduct->table = "product_files_cat" ;
          $stmt1 = $xsproduct->showAll('id') ;

          $table_counter = $stmt1->rowCount();

          $idx_prod=1;
          while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC))
          {
            extract($row1) ;

            $lc_cat_name = $row1['cat_name'] ;
            $cat_name = ucfirst($row1['cat_name']);
            $cat_id = $row1['id'] ;
            $folder_cat = strtolower($cat_name);
          
        ?>

        <div class="col-md-8 col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><?=$cat_name?></h4>
            </div>
            <div class="card-content">
              <div class="card-body">
              
                <h6>Aggiungi un nuovo file</h6>
                <form class="form form-horizontal mb-5 pb-3 border-bottom" action="core/mngXSProduct.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                  <div class="form-body">
                      <div class="row">
                      <div class="col-md-3">
                          <label>Label<span class="text-danger">*</span></label>
                      </div>
                      <div class="col-md-9">
                          <div class="form-group">
                              <div class="form-check mandatory">
                                  <div class="position-relative">
                                      <input
                                      type="text"
                                      class="form-control"
                                      placeholder="Titolo della risorsa"
                                      id="first-name"
                                      name="label"
                                      data-parsley-required="true"

                                      />
                                  </div>
                              </div>
                          </div>
                      </div>
           
                      <div class="col-md-3">
                            <label>Visibile a  <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                         <div class="form-group">
                                <select
                                class="choices form-select multiple-remove"
                                multiple="multiple" name="product[]"
                                >
                                <?php
                                    $xsproduct->table = 'product_permissions' ;
                                    $xsproduct->product_id = $prod_id ;
                                    $stmt = $xsproduct->showAllWhere('id',['product_id']) ; 
                                    
                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                                    {
                                        extract($row);
                                        $customer->table = 'customers';
                                        $customer->id = $row['customers_id'];
                                        $stmt1 = $customer->showAllWhere('id',['id']);

                                        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ;
                                        extract($row1) ;
                                ?>

                                    <option value="<?=$row1['id']?>" <?=$selected?>><?=$row1['name']?> (<?=$row1['company']?>)</option>

                                <?php
                                    }
                                
                                ?>

                                </select>
                            </div>
                        </div>


                      <div class="col-md-3">
                          <label><?=$file_add_file?> <span class="text-danger">*</span></label>
                      </div>
                      <div class="col-md-9">
                          <div class="form-group">
                              <div class="form-check mandatory">
                                  <div class="position-relative">
                                      <input
                                      class="form-control"
                                      type="file"
                                      id="formFile1"
                                      name="myfile"
                                      data-parsley-required="true"
                                  />
                                  </div>
                              </div>
                          </div>
                      </div>
                      <input type="hidden" name="operation" value="addFilesCat">
                      <input type="hidden" name="filesCatName" value="<?=$cat_name?>">
                      <input type="hidden" name="filesCatId" value="<?=$row1['id']?>">
                      <input type="hidden" name="productName" value="<?=$prod_name?>">
                      <input type="hidden" name="productId" value="<?=$prod_id?>">
                      <input type="hidden" name="origin" value="editXSResource">

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
                    </div>
                    </form>

              <table class="table" id="table<?=$idx_prod?>">
              <thead>
                <tr>
                  <th>Label</th>
                  <th>Filename</th>
                  <th>Link</th>
                  <th><?=$common_actions?></th>
                </tr>
              </thead>
              <tbody>
                <?php

                  $xsproduct->product_id = $product_id ;
                  $xsproduct->product_files_cat_id = $row1['id'];
                  $xsproduct->table = 'product_files' ;
                  $idx_prod++; 
                  
                  $stmt2 = $xsproduct->showAllWhere('id',['product_id','product_files_cat_id']) ;
                  while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))
                  {
                    // extract($row2);
                ?>
                <tr>
                  <td><?=$row2['product_files_label']?></td>
                  <td><?=$row2['product_files_name']?></td>
                  <td><a href="../product/<?=$prod_name?>/<?=$lc_cat_name?>/<?=$row2['product_files_name']?>">Link</a></td>
                  <td>
                    <a href="#" class="btn icon btn-danger"
                      data-bs-toggle="modal"
                      data-bs-target="#danger<?=$row2['id']?>"><i class="bi bi-trash"></i>
                    </a>
                        <!--Danger theme Modal -->
                        <div
                              class="modal fade text-left"
                              id="danger<?=$row2['id']?>"
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
                                    Testo modale risorse
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
                                        ><a href="core/mngXSProduct.php?idFileToDel=<?=$row2['id']?>&fileName=<?=$row2['product_files_name']?>&cat=<?=$lc_cat_name?>&prod=<?=$prod_name?>&prodId=<?=$prod_id?>" target="_blank" class="btn btn-danger ml-1">
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
            </div>
        </div>
          <div class="col-md-4 col-12">
            &nbsp;
          </div>
          <?php
          }
          ?>

</div>
    </div>
</section>