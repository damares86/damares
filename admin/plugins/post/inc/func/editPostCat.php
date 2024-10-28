<?php

$idToMod = filter_input(INPUT_GET, "idToMod");
$post->id = $idToMod ;
$post->table = 'post_categories';
$stmt1 = $post->showAllWhere('id', ['id']);
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
extract($row1);

$url_tablePage = filter_input(INPUT_GET, 'tablePage');
$url_pageName = filter_input(INPUT_GET, 'pageName');
?>

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3 class="d-inline"><?=$editcat_header?></h3>
            <a href="index.php?p=<?= $url_pageName ?>&tablePage=<?= $url_tablePage ?>&pageName=<?= $url_pageName ?>" class="btn icon btn-info shadow mx-3 px-3">
                <i class="bi bi-arrow-left-circle"></i> &nbsp; <?= $common_back ?>
            </a>
        </div>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php"><?= $common_dashboard ?></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?=$editcat_header?>
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
                    <h4 class="card-title"><?=$editcat_title?>: <?= $row1['category_name'] ?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngPostCat.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label><?=$editcat_name?> <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="Categoria" id="first-name" name="category_name" data-parsley-required="true" value="<?= $row1['category_name'] ?>" />

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $plugin->pluginname = "mini_cms";

                                    if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {
                                    ?>
                                        <div class="col-md-3 my-3">
                                            <label><?=$editcat_assign?>: <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-9 my-3">
                                            <div class="form-group">
                                                <div class="form-check mandatory">
                                                    <div class="position-relative">
                                                        <fieldset class="form-group">
                                                            <select class="form-select w-75" name="assign_page">
                                                                <?php
                                                                $selected = '';
                                                                if ($row1['assign_page'] == 'none') {
                                                                    $selected = 'selected';
                                                                }
                                                                ?>
                                                                <option value="none" <?= $selected ?>><?=$editcat_none?></option>

                                                                <?php
                                                                $mc->table = 'mc_pages';
                                                                $stmt = $mc->showAll('page_name');
                                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                    extract($row);

                                                                    $selected = '';
                                                                    if ($row1['assign_page'] == $row['id']) {
                                                                        $selected = 'selected';
                                                                    }

                                                                    $str = $row['page_name'];
                                                                    $str = str_replace('_', ' ', $str);
                                                                    $str = ucfirst($str);

                                                                ?>
                                                                    <option value="<?= $row['id'] ?>" <?= $selected ?>><?= $str ?></option>
                                                                <?php
                                                                }
                                                                ?>

                                                            </select>

                                                        </fieldset>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>


                                    <input type="hidden" name="idToMod" value="<?= $idToMod ?>">
                                    <input type="hidden" name="operation" value="edit">
                                    <input type="hidden" name="origin" value="editPostCat">
                                    <input type="hidden" name="url_tablePage" value="<?= $url_tablePage ?>">
                                    <input type="hidden" name="url_pageName" value="<?= $url_pageName ?>">

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1 shadow">
                                            <?= $common_submit ?>
                                        </button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1 shadow">
                                            <?= $common_reset ?>
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
                    <h4 class="card-title"><?= $common_info ?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>