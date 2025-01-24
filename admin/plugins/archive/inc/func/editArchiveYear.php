<?php

$idToMod = filter_input(INPUT_GET, "idToMod");
$archive->table = "archive_years";
$archive->id = $idToMod;
$stmt = $archive->showAllWhere('id', ['id']);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
extract($row);

$url_tablePage = filter_input(INPUT_GET, 'tablePage');
$url_pageName = filter_input(INPUT_GET, 'pageName');
?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class="d-inline"><?=$edityear_header?></h3>
                <a href="index.php?p=<?=$url_pageName?>&tablePage=<?=$url_tablePage?>&pageName=<?=$url_pageName?>" class="btn icon btn-info shadow mx-3 px-3">
                    <i class="bi bi-arrow-left-circle"></i> &nbsp; <?=$common_back?>
                </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php"><?= $common_dashboard ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?=$edityear_header?>
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
                            <h4 class="card-title"><?=$edityear_title?></h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                        <form class="form form-horizontal" action="core/mngArchive.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label><?=$edityear_year?> <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="<?=$edityear_title_ph?>" id="rolename" name="year" data-parsley-required="true" value="<?= $row['year'] ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 
                                    <input type="hidden" name="operation" value="editYear">
                                    <input type="hidden" name="idToMod" value="<?= $row['id'] ?>">
                                    <input type="hidden" name="origin" value="editArchiveYear">
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="card shadow">
                    <h4 class="card-title px-4 pt-3"><?= $common_info ?></h4>
                    <div class="card-content px-5 pb-4">
                        <ul>
                            <li><a href="http://dmweblab.com/portal/manual.php?prod=1&page=9" target="_blank"><?= $common_see_guide ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>