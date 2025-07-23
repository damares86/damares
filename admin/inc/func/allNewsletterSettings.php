<?php
$newsletter->table = 'newsletter_settings';
$stmt = $newsletter->showAll('id');

$newsletter_settings = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    extract($row);
    $newsletter_settings[$row['name']] = $row['value'];
}

?>

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Newsletter settings</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php"><?= $common_dashboard ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Newsletter settings
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
                    <h4 class="card-title">General settings</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngNewsletterSettings.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">

                                    <div class="col-md-6">
                                        <label>Confirmation required for registration? <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <?php
                                                        $checked = $newsletter_settings['confirmation'] == 1 ? ' checked' : '' ;
                                                    ?>
                                                    <input type="checkbox" class="form-check-input" name="confirmation"<?=$checked?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="operation" value="settings">
                                    <input type="hidden" name="origin" value="allNewletterSettings">

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