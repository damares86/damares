<?php

require "inc/funcHeader.php";

?>

<section class="section">
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card shadow">
                <div class="card-header">
                <h4 class="card-title"><?=$settings_all_title?></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngDamares.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3">
                            <label>PHP Debug</label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                    <div class="position-relative">
                                        <div class="form-check">
                                            <div class="checkbox">
                                                <?php
                                                    $setting->name="debug";
                                                    $stmt = $setting->showAllWhere('id',['name']);
                                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                    extract($row);
                                                    $checked="";
                                                    if($row['value']==1){
                                                        $checked = "checked" ;
                                                    }

                                                ?>
                                                <input type="hidden" name="debug_check" value="yes">
                                                <input type="checkbox" id="checkbox1" name="debug" class="form-check-input" <?=$checked?>>
                                                <label for="checkbox1">Enable</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br><br>
                        <div class="col-12 d-flex justify-content-start">
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