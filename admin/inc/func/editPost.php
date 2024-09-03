<?php

$post_id = filter_input(INPUT_GET, 'idToMod');
$post->id = $post_id;
$post->table = 'post';

$stmt1 = $post->showAllWhere('id', ['id']);
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
extract($row1);

$url_tablePage = filter_input(INPUT_GET, 'tablePage');
$url_pageName = filter_input(INPUT_GET, 'pageName');
?>


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3 class="d-inline">Modifica post</h3>
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
                    Modifica post
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
                    <h4 class="card-title">Modifica il post: <?= $row1['title'] ?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngPost.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Titolo<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="Titolo del post" id="first-name" name="title" data-parsley-required="true" value="<?= $row1['title'] ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-3">
                                        <label>Categorie <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9 mt-3">
                                        <div class="form-group">
                                            <select class="choices form-select multiple-remove" multiple="multiple" name="categories[]">
                                                <?php
                                                $categories = explode(',', $row1['category_id']);

                                                $post->table = 'post_categories';
                                                $stmt = $post->showAll('id');
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    extract($row);
                                                    $selected = "";

                                                    if (in_array($row['id'], $categories)) {
                                                        $selected = "selected";
                                                    }
                                                ?>

                                                    <option value="<?= $row['id'] ?>" <?= $selected ?>><?= $row['category_name'] ?></option>

                                                <?php
                                                    $selected = "";
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-3">
                                        <label>Immagine principale </label>
                                    </div>
                                    <div class="col-md-9 mt-3">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <div class="position-relative">
                                                    <img src="../uploads/<?= $row1['main_img'] ?>" class="w-25 mb-3">
                                                    <br> <span class="mb-3">Carica una nuova immagine</span>
                                                    <input class="form-control" type="file" id="formFile" name="myfile" placeholder="Carica nuovo file" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-9">
                            <div class="progress"></div>
                            <div class="result"></div>
                        </div> -->



                                    <div class="col-md-3 my-3">
                                        <label>Contenuto<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9 my-3">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <textarea name="content" id="default" cols="30" rows="15"><?= $row1['content'] ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <input type="hidden" name="author" value="<?= $_SESSION['username'] ?>">
                                    <input type="hidden" name="old_main_img" value="<?= $row1['main_img'] ?>">
                                    <input type="hidden" name="idToMod" value="<?= $post_id ?>">
                                    <input type="hidden" name="operation" value="edit">
                                    <input type="hidden" name="origin" value="editPost">
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