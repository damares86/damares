<?php

$mc->id = filter_input(INPUT_GET, "idToMod");
$mc->table = 'mc_galleries';
$stmt1 = $mc->showAllWhere('id', ['id']);
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
extract($row1);
?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class="d-inline">Edit Gallery</h3>
                <a href="index.php?p=allGalleries" class="btn icon btn-info shadow mx-3 px-3">
                    <i class="bi bi-arrow-left-circle"></i> &nbsp; <?= $common_back ?>
                </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php"><?= $common_dashboard ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">

                            Edit Gallery
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
                        <h4 class="card-title">Gallery: <b><?= $row1['gallery_name'] ?></b></h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="core/mngGallery.php" method="POST" data-parsley-validate>
                                <div class="form-body">
                                    <div class="row">
                                        <?php
                                        $images = glob("../uploads/gallery/g_" . $row1['id'] . "/*");
                                        if (count($images) > 0) {
                                            $idx = 0 ;
                                            foreach ($images as $img) {

                                                $img_split = explode('/',$img);

                                        ?>
                                                <div class="col-4 col-lg-3 col-md-4">
                                                    <div class="card border">
                                                        <div class="card-body px-4 py-4-5">

                                                            <div class="row">

                                                                <div class="col-12">

                                                                    <img src="<?= $img ?>" class="w-100">
                                                                </div>
                                                                <div class="col-12 mt-3">
                                                                    <div class="stats-icon bg-danger mb-2">
                                                                        <a href="#" class="btn icon btn-danger shadow" data-bs-toggle="modal" data-bs-target="#danger<?= $idx ?>"><i class="bi bi-trash"></i>
                                                                        </a>
                                                                        <!--Danger theme Modal -->
                                                                        <div class="modal fade text-left" id="danger<?= $idx ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header bg-danger">
                                                                                        <h5 class="modal-title white" id="myModalLabel120">
                                                                                            <?= $common_modal_title_sure ?>
                                                                                        </h5>
                                                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                                            <i data-feather="x"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <?= $account_all_modal_body ?>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                                                            <i class="bx bx-x d-block d-sm-none"></i>
                                                                                            <span class="d-none d-sm-block"><?= $common_modal_cancel ?></span>
                                                                                        </button>
                                                                                        <span class="d-none d-sm-block"><a href="core/mngAccounts.php?imgToDel=<?= $img_split[4] ?>" class="btn btn-danger ml-1">
                                                                                                <?= $common_modal_confirm ?>
                                                                                            </a></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                        <?php
                                        $idx++;
                                            }
                                        } else {
                                            echo "No images in this gallery";
                                        }


                                        ?>
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
                            <li><a href="http://dmweblab.com/portal/manual.php?prod=1&page=6" target="_blank"><?= $common_see_guide ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>