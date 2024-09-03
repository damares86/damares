<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Add a new page</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php"><?= $common_dashboard ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Add a new page
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
                    <h4 class="card-title">New page</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngPage.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Page name <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="" name="page_name" data-parsley-required="true" />

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-3">
                                        <label>Layout <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9 mt-3">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <?php
                                                $layout_counter = 0;
                                                foreach (glob("../assets/css/template/img/*") as $file) {
                                                    if (is_file($file)) {
                                                        $style = pathinfo($file, PATHINFO_FILENAME);

                                                        $checked = '';
                                                        if ($layout_counter == 0) {
                                                            $checked = 'checked';
                                                        }
                                                ?>

                                                        <input type="radio" class="btn-check" name="layout" value="<?= $style ?>" autocomplete="off" id="layout_<?= $style ?>" <?= $checked ?>>
                                                        <label class="btn btn-outline-success" for="layout_<?= $style ?>"><img src='../assets/css/template/img/<?= $style ?>.png'></label>
                                                        <!-- <label class="btn btn-outline-success"></label> -->
                                                        <!-- 
                                                    <div class="form-check d-inline">
                                                        <input class="form-check-input" type="radio" name="layout" value="<?= $style ?>">
                                                        <img src='../assets/css/template/<?= $style ?>.png'>
                                                    </div> -->
                                                        &nbsp;
                                                <?php
                                                    }
                                                    $layout_counter++;
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-3">
                                        <label>Use header <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9 mt-3">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <input type="checkbox" id="checkbox1" class="form-check-input">
                                                    <label for="checkbox1">&nbsp; Select to show the header</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-3">
                                        <label>Header style <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9 mt-3">
                                        <div class="row">
                                            <div class="col border p-3">
                                                <div class="form-check">
                                                    <input class="form-check-input nomargin" type="radio" name="header" checked>
                                                    <label class="form-check-label">&nbsp; Image</label>
                                                    <br>
                                                    <br>
                                                    <span>Default image: <img src="../uploads/visual.jpg" class="d-inline w-25"></span>
                                                    <br>
                                                    <br>

                                                    <label>Upload a new image <span class="text-danger">*</span></label>

                                                    <div class="form-group">
                                                        <div class="form-check mandatory">
                                                            <div class="position-relative">
                                                                <input class="form-control" type="file" id="formFile" name="myfile" data-parsley-required="true" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col border p-3">
                                                <div class="form-check">
                                                    <input class="form-check-input nomargin" type="radio" name="header">
                                                    <label class="form-check-label">&nbsp; Gallery</label>
                                                    <br><br>
                                                    <label>Choose a gallery <span class="text-danger">*</span></label>

                                                    <div class="form-group">
                                                        <div class="form-check mandatory">
                                                            <div class="position-relative">
                                                                <fieldset class="form-group">
                                                                    <select class="form-select" id="role" name="role">
                                                                        <?php
                                                                        $mc->table = 'mc_galleries';
                                                                        $stmt = $mc->showAll('id');
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
                                            </div>
                                        </div>

                                    </div>










                                    <input type="hidden" name="operation" value="add">
                                    <input type="hidden" name="origin" value="addPage">

                                    <div class="col-12 mt-3 d-flex justify-content-end">
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
        <div class="col-md-2 col-12">
            <div class="card shadow">
                <h4 class="card-title px-4 pt-3"><?= $common_info ?></h4>
                <div class="card-content px-5 pb-4">
                    <ul>
                        <li><a href="http://dmweblab.com/portal/manual.php?prod=1&page=5" target="_blank"><?= $common_see_guide ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>