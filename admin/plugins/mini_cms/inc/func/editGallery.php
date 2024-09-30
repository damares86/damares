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
                            <h4 class="card-title">Gallery: <b><?=$row1['gallery_name']?></b></h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-horizontal" action="core/mngQuote.php" method="POST" data-parsley-validate>
                                    <div class="form-body">
                                        <div class="row">
                                            
                                        <input type="hidden" name="operation" value="edit">
                                        <input type="hidden" name="idToMod" value="<?= $id ?>">
                                        <input type="hidden" name="origin" value="editGallery">

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
                                <li><a href="http://dmweblab.com/portal/manual.php?prod=1&page=6" target="_blank"><?= $common_see_guide ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

