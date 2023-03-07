<?php

require "inc/funcHeader.php";

?>

<section class="section">
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                <h4 class="card-title">All settings</h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngSettings.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3">
                            <label>Locale </label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                    <div class="position-relative">
                                    <fieldset class="form-group">
                                        <select
                                        class="form-select"
                                        id="lang"
                                        name="lang"
                                        >
                                        <?php

                                            $scan = scandir('locale/');
                                            $exclude = array('..', '.','.gitkeep');
                                            $selected ="";
                                            foreach ($scan as $folder) {
                                              if(!in_array($folder, $exclude )){
                                                
                                                if($folder==$lang){
                                                    $selected="selected" ;
                                                }                                              

                                        ?>

                                            <option value="<?=$folder?>" <?=$selected?>><?=$folder?></option>

                                        <?php
                                            $selected="";
                                            }
                                        }
                                        ?>
                                        </select>
                                    </fieldset>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $setting->name="noreply";
                            $stmt=$setting->showAllWhere('id',['name']);
                            $row=$stmt->fetch(PDO::FETCH_ASSOC);
                            $reset = $row['value'];
                            ?>
                        <div class="col-md-3">
                            <label>Password reset email <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group has-icon-left">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="email"
                                        class="form-control"
                                        placeholder="Email"
                                        id="first-name-icon"
                                        name="email"
                                        data-parsley-required="true"
                                        value="<?=$reset?>"
                                        />
                                        <div class="form-control-icon">
                                        <i class="bi bi-envelope"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="operation" value="lang">
                        <input type="hidden" name="setting_name" value="locale">
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
    </div>
</section>