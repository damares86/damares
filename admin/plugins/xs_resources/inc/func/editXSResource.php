<?php

$resource_id = filter_input(INPUT_GET,"idToMod");
$xsresources->id = $resource_id ;
$xsresources->table = 'resources' ;

$stmt = $xsresources->showAllWhere('id',['id']);

?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$xs_res_edit_header?></h3>
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
          <?=$xs_res_edit_header?>
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
                <h4 class="card-title"><?=$xs_res_edit_header?></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngXSResources.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <?php
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                            extract($row) ;
                    ?>
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
                            <label><?=$xs_res_add_description?><span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9 my-3">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <textarea name="content" id="default" cols="30" rows="10">
                                        <?=$row['description']?>
                                        </textarea>
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
                                            $stmt1 = $xsproduct->showAll('id');
                                            while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                                            $selected = '' ;
                                            if($row['product_id'] == $row1['id'])
                                            {
                                                $selected = 'selected' ;
                                            }
                                        ?>

                                            <option value="<?=$row1['id']?>" <?=$selected?>><?=$row1['product_name']?></option>

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
                                            $stmt2 = $xsresources->showAll('id');
                                            while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                                                $selected = '' ;
                                                if($row['type_id'] == $row2['id'])
                                                {
                                                    $selected = 'selected' ;
                                                }
                                        ?>

                                            <option value="<?=$row2['id']?>" <?=$selected?>><?=$row2['resource_type']?></option>

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
                                         $stmt3 = $xsresources->showAll('id');
                                         while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
                                            $selected = '' ;
                                            if($row['lang_id'] == $row3['id'])
                                            {
                                                $selected = 'selected' ;
                                            }
                                     ?>

                                         <option value="<?=$row3['id']?>" <?=$selected?>><?=$row3['resource_lang']?></option>

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
                        <label><?=$xs_res_edit_current_file?></label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <a href="uploads/<?=$row['resource_name']?>" target="_blank"><?=$row['resource_name']?></a>
                        </div>
                    </div>

                     <div class="col-md-3 my-3">
                            <label><?=$xs_res_edit_replace_file?></label>
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
                        <?php
                        }
                        ?>
                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="oldFilename" value="<?=$row['resource_name']?>">
                        <input type="hidden" name="idToMod" value="<?=$resource_id?>">
                        <input type="hidden" name="origin" value="editXSResource">
                      
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