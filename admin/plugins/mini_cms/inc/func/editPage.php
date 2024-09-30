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
            <h3>Edit page</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php"><?= $common_dashboard ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Edit page
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<br>

<?php

$idToMod = filter_input(INPUT_GET, 'idToMod');

$mc->table = 'mc_pages';
$mc->id = $idToMod;
$page_to_edit = $mc->showAllWhere('id', ['id']);

?>


<section class="section">
    <div class="row">
        <div class="col-md-10 col-12">
            <div class="card shadow">
                <div class="card-header">
                    <?php

                    while ($item = $page_to_edit->fetch(PDO::FETCH_ASSOC)) {
                        extract($item);

                        $str = $item['page_name'];
                        $str = str_replace('_', ' ', $str);
                        $str = ucfirst($str);
                    ?>
                        <h4 class="card-title">Edit page: <u><?= $str ?></u></h4>
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
                                                    <input type="text" class="form-control" placeholder="Type the page name" value="<?= $str ?>" name="page_name" data-parsley-required="true" />
                                                    <input type="hidden" name="old_page_name" value="<?=$item['page_name']?>">
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
                                                        if ($item['layout'] == $style) {
                                                            $checked = 'checked';
                                                        }
                                                ?>

                                                        <input type="radio" class="btn-check" name="layout" value="<?= $style ?>" autocomplete="off" id="layout_<?= $style ?>" <?= $checked ?>>
                                                        <label class="btn btn-outline-primary" for="layout_<?= $style ?>"><img src='../assets/css/template/img/<?= $style ?>.png'></label>
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
                                                    <?php
                                                    $checked = '';

                                                    if ($item['header'] == 1) {
                                                        $checked = 'checked';
                                                    }
                                                    
                                                    ?>
                                                    <input type="checkbox" id="checkbox1" class="form-check-input" name="use_header" <?= $checked ?>>
                                                    <label for="checkbox1">&nbsp; Select to show the header on this page</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    $image = 'visual.jpg';
                                    $gallery = '';
                                    $checked_img = '';
                                    $checked_gallery = '';
                                    if ($item['header_media'] != NULL) {
                                        if (ctype_digit($item['header_media'])) {
                                            $gallery = $item['header_media'];
                                            $checked_gallery = 'checked';
                                        } else {
                                            $image = $item['header_media'];
                                            $checked_img = 'checked';
                                        }
                                    }
                                    ?>
                                    <div class="row highlight-section">
                                        <div class="col-md-3 mt-3 p-3 border-top">
                                            <label>Header style <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-9 mt-3 border-top">
                                            <div class="row mt-3">
                                                <div class="col border p-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input nomargin" type="radio" name="header" value="image" <?= $checked_img ?>>
                                                        <label class="form-check-label">&nbsp; Image</label>
                                                        <br>
                                                        <br>
                                                        <span>Actual image: <img src="../uploads/<?= $image ?>" class="d-inline w-25"></span>
                                                        <input type="hidden" name="old_header_img" value="<?=$item['header_media']?>">

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
                                                        <input class="form-check-input nomargin" type="radio" name="header" value="gallery" <?= $checked_gallery ?>>
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
                                                                                $selected = '';

                                                                                if ($item['header_media'] == $row['id']) {
                                                                                    $selected = 'selected';
                                                                                }

                                                                                $galleryOptions .= '<option value="' . $row['id'] . '">' . $row['gallery_name'] . '</option>';
                                                                            ?>

                                                                                <option value="<?= $row['id'] ?>" <?= $selected ?>><?= $row['gallery_name'] ?></option>

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
                                        $setting->name = 'mc_site_name';
                                        $sitename = $setting->showAllWhere('id', ['name']);
                                        $name = $sitename->fetch(PDO::FETCH_ASSOC);

                                        ?>
                                        <div class="col-md-9 mt-3 mb-3">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <div class="checkbox">

                                                        <?php
                                                        $checked = '';
                                                        if ($item['use_name'] == 1) {
                                                            $checked = 'checked';
                                                        }
                                                        ?>

                                                        <input type="checkbox" class="form-check-input" name="site_name" <?= $checked ?>>
                                                        <label>&nbsp; <b><?= $name['value'] ?></b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mt-3 mb-3 pb-3 border-bottom">
                                            <label>Show site description </label>
                                        </div>
                                        <?php
                                        $setting->name = 'mc_site_description';
                                        $sitename = $setting->showAllWhere('id', ['name']);
                                        $name = $sitename->fetch(PDO::FETCH_ASSOC);

                                        ?>
                                        <div class="col-md-9 mt-3 mb-3 pb-3 border-bottom">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <div class="checkbox">

                                                        <?php
                                                        $checked = '';
                                                        if ($item['use_desc'] == 1) {
                                                            $checked = 'checked';
                                                        }
                                                        ?>

                                                        <input type="checkbox" class="form-check-input" name="site_description" <?= $checked ?>>
                                                        <label>&nbsp; <b><?= $name['value'] ?></b></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="dynamic_field">

                                        <?php
                                        $json_file = 'inc/pages/' . $item['page_name'] . '.json';
                                        $data = file_get_contents($json_file);
                                        $json_arr = json_decode($data, true);

                                        $counter = $item['counter'];

                                        for ($idx = 1; $idx <= $counter; $idx++) {

                                            $block_type = $json_arr[$idx]['block' . $idx . '_type'];
                                            $text_selected = $img_selected = $info_selected = $gallery_selected = $quote_selected = '';

                                            // Imposta la variabile corretta per la selezione
                                            if ($block_type === 'text') $text_selected = 'selected';
                                            if ($block_type === 'img') $img_selected = 'selected';
                                            if ($block_type === 'info') $info_selected = 'selected';
                                            if ($block_type === 'gallery') $gallery_selected = 'selected';
                                            if ($block_type === 'quote') $quote_selected = 'selected';
                                            if ($block_type === 'post' && $plugin->itemExists('pluginname') && $plugin->isActive() == 1) {
                                                $post_selected = 'selected';
                                            }
                                            // $label_selected = $block_type . '_selected';

                                            // $$label_selected = 'selected';
                                        ?>
                                            <div class="row border-top" id="block_<?= $idx ?>">
                                                <div class="col-md-3 mt-3 p-3">
                                                    <label><b>Block <span><?= $idx ?></span></b></label>
                                                </div>
                                                <div class="col-md-5 mt-3  p-3">
                                                    <div class="form-group">
                                                        <div class="form-check mandatory">
                                                            <div class="position-relative">
                                                                <fieldset class="form-group">
                                                                    <select class="form-select" id="block_<?= $idx ?>_type" name="block_<?= $idx ?>_type">

                                                                        <option value="text_<?= $idx ?>" <?= $text_selected ?>>Text</option>
                                                                        <option value="img_<?= $idx ?>" <?= $img_selected ?>>Image</option>
                                                                        <option value="info_<?= $idx ?>" <?= $info_selected ?>>Box info</option>
                                                                        <option value="gallery_<?= $idx ?>" <?= $gallery_selected ?>>Gallery</option>
                                                                        <option value="quote_<?= $idx ?>" <?= $quote_selected ?>>Quotes</option>
                                                                        <?php
                                                                        $plugin->pluginname = "post";
                                                                        $postOption = '';
                                                                        if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {
                                                                            $postOption = '<option value="post_' . $idx . '" ' . $$label_selected . '>Latest post</option>';
                                                                        ?>
                                                                            <option value="post_<?= $idx ?>" <?= $$label_selected ?>>Latest post</option>
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
                                                    <button type="button" name="remove" id="<?= $idx ?>" class="btn btn-danger btn_remove">X</button>
                                                </div>

                                                <div class="col-12 mt-3 mb-3 px-5 pb-3 border-bottom">

                                                    <div class="row page text_<?= $idx ?>">
                                                        <?php
                                                            $text_content = '' ;
                                                            if ($block_type === 'text'){
                                                                $text_content = $json_arr[$idx]['block' . $idx] ;
                                                            }
                                                        ?>
                                                        <textarea class="tiny" name="text_content_<?= $idx ?>"><?= $text_content ?></textarea>
                                                        <!-- <textarea class="summernote" name="text_<?= $idx ?>"></textarea> -->
                                                    </div>
                                                    <div class="row page img_<?= $idx ?>">
                                                        <label>Upload an image </label>
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <div class="position-relative">
                                                                    <input class="form-control" type="file" name="img_<?= $idx ?>" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                            $actual_img = 'visual.jpg' ;
                                                            if ($block_type === 'img'){
                                                                $actual_img = $json_arr[$idx]['block' . $idx] ;
                                                            }
                                                        ?>
                                                        <span>Actual image: <img src="../uploads/<?= $actual_img ?>" class="d-inline w-25"></span>
                                                        <input type="hidden" name="old_img_<?=$idx?>" value="<?= $actual_img ?>">

                                                    </div>
                                                    <div class="row page info_<?= $idx ?>">
                                                        <label>Upload a new image</label>
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <div class="position-relative">
                                                                    <input class="form-control" type="file" name="info_img_<?= $idx ?>" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                            $actual_img = 'visual.jpg' ;
                                                            if ($block_type === 'info'){
                                                                $actual_img = $json_arr[$idx]['block' . $idx .'_info'] ;
                                                            }
                                                        ?>
                                                        <span>Actual image: <img src="../uploads/<?= $actual_img ?>" class="d-inline m-3 w-25"></span>
                                                        <input type="hidden" name="old_info_img_<?=$idx?>" value="<?= $json_arr[$idx]['block' . $idx . '_info'] ?>">
                                                        <!-- <textarea class="summernote" class="mt-5" name="info_content_1"></textarea> -->
                                                        <textarea class="tiny mt-5" name="info_content_<?= $idx ?>"><?= $json_arr[$idx]['block' . $idx . '_desc'] ?></textarea>
                                                    </div>
                                                    <div class="row page gallery_<?= $idx ?>">
                                                        <div class="col-7">
                                                            <label class="mb-3">Choose a gallery <span class="text-danger">*</span></label>
                                                            <div class="form-group">
                                                                <div class="form-check mandatory">
                                                                    <div class="position-relative">
                                                                        <fieldset class="form-group">
                                                                            <select class="form-select" name="gallery_name_<?= $idx ?>">
                                                                                <?php
                                                                                $mc->table = 'mc_galleries';
                                                                                $galleries = $mc->showAll('id');
                                                                                while ($row = $galleries->fetch(PDO::FETCH_ASSOC)) {
                                                                                    $selected = '';
                                                                                    if ($json_arr[$idx]['block' . $idx] == $row['id']) {
                                                                                        $selected = 'selected';
                                                                                    }
                                                                                ?>
                                                                                    <option value="<?= $row['id'] ?>" <?= $selected ?>><?= $row['gallery_name'] ?></option>

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
                                                    <div class="row page quote_<?= $idx ?>">
                                                        <p>Show a slideshow with quotes</p>
                                                        <input type="hidden" name="quote_<?= $idx ?>" value="q">
                                                    </div>
                                                    <div class="row page post_<?= $idx ?>">
                                                        <p>Show the latest post of the blog</p>
                                                        <input type="hidden" name="post_<?= $idx ?>" value="p">
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
                                                                        <?php
                                                                        $none_checked = '';
                                                                        if ($json_arr[$idx]['block' . $idx . '_bg'] == 'none') {
                                                                            $none_checked = 'checked';
                                                                        }
                                                                        ?>
                                                                        <input type="radio" class="btn-check" name="bg_color_<?= $idx ?>" value="none" autocomplete="off" id="bg_none_<?= $idx ?>" hidden <?= $none_checked ?>>
                                                                        <label class="color-label bg" for="bg_none_<?= $idx ?>" style="background-color: #e5e5e5;">
                                                                            None
                                                                            <span class="checkmark"></span>
                                                                        </label>

                                                                        <!-- Loop per i colori del Background -->
                                                                        <?php
                                                                        $mc->table = 'mc_color';
                                                                        $colors = $mc->showAll('id');
                                                                        $colorArray = [];

                                                                        while ($row = $colors->fetch(PDO::FETCH_ASSOC)) {
                                                                            $colorArray[] = ['color' => $row['color']];
                                                                            $bg_checked = '';
                                                                            if ($json_arr[$idx]['block' . $idx . '_bg'] == $row['color']) {
                                                                                $bg_checked = 'checked';
                                                                            }
                                                                        ?>
                                                                            <input type="radio" class="btn-check" name="bg_color_<?= $idx ?>" value="<?= $row['color'] ?>" autocomplete="off" id="bg_<?= $row['color'] ?>_<?= $idx ?>" hidden <?= $bg_checked ?>>
                                                                            <label class="color-label" for="bg_<?= $row['color'] ?>_<?= $idx ?>" style="background-color: <?= $row['color'] ?>;">
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
                                                                        <?php
                                                                        $none_checked = '';
                                                                        if ($json_arr[$idx]['block' . $idx . '_text'] == 'none') {
                                                                            $none_checked = 'checked';
                                                                        }
                                                                        ?>
                                                                        <input type="radio" class="btn-check" name="text_color_<?= $idx ?>" value="none" autocomplete="off" id="text_none_<?= $idx ?>" hidden <?= $none_checked ?>>
                                                                        <label class="color-label text" for="text_none_<?= $idx ?>" style="background-color: #e5e5e5;">
                                                                            None
                                                                            <span class="checkmark"></span>
                                                                        </label>

                                                                        <!-- Loop per i colori del Text -->
                                                                        <?php
                                                                        $mc->table = 'mc_color';
                                                                        $colors = $mc->showAll('id');

                                                                        while ($row = $colors->fetch(PDO::FETCH_ASSOC)) {
                                                                            $text_checked = '';
                                                                            if ($json_arr[$idx]['block' . $idx . '_text'] == $row['color']) {
                                                                                $text_checked = 'checked';
                                                                            }
                                                                        ?>
                                                                            <input type="radio" class="btn-check" name="text_color_<?= $idx ?>" value="<?= $row['color'] ?>" autocomplete="off" id="text_<?= $row['color'] ?>_<?= $idx ?>" hidden <?= $text_checked ?>>
                                                                            <label class="color-label" for="text_<?= $row['color'] ?>_<?= $idx ?>" style="background-color: <?= $row['color'] ?>;">
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
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <button type="button" name="add" id="add" class="btn btn-success w-25">Add block</button>


                                    <input type="hidden" name="operation" value="edit">
                                    <input type="hidden" name="origin" value="editPage">
                                    <input type="hidden" name="idToMod" value="<?=$idToMod?>">
                                    <input type="hidden" name="counter" value="<?= $counter ?>" id="counter">

                                <?php
                            }
                                ?>

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
        // Gestisce il checkbox per evidenziare la sezione dell'header
        const checkbox = document.getElementById('checkbox1');
        const headerSections = document.querySelectorAll('.highlight-section');

        // Controlla lo stato iniziale della checkbox
        if (checkbox.checked) {
            headerSections.forEach(section => {
                section.classList.add('highlight-background');
            });
        }

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

        // Funzione per aggiornare la visibilità dei blocchi
        function updateBlockVisibility(selectElement) {
            const selectedValue = selectElement.value;
            const blockId = selectElement.id.replace('_type', ''); // Identifica l'ID del blocco

            // console.log("Processing block ID:", blockId);
            // console.log("Selected value:", selectedValue);

            // Verifica se l'elemento del blocco esiste nel DOM
            const blockElement = document.getElementById(blockId);
            if (!blockElement) {
                console.log(`Block element with ID ${blockId} not found in the DOM.`);
                return;
            }

            // Nascondi tutte le righe relative al blocco corrente
            blockElement.querySelectorAll('.row.page').forEach(function(row) {
                row.style.display = 'none';
                const input = row.querySelector('input');
                if (input) {
                    input.removeAttribute('data-parsley-required');
                }
            });

            // Mostra la riga corrispondente al valore selezionato
            const selectedRow = blockElement.querySelector('.page.' + selectedValue);
            if (selectedRow) {
                // console.log("Selected Row found: ", selectedRow);
                selectedRow.style.display = 'block';
                const input = selectedRow.querySelector('input');
                if (input && input.type !== 'file') {
                    input.setAttribute('data-parsley-required', 'true');
                }
            } else {
                // console.log("Selected Row not found for block: ", blockId);
            }
        }

        // Funzione per inizializzare la visibilità dei blocchi in base ai dati
        function initializeBlockSelects() {
            document.querySelectorAll('select[id^="block_"][id$="_type"]').forEach(function(selectElement) {
                selectElement.addEventListener('change', function() {
                    updateBlockVisibility(selectElement);
                });

                // Inizializza lo stato attuale per ogni blocco
                updateBlockVisibility(selectElement);
            });
        }

        // Inizializzazione per i blocchi già presenti
        initializeBlockSelects();

        // Gestione per i nuovi blocchi aggiunti dinamicamente
        document.getElementById('add').addEventListener('click', function() {
            // Utilizzare un ritardo per garantire che il blocco sia effettivamente aggiunto al DOM
            setTimeout(() => {
                console.log("Reinitializing after adding new blocks.");
                initializeBlockSelects();
            }, 500); // Aumenta il ritardo se necessario
        });
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
        var i = <?= $counter ?>;
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