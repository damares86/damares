<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$xs_res_add_header?></h3>
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
          <?=$xs_res_add_header?>
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
                <h4 class="card-title"><?=$xs_res_add_title?></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngXSResources.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3">
                            <label><?=$xs_res_add_title_res?><span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$xs_res_add_title_res?>"
                                        id="first-name"
                                        name="title"
                                        data-parsley-required="true"

                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 my-3">
                            <label><?=$xs_res_add_description?><span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9 my-3">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <textarea name="content" id="default" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label><?=$xs_res_add_product?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9 mb-3">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                    <fieldset class="form-group">
                                        <select
                                        class="form-select"
                                        name="product_id"
                                        >
                                        <?php
                                            $xsproduct->table = 'product';
                                            $stmt = $xsproduct->showAll('id');
                                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        ?>

                                            <option value="<?=$row['id']?>"><?=$row['product_name']?></option>

                                        <?php
                                        }
                                        ?>
                                        </select>
                                    </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                     
                        <div class="col-md-3 mb-3">
                            <label><?=$xs_res_add_type?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9 mb-3">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                    <fieldset class="form-group">
                                        <select
                                        class="form-select"
                                        name="type_id"
                                        >
                                        <?php
                                            $xsresources->table = 'resource_type';
                                            $stmt = $xsresources->showAll('id');
                                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        ?>

                                            <option value="<?=$row['id']?>"><?=$row['resource_type']?></option>

                                        <?php
                                        }
                                        ?>
                                        </select>
                                    </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                     
                     <div class="col-md-3 mb-3">
                         <label><?=$xs_res_add_lang?><span class="text-danger">*</span></label>
                     </div>
                     <div class="col-md-9 mb-3">
                         <div class="form-group">
                             <div class="form-check mandatory">
                                 <div class="position-relative">
                                 <fieldset class="form-group">
                                     <select
                                     class="form-select"
                                     name="lang_id"
                                     >
                                     <?php
                                         $xsresources->table = 'resource_lang';
                                         $stmt = $xsresources->showAll('id');
                                         while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                     ?>

                                         <option value="<?=$row['id']?>"><?=$row['resource_lang']?></option>

                                     <?php
                                     }
                                     ?>
                                     </select>
                                 </fieldset>
                                 </div>
                             </div>
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
                        <!-- <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-9">
                            <div class="progress"></div>
                            <div class="result"></div>
                        </div> -->

                        <input type="hidden" name="operation" value="add">
                        <input type="hidden" name="origin" value="addXSResource">
                      
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
            <div class="card shadow">
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