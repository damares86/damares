<?php
// $summernote = true;
?>

<style>
    .row.page {
        display: none
    }
</style>

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
                                                    <input type="text" class="form-control" placeholder="Type the page name" name="page_name" data-parsley-required="true" />

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
                                                foreach (glob("../assets/template/img/*") as $file) {
                                                    if (is_file($file)) {
                                                        $style = pathinfo($file, PATHINFO_FILENAME);

                                                        $checked = '';
                                                        if ($layout_counter == 0) {
                                                            $checked = 'checked';
                                                        }
                                                ?>

                                                        <input type="radio" class="btn-check" name="layout" value="<?= $style ?>" autocomplete="off" id="layout_<?= $style ?>" <?= $checked ?>>
                                                        <label class="btn btn-outline-primary" for="layout_<?= $style ?>"><img src='../assets/template/img/<?= $style ?>.png'></label>
                                                        &nbsp;
                                                <?php
                                                    }
                                                    $layout_counter++;
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-3 pt-3">
                                        <label>Use header <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9 mt-3 pt-3">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <input type="checkbox" id="checkbox1" class="form-check-input" name="use_header">
                                                    <label for="checkbox1">&nbsp; Select to show the header on this page</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row highlight-section">
                                        <div class="col-md-3 mt-3 p-3 border-top">
                                            <label>Header style <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-9 mt-3 border-top">
                                            <div class="row mt-3">
                                                <div class="col border p-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input nomargin" type="radio" name="header" value="image" checked>
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
                                                                    <input class="form-control" type="file" name="img_header" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col border p-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input nomargin" type="radio" name="header" value="gallery">
                                                        <label class="form-check-label">&nbsp; Gallery</label>
                                                        <br><br>
                                                        <label>Choose a gallery <span class="text-danger">*</span></label>

                                                        <div class="form-group">
                                                            <div class="form-check mandatory">
                                                                <div class="position-relative">
                                                                    <fieldset class="form-group">
                                                                        <select class="form-select" name="header_gallery">
                                                                            <?php
                                                                            $mc->table = 'mc_galleries';
                                                                            $galleries = $mc->showAll('id');
                                                                            $galleryOptions = '';
                                                                            while ($row = $galleries->fetch(PDO::FETCH_ASSOC)) {
                                                                                $galleryOptions .= '<option value="' . $row['id'] . '">' . $row['gallery_name'] . '</option>';
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

                                        <div class="col-md-3 mt-3 mb-3">
                                            <label>Show site name </label>
                                        </div>
                                        <?php
                                        $mc->table = 'mc_settings' ;
                                        $mc->name = 'mc_site_name';
                                        $sitename = $mc->showAllWhere('id', ['name']);
                                        $name = $sitename->fetch(PDO::FETCH_ASSOC);

                                        ?>
                                        <div class="col-md-9 mt-3 mb-3">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <div class="checkbox">
                                                        <input type="checkbox" class="form-check-input" name="site_name">
                                                        <label>&nbsp; <b><?= $name['value'] ?></b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mt-3 mb-3 pb-3 border-bottom">
                                            <label>Show site description </label>
                                        </div>
                                        <?php
                                        $mc->table = 'mc_settings' ;
                                        $mc->name = 'mc_site_description';
                                        $sitename = $mc->showAllWhere('id', ['name']);
                                        $name = $sitename->fetch(PDO::FETCH_ASSOC);

                                        ?>
                                        <div class="col-md-9 mt-3 mb-3 pb-3 border-bottom">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <div class="checkbox">
                                                        <input type="checkbox" class="form-check-input" name="site_description">
                                                        <label>&nbsp; <b><?= $name['value'] ?></b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="dynamic_field">
                                        <div class="row" id="block_1">
                                            <div class="col-md-3 mt-3 p-3">
                                                <label><b>Block <span>1</span></b></label>
                                            </div>
                                            <div class="col-md-5 mt-3  p-3">
                                                <div class="form-group">
                                                    <div class="form-check mandatory">
                                                        <div class="position-relative">
                                                            <fieldset class="form-group">
                                                                <select class="form-select" id="block_1_type" name="block_1_type">
                                                                    <option value="text_1">Text</option>
                                                                    <option value="img_1">Image</option>
                                                                    <option value="info_1">Box info</option>
                                                                    <option value="gallery_1">Gallery</option>
                                                                    <option value="quote_1">Quotes</option>
                                                                    <?php
                                                                    $plugin->pluginname = "post";
                                                                    $postOption = '';
                                                                    if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {
                                                                        $postOption = '<option value="post_1">Latest post</option>';
                                                                    ?>
                                                                        <option value="post_1">Latest post</option>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                                </select>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-3 p-3">
                                                &nbsp;
                                            </div>

                                            <div class="col-12 mt-3 mb-3 px-5 pb-3 border-bottom">

                                                <div class="row page text_1">
                                                    <textarea class="tiny" name="text_content_1"></textarea>
                                                    <!-- <textarea class="summernote" name="text_1"></textarea> -->
                                                </div>
                                                <div class="row page img_1">
                                                    <label>Upload an image <span class="text-danger">*</span></label>
                                                    <div class="form-group">
                                                        <div class="form-check mandatory">
                                                            <div class="position-relative">
                                                                <input class="form-control" type="file" name="img_1" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row page info_1">
                                                    <label>Upload an image <span class="text-danger">*</span></label>
                                                    <div class="form-group">
                                                        <div class="form-check mandatory">
                                                            <div class="position-relative">
                                                                <input class="form-control" type="file" name="info_img_1" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <textarea class="summernote" class="mt-5" name="info_content_1"></textarea> -->
                                                    <textarea class="tiny mt-5" name="info_content_1"></textarea>
                                                </div>
                                                <div class="row page gallery_1">
                                                    <div class="col-7">
                                                        <label class="mb-3">Choose a gallery <span class="text-danger">*</span></label>
                                                        <div class="form-group">
                                                            <div class="form-check mandatory">
                                                                <div class="position-relative">
                                                                    <fieldset class="form-group">
                                                                        <select class="form-select" name="gallery_1">
                                                                            <?php
                                                                            $mc->table = 'mc_galleries';
                                                                            $galleries = $mc->showAll('id');
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
                                                    <div class="col-5">&nbsp;</div>
                                                </div>
                                                <div class="row page quote_1">
                                                    <p>Show a slideshow with quotes</p>
                                                    <input type="hidden" name="quote_1" value="q">
                                                </div>
                                                <div class="row page post_1">
                                                    <p>Show the latest post of the blog</p>
                                                    <input type="hidden" name="post_1" value="p">
                                                </div>

                                            </div>

                                            <div class="row colors mb-5">

                                                <!-- Sezione Background color -->
                                                <div class="col-md-3 mt-3 px-3">
                                                    <label>Background color</label>
                                                </div>
                                                <div class="col-md-9 mt-3 px-3">
                                                    <div class="form-group">
                                                        <div class="form-check mandatory">
                                                            <div class="position-relative">
                                                                <div class="form-group">
                                                                    <!-- Opzione 'none' per il Background color -->
                                                                    <input type="radio" class="btn-check" name="bg_color_1" value="none" autocomplete="off" id="bg_none_1" hidden checked>
                                                                    <label class="color-label bg" for="bg_none_1" style="background-color: #e5e5e5;">
                                                                        None
                                                                        <span class="checkmark"></span>
                                                                    </label>

                                                                    <!-- Loop per i colori del Background -->
                                                                    <?php
                                                                    $mc->table = 'mc_color';
                                                                    $colors = $mc->showAll('id');
                                                                    $colorArray = [] ;

                                                                    while ($row = $colors->fetch(PDO::FETCH_ASSOC)) {
                                                                        $colorArray[] = ['color' => $row['color']];
                                                                    ?>
                                                                        <input type="radio" class="btn-check" name="bg_color_1" value="<?= $row['color'] ?>" autocomplete="off" id="bg_<?= $row['color'] ?>" hidden>
                                                                        <label class="color-label" for="bg_<?= $row['color'] ?>" style="background-color: <?= $row['color'] ?>;">
                                                                            <span class="checkmark">✔</span>
                                                                            &nbsp;
                                                                        </label>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Sezione Text color -->
                                                <div class="col-md-3 mt-3 px-3">
                                                    <label>Text color</label>
                                                </div>
                                                <div class="col-md-9 mt-3 px-3">
                                                    <div class="form-group">
                                                        <div class="form-check mandatory">
                                                            <div class="position-relative">
                                                                <div class="form-group">
                                                                    <!-- Opzione 'none' per il Text color -->
                                                                    <input type="radio" class="btn-check" name="text_color_1" value="none" autocomplete="off" id="text_none_1" hidden checked>
                                                                    <label class="color-label text" for="text_none_1" style="background-color: #e5e5e5;">
                                                                        None
                                                                        <span class="checkmark"></span>
                                                                    </label>

                                                                    <!-- Loop per i colori del Text -->
                                                                    <?php
                                                                    $mc->table = 'mc_color';
                                                                    $colors = $mc->showAll('id');

                                                                    while ($row = $colors->fetch(PDO::FETCH_ASSOC)) {
                                                                    ?>
                                                                        <input type="radio" class="btn-check" name="text_color_1" value="<?= $row['color'] ?>" autocomplete="off" id="text_<?= $row['color'] ?>" hidden>
                                                                        <label class="color-label" for="text_<?= $row['color'] ?>" style="background-color: <?= $row['color'] ?>;">
                                                                            <span class="checkmark">✔</span>
                                                                            &nbsp;
                                                                        </label>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>

                                        </div>
                                    </div>

                                    <button type="button" name="add" id="add" class="btn btn-success w-25">Add block</button>


                                    <input type="hidden" name="operation" value="add">
                                    <input type="hidden" name="origin" value="addPage">
                                    <input type="hidden" name="counter" value="1" id="counter">


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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('checkbox1');
        const headerSections = document.querySelectorAll('.highlight-section');

        checkbox.addEventListener('change', function() {
            if (checkbox.checked) {
                headerSections.forEach(section => {
                    section.classList.add('highlight-background');
                });
            } else {
                headerSections.forEach(section => {
                    section.classList.remove('highlight-background');
                });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const selectElement = document.getElementById('block_1_type');

        selectElement.addEventListener('change', function() {
            const selectedValue = selectElement.value;

            // Nascondi tutte le righe
            document.querySelectorAll('.col-12 .row.page').forEach(function(row) {
                row.style.display = 'none';
                // Rimuovi l'attributo data-parsley-required da tutti gli input all'interno delle righe nascoste
                const input = row.querySelector('input');
                if (input) {
                    input.removeAttribute('data-parsley-required');
                }
            });

            // Mostra la riga corrispondente al valore selezionato
            if (selectedValue) {
                const selectedRow = document.querySelector('.page.' + selectedValue);
                if (selectedRow) {
                    selectedRow.style.display = 'block';
                    // Aggiungi l'attributo data-parsley-required all'input visibile
                    const input = selectedRow.querySelector('input');
                    if (input) {
                        input.setAttribute('data-parsley-required', 'true');
                    }
                }
            }
        });

        // Trigger the change event to handle the initial state
        selectElement.dispatchEvent(new Event('change'));
    });
</script>

<?php

if (isset($count)) {
?>
    <script>
        var i = <?= $count ?> - 1;
    </script>
<?php
} else {
?>
    <script>
        var i = 1;
    </script>
<?php
}
?>
<?php 
$colors = json_encode($colorArray); 
?> 
<script type="text/javascript">
    var galleryOptions = '<?php echo $galleryOptions; ?>';
    var postOptions = '<?php echo $postOption; ?>';
    var colorOptionsBg = '<?php echo $colorOptionsBg; ?>';
    var colorOptionsText = '<?php echo $colorOptionsText; ?>';
    var colors = <?php echo $colors; ?>;
</script>
<script src="script/mc_addBlockPage.js"></script>
<script>
$(document).ready(function() {
    $('#addPage').on('submit', function(event) {
        $(".summernote").each(function() {
            var content = $(this).summernote('code');
            $(this).val(content);
        });
    });
});
</script>