<?php

$cat_id = filter_input(INPUT_GET,"idToMod");
$xsproduct->id = $cat_id;
$xsproduct->table = 'product_files_cat' ;
$stmt1 = $xsproduct->showAllWhere('id',['id']);

?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$xs_prod_edit_header?></h3>
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
          <?=$xs_prod_edit_header?>
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
            <div class="card shadow">
                <div class="card-header">
                <h4 class="card-title"><?=$xs_prod_edit_header?></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngXSProduct.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                        <?php
                            while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC))
                            {
                                extract($row1);
                        ?>
                        <div class="row">
                        <div class="col-md-3">
                            <label><?=$common_name?><span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group has-icon-left">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Nome"
                                        id="first-name"
                                        name="name"
                                        data-parsley-required="true"
                                        value="<?=$row1['cat_name']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>



                        
                        <input type="hidden" name="idToMod" value="<?=$row1['id']?>">
                        <input type="hidden" name="oldCatName" value="<?=$row1['cat_name']?>">
                        <input type="hidden" name="operation" value="editCat">
                        <input type="hidden" name="origin" value="editXSProductCat">
                      
                        <?php

                        }

                        ?>
                        <div class="col-12 d-flex justify-content-end">
                            <button
                            type="submit"
                            class="btn btn-primary me-1 mb-1 shadow"
                            >
                            <?=$common_submit?>
                            </button>
                            <button
                            type="reset"
                            class="btn btn-light-secondary me-1 mb-1 shadow"
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
    </div>
</section>