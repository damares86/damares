<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3><?=$addemail_header?></h3>
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
                        <?=$addemail_header?>
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
                    <h4 class="card-title"><?=$addemail_title?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngNewsletter.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label><?=$addemail_subject?><span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="Email subject"
                                                        id="first-name"
                                                        name="subject"
                                                        data-parsley-required="true" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3 mt-3">
                                        <label><?=$file_fm?> </label>
                                    </div>
                                    <div class="col-md-9 mt-3">
                                        <button type="button" class="btn btn-primary me-1 mb-1 shadow" data-bs-toggle="modal" data-bs-target="#fm_modal">
                                            <?=$file_fm_open?>
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
                                                <div class="modal-body">
                                                    <iframe src='core/tinyfilemanager.php' style="width: 100%; height:100%;">
                                                    </iframe>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$common_close?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 my-3">
                                        <label><?=$addemail_body?> <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9 my-3">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <textarea name="body" class="tiny" cols="30" rows="15" data-parsley-required="true"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="operation" value="add">
                                    <input type="hidden" name="origin" value="addEmail">

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
                        <li><a href="https://www.dmweblab.com/portal/manual.php?prod=4&page=6" target="_blank"><?= $common_see_guide ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>