<?php

$resource_id = filter_input(INPUT_GET,"idToMod");
$gamresources->id = $resource_id ;
$gamresources->table = 'resources' ;

$stmt = $gamresources->showAllWhere('id',['id']);

?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$gam_res_edit_header?></h3>
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
          <?=$gam_res_edit_header?>
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
                <h4 class="card-title"><?=$gam_res_edit_title?></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngGamResources.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <?php
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                            extract($row) ;
                    ?>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3">
                            <label><?=$gam_res_edit_title_res?> <span class="text-danger">*</span></label>
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
                                        name="title"
                                        data-parsley-required="true"
                                        value="<?=$row['title']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 my-3">
                            <label><?=$gam_res_edit_description?></label>
                        </div>
                        <div class="col-md-9 my-3">
                            <div class="form-group">
                                <div class="form-check">
                                    <div class="position-relative">
                                        <textarea name="content" id="default" cols="30" rows="10">
                                        <?=$row['description']?>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                                           
                        <div class="col-md-3 mb-3">
                            <label><?=$gam_res_edit_type?> <span class="text-danger">*</span></label>
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
                                            $gamresources->table = 'resource_type';
                                            $stmt2 = $gamresources->showAll('id');
                                            while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                                                $selected_type = 0 ;
                                                if($row['type_id'] == $row2['id'])
                                                {
                                                    $selected_type = 'selected' ;
                                                }
                                        ?>

                                            <option value="<?=$row2['id']?>" <?=$selected_type?>><?=$row2['type']?></option>

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
                            <label><?=$gam_res_edit_cat?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9 mb-3">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                    <fieldset class="form-group">
                                        <select
                                        class="form-select"
                                        name="cat_id"
                                        >
                                        <?php
                                            $gamresources->table = 'resource_cat';
                                            $stmt3 = $gamresources->showAll('id');
                                            while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
                                                $selected_cat = 0 ;
                                                if($row['cat_id'] == $row3['id'])
                                                {
                                                    $selected_cat = 'selected' ;
                                                }
                                        ?>

                                            <option value="<?=$row3['id']?>" <?=$selected_cat?>><?=$row3['cat']?></option>

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
                        <label><?=$gam_res_edit_current?></label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <a href="uploads/<?=$row['resource_name']?>" target="_blank"><?=$row['resource_name']?></a>
                        </div>
                    </div>

                     <div class="col-md-3 my-3">
                            <label><?=$gam_res_edit_new_file ?></label>
                        </div>
                        <div class="col-md-9 my-3">
                            <div class="form-group">
                                <div class="form-check">
                                    <div class="position-relative">
                                        <input
                                        class="form-control"
                                        type="file"
                                        id="formFile1"
                                        name="myfile"
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
                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="oldFilename" value="<?=$row['resource_name']?>">
                        <input type="hidden" name="idToMod" value="<?=$resource_id?>">
                        <input type="hidden" name="origin" value="editGamResource">
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