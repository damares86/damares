<?php

$rate->id = filter_input(INPUT_GET,"idToMod");
$stmt1 = $rate->showAllWhereTable('id','rate_cat',['id']);
?>
<div class="page-heading">
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$role_edit_header?></h3>
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
          Modifica categoria
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
                    <?php

                    
                    $cat_name="";
                    $redirect="";
                    while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                        $cat_id=$row1['id'];
                        $cat_name=$row1['cat_name'];
                        
                    ?>
                <h4 class="card-title">Modifica la categoria <b><?=$cat_name?></b></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngRate.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3">
                            <label>Category name <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group has-icon-left">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Category name"
                                        id="cat_ename"
                                        name="cat_name"
                                        data-parsley-required="true"
                                        value="<?=$cat_name?>"

                                        />
                                        <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                            
                        <input type="hidden" name="operation" value="editCat">
                        <input type="hidden" name="idToMod" value="<?=$cat_id?>">
                        <input type="hidden" name="origin" value="editCatRate">
                      <?php
                    }
                    ?>
                        <div class="col-12 d-flex justify-content-end">
                            <button
                            type="submit"
                            class="btn btn-primary me-1 mb-1"
                            >
                            <?=$common_submit?>
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
