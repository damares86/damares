<?php

$product_id = filter_input(INPUT_GET,"idToMod");
$xsproduct->id = $product_id ;
$xsproduct->table = 'product' ;

$stmt = $xsproduct->showAllWhere('id',['id']);

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
                    <?php
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                            extract($row) ;
                    ?>
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
                                        value="<?=$row['product_name']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="idToMod" value="<?=$product_id?>">
                        <input type="hidden" name="origin" value="editXSProduct">
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

          while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC))
          {
            extract($row1) ;

            $cat_name = ucfirst($row1['cat_name'])
          
        ?>

        <div class="col-md-8 col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><?=$cat_name?></h4>
            </div>
            <div class="card-content">
              <div class="card-body">
                
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
</section>