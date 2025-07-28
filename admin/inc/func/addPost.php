<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3><?= $addpost_header ?></h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav
                aria-label="breadcrumb"
                class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php"><?= $common_dashboard ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= $addpost_header ?>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<br>

<section class="section">
    <div class="row">
        <div class="col-md-10 col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="card-title"><?= $addpost_title ?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngPost.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label><?= $addpost_post_title ?><span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="Titolo del post"
                                                        id="first-name"
                                                        name="title"
                                                        data-parsley-required="true" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-3">
                                        <label><?= $addpost_cat ?> <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9 mt-3">
                                        <div class="form-group">
                                            <select
                                                class="choices form-select multiple-remove"
                                                multiple="multiple" name="categories[]">
                                                <?php
                                                $post->table = 'post_categories';
                                                $stmt = $post->showAll('id');
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    extract($row);
                                                    $selected = "";

                                                    // if(in_array($row['id'],$sections)){
                                                    //     $selected = "selected";
                                                    // }
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
                                        <label><?= $addpost_img ?> </label>
                                    </div>
                                    <div class="col-md-9 mt-3">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input
                                                        class="form-control"
                                                        type="file"
                                                        id="formFile"
                                                        name="myfile" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-3">
                                        <label>File Manager </label>
                                    </div>
                                    <div class="col-md-9 mt-3">
                                        <button type="button" class="btn btn-primary me-1 mb-1 shadow" data-bs-toggle="modal" data-bs-target="#fm_modal">
                                            Apri
                                        </button>
                                    </div>

                                    <style>
                                        .modal-dialog {
                                            width: 79%;
                                            max-width: 80%;
                                            height: 70%;
                                        }
                                    </style>
                                    <div class="modal fade" id="fm_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                                        <div class="modal-dialog" role="document" style="height: 100%;">
                                            <div class="modal-content h-75">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <iframe src='core/tinyfilemanager.php' style="width: 100%; height:100%;">
                                                    </iframe>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 my-3">
                                        <label><?= $addpost_content ?> <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9 my-3">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <textarea name="content" class="tiny" cols="30" rows="15"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <?php
                                    $plugin->pluginname = "mini_cms";

                                    if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {
                                    ?>
                                        <div class="col-md-3 my-3">
                                            <label><?= $addpost_gallery ?> </label>
                                        </div>
                                        <div class="col-md-9 my-3">
                                            <div class="form-group">
                                                <div class="form-check mandatory">
                                                    <div class="position-relative">
                                                        <fieldset class="form-group">
                                                            <select class="form-select" name="gall">
                                                                <option value="none"><?= $addpost_gallery_none ?></option>
                                                                <?php
                                                                $mc->table = 'mc_galleries';
                                                                $galleries = $mc->showAll('id');
                                                                $galleryOptions = '';
                                                                while ($row = $galleries->fetch(PDO::FETCH_ASSOC)) {
                                                                ?>

                                                                    <option value="<?= $row['id'] ?>"><?= $row['gallery_name'] ?></option>

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


                                    <input type="hidden" name="author" value="<?= $_SESSION['account_id'] ?>">
                                    <input type="hidden" name="operation" value="add">
                                    <input type="hidden" name="origin" value="addPost">

                                    <div class="col-12 d-flex justify-content-end">
                                        <button
                                            type="submit"
                                            class="btn btn-primary me-1 mb-1 shadow">
                                            <?= $common_submit ?>
                                        </button>
                                        <button
                                            type="reset"
                                            class="btn btn-light-secondary me-1 mb-1 shadow">
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
        <div class="col-md-2 col-12">
            <div class="card shadow">
                <h4 class="card-title px-4 pt-3"><?= $common_info ?></h4>
                <div class="card-content px-5 pb-4">
                    <ul>
                        <li><a href="https://www.dmweblab.com/portal/manual.php?prod=3&page=3" target="_blank"><?= $common_see_guide ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>