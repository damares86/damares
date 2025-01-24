<?php

$idToMod = filter_input(INPUT_GET, 'idToMod');
$archive->table = 'archive_files';
$archive->id = $idToMod;
$archive_file = $archive->showAllWhere('id', ['id']);
$row_file = $archive_file->fetch(PDO::FETCH_ASSOC);
extract($row_file);


$url_tablePage = filter_input(INPUT_GET, 'tablePage');
$url_pageName = filter_input(INPUT_GET, 'pageName');

$filename = '' ;

?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?=$editarchive_header?></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php"><?= $common_dashboard ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?=$editarchive_header?>
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
                        <h4 class="card-title"><?=$editarchive_title?></h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal upload-form" action="core/mngArchive.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label><?=$editarchive_title_file?> <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <div class="form-check mandatory">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="<?=$editarchive_title_file?>" id="first-name-icon" name="title" data-parsley-required="true" value="<?= $row_file['title'] ?>" />

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label><?=$editarchive_year?> <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <div class="form-check mandatory">
                                                    <div class="position-relative">
                                                        <fieldset class="form-group">
                                                            <select class="form-select" id="year" name="year_id">
                                                                <?php
                                                                $selected = '';
                                                                $archive->table = "archive_years";
                                                                $stmt = $archive->showAll('year', null, null, "DESC");
                                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                                                    $selected = '' ;
                                                                    if ($row['id'] == $row_file['archive_year_id']) {
                                                                        $selected = 'selected';
                                                                    }
                                                                ?>
                                                                    <option value="<?= $row['id'] ?>" <?= $selected ?>><?= $row['year'] ?></option>

                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12 my-3">
                                            <?php
                                            $filename = $row_file['file_name'] ;
                                            ?>
                                            <?=$editarchive_current_file?>: <b><a href="../uploads/archive/<?= $row_file['file_name'] ?>" target="_blank"><?= $row_file['file_name'] ?></a></b>
                                        </div>
                                        <div class=" col-md-3">
                                            <label><?=$editarchive_replace_file?></label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <div class="position-relative">
                                                        <input class="form-control" type="file" id="formFile" name="myfile" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">&nbsp;</div>
                                        <div class="col-md-9">
                                            <div class="progress"></div>
                                            <div class="result"></div>
                                        </div>

                                        <input type="hidden" name="filename_orig" value="<?= $filename ?>">
                                        <input type="hidden" id="operation" name="operation" value="edit">
                                        <input type="hidden" name="origin" value="editArchive">
                                        <input type="hidden" name="idToMod" value="<?= $idToMod ?>">
                                        <input type="hidden" name="url_tablePage" value="<?= $url_tablePage ?>">
                                        <input type="hidden" name="url_pageName" value="<?= $url_pageName ?>">

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1 shadow">
                                                <?= $common_update ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <script src="script/uploadFileArchive.js"></script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="card shadow">
                    <h4 class="card-title px-4 pt-3"><?= $common_info ?></h4>
                    <div class="card-content px-5 pb-4">
                        <ul>
                            <li><a href="http://dmweblab.com/portal/manual.php?prod=1&page=12" target="_blank"><?= $common_see_guide ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>