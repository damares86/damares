
<div class="page-heading">
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$file_edit_header?></h3>
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
            <?=$file_edit_header?>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>
<?php
    $idToMod = filter_input(INPUT_GET,'idToMod');
    $file->id = $idToMod ;
    $stmt1 = $file->showAllWhere('id',['id']) ;

    $id="";
    $filename="";
    $label="";

        while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){

            $id=$row1['id'];
            $filename=$row1['filename'];
            $label=$row1['label'];

?>
<section class="section">
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                <h4 class="card-title">Modifica file da votare<?=$file_edit_title?></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal upload-form" action="core/mngRate.php" method="POST" enctype="multipart/form-data"  data-parsley-validate>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3">
                            <label><?=$file_all_label?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group has-icon-left">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="File name"
                                        id="first-name-icon"
                                        name="label"
                                        data-parsley-required="true"
                                        value="<?=$label?>"

                                        />
                                        <div class="form-control-icon">
                                        <i class="bi bi-key"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ADD CHECK ON CATEGORY -->

                        <div class="col-md-3">
                            <label>Category <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                    <fieldset class="form-group">
                                        <select
                                        class="form-select"
                                        id="category"
                                        name="category"
                                        >
                                        <?php
                                            $stmt = $rate->showAllTable('id','rate_cat');
                                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        ?>

                                            <option value="<?=$row['id']?>"><?=$row['cat_name']?></option>

                                        <?php
                                            }
                                        ?>
                                        </select>
                                    </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-9 bg-primary text-white p-2 my-2">
                            <?=$file_edit_actual?> <b><?=$filename?> </b>
                        </div>
                        <div class="col-md-3">
                            <label><?=$file_edit_file?></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                    <div class="position-relative">
                                        <input
                                        class="form-control"
                                        type="file"
                                        id="formFile"
                                        name="myfile"
                                    />
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-9">
                            <div class="progress"></div>
                            <div class="result"></div>
                        </div>

                        <input type="hidden" name="filename_orig" value="<?=$filename?>">
                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="idToMod" value="<?=$id?>">
                        <input type="hidden" name="origin" value="editFile">
                      
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
                    <?php
        }
        ?>
                    </form>
                    <!-- <script src="script/uploadFile.js"></script> -->
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