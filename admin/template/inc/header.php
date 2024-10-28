<?php

require "admin/core/prefix.php";
require "admin/inc/mc_version.php";

session_start();
// loading class

if (!is_file('admin/class/Database.php')) {
    require "admin/inc/dbdata.php";
    exit;
}

spl_autoload_register('autoloader');
function autoloader($class)
{
    include("admin/class/$class.php");
}

/////////////////////////////////////////////////////////////////////
$prefix_table = "";
if (is_file("admin/core/prefix.php")) {
    include "admin/core/prefix.php";
    $prefix_table = $prefix;
}
/////////////////////////////////////////////////////////////////////

$database = new Database();
$db = $database->getConnection();

$files = glob("admin/class/*.php", GLOB_BRACE);
rsort($files);

if (!is_file('admin/inc/class_initialize.php')) {
    $file_handle = fopen('admin/inc/class_initialize.php', 'w');
    fwrite($file_handle, '<?php');
    fwrite($file_handle, "\n");
    foreach ($files as $filename) {
        $nomefile = pathinfo($filename);
        $filelabel = $nomefile['filename'];
        $file_var = strtolower($filelabel);
        fwrite($file_handle, '$' . $file_var . ' = new ' . $filelabel . '($db);');
        fwrite($file_handle, "\n");
        fwrite($file_handle, '$' . $file_var . '->prx = "' . $prefix_table . '";');
        fwrite($file_handle, "\n");
    }
    fwrite($file_handle, "?>");
    chmod('admin/inc/class_initialize.php', 0777);
}

include "admin/inc/class_initialize.php";

$setting->name = 'lang';
$stmt_lang = $setting->showAllWhere('id', ['name']);
$row_lang = $stmt_lang->fetch(PDO::FETCH_ASSOC);
extract($row_lang);
$lang = $row_lang['value'];

foreach (glob("admin/locale/$lang/*.php") as $filelang) {
    require "$filelang";
}



$setting->name = "debug";
$dbg = $setting->showAllWhere('id', ['name']);
$row_debug = $dbg->fetch(PDO::FETCH_ASSOC);
extract($row_debug);

if ($row_debug['value'] == 1) {
    require 'admin/vendor/autoload.php';        // If installed via composer
    $debug = new \bdk\Debug(array(
        'collect' => true,
        'output' => true,
    ));
}


// prendo il nome del file (con estensione)
$file_name = basename($_SERVER['PHP_SELF']);

$post_title = "";

$page_name = "";
$page_class = "";

if ($file_name == "login.php") {
    if (isset($_SESSION['loggedin'])) {
        header('Location: admin/');
        exit;
    }
}


if ($file_name == "index.php") {

    //force the page name in home page
    $page_name_title = "Home";
    $page_class = pathinfo($file_name, PATHINFO_FILENAME);
} else if ($file_name == "post.php") {

    // get the post data
    $post->table = 'post';
    $post->id = filter_input(INPUT_GET, "id");
    $post_title_stmt = $post->showAllWhere('id', ['id']);
    $post_title_row = $post_title_stmt->fetch(PDO::FETCH_ASSOC);
    extract($post_title_row);
    $post_title = $post_title_row['title'];

    $page_name_title = $post_title . " - Blog ";
    $page_class = "blog";
} else if ($file_name == "contact.php") {

    // force the page name in contacts
    $page_name_title = $cont_form_page;
    $page_class = "contact";

} else {
    // mi prendo solo il nome senza l'estensione
    $page_name_title = pathinfo($file_name, PATHINFO_FILENAME);
    $page_class = pathinfo($file_name, PATHINFO_FILENAME);
    // rimuovo gli _ (underscore) che ho messo nel nome file
    $page_name_title = str_replace("_", " ", $page_name_title);
    // metto la prima lettera maiuscola
    $page_name_title = ucfirst($page_name_title);
}

$mc->table = 'mc_pages';
$mc->page_name = $page_class;
$page_data = $mc->showAllWhere('id', ['page_name']);

while ($row = $page_data->fetch(PDO::FETCH_ASSOC)) {

    extract($row);

    $page_id = $row['id'];
    $page_layout = $row['layout'];
    $page_header = $row['header'];
    $page_header_media = $row['header_media'];
    $page_use_name = $row['use_name'];
    $page_use_description = $row['use_desc'];
    $page_counter = $row['counter'];
}

$mc->table = 'mc_settings';
$stmt = $mc->showAll('id');

$mc_settings = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    extract($row);
    $mc_settings[$row['name']] = $row['value'];
}


$url_file = ($_SERVER['PHP_SELF']);
$root = $mc_settings['mc_site_url'];
$url = $root . $url_file;

$one = false;
if ($mc_settings['mc_theme_one'] == 1) {
    $one = true;
}

?>
<!doctype html>
<html>

<head>
    <!--
    ==========================================================================
            
         Mini Cms is a project by DM WebLab (https://www.dmweblab.com)
            
    ==========================================================================
    -->
    <meta charset="utf-8">
    <meta name="author" content="dmweblab" />

    <!-- FACEBOOK and LINKEDIN meta tag -->
    <meta property="og:title" content="<?= $mc_settings['mc_site_name'] ?>">
    <meta property="og:description" content="<?= $mc_settings['mc_site_description'] ?>">
    <meta property="og:url" content="<?= $url ?>" />
    <meta property="og:image" content="uploads/img/<?= $page_header_media ?>">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="800">

    <!-- TWITTER meta tag -->
    <meta name="twitter:card" value="summary">
    <meta name="twitter:title" content="<?= $mc_settings['mc_site_name'] ?>">
    <meta name="twitter:description" content="<?= $mc_settings['mc_site_description'] ?>">
    <meta name="twitter:site" content="<?= $url ?>" />
    <meta name="twitter:image" content="uploads/img/<?= $page_header_media ?>">

    <title><?= $page_name_title ?> - <?= $mc_settings['mc_site_name'] ?></title>
    <link href='admin/script/simplelightbox/simple-lightbox.min.css' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="admin/script/simplelightbox/simple-lightbox.jquery.min.js"></script>
    <script src="admin/script/bootstrap_mc.js"></script>

    <?php
    foreach (glob("admin/template/inc/css/*.css") as $cssfile) {
    ?>
        <link href='<?= $cssfile ?>' rel='stylesheet' type='text/css'>
    <?php
    }

    $plugin->pluginname = "post";
    if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {
        ////////////////////////////////////////////////////////////////////////////////////////////////
        ///// URL CORRETTO?
        ////////////////////////////////////////////////////////////////////////////////////////////////

    ?>
        <link href='admin/assets/css/post.css' rel='stylesheet' type='text/css'>

    <?php
    }

    // TODO
    // require "admin/inc/func/check.php";

    $plugin->pluginname = "recaptcha";
    $recap = false;
    if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {
        $recap = true;
    }

    if (($file_name == "login.php") || ($file_name == "contact.php") && $recap) {
        require "admin/template/inc/recaptcha.php";
    }
    ?>
    <link rel="stylesheet" href="admin/assets/css/carousel.css" />

    <?php
    require "assets/themes/" . $mc_settings['mc_theme'] . "/inc/scripts.php";
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>

<body>
    <div id="index"></div>

    <?php
    $mc->table = 'mc_popup';
    $mc->page_id = $page_id;
    $popup_data = $mc->showAllWhere('id', ['page_id']);

    if ($popup_data->rowCount() > 0) {
        $popup = $popup_data->fetch(PDO::FETCH_ASSOC);
        extract($popup);

        $mc->table = 'mc_popup_cat';
        $mc->id = $popup['popup_cat_id'];
        $popup_cat_stmt = $mc->showAllWhere('id', ['id']);
        $popup_cat_row = $popup_cat_stmt->fetch(PDO::FETCH_ASSOC);
        extract($popup_cat_row);
    ?>

        <script>
            $(document).ready(function() {
                $("#myPopup").modal('show');
            });
        </script>

        <div id="myPopup" class="modal fade popup <?= $popup_cat_row['category'] ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= $popup['title'] ?></h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?= $popup['content'] ?>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }

    ?>
    <script type='text/javascript'>
        $(document).ready(function() {
            // Intialize gallery
            var gallery = $('.gallery a').simpleLightbox();
        });
    </script>
    <?php
    $style = "";
    if (isset($_SESSION['loggedin'])) {
        $style = "style='margin-top:1.8em'";
    ?>
        <div id="adminBar">
            <a href="admin"><?=$fe_admin?></a>
            &nbsp; - &nbsp;
            <a href="admin/core/logout.php"><?=$common_logout?></a>
        </div>
    <?php
    }
    ?>
    <div id="siteContainer" <?= $style ?>>

        <div id="topContainer">
            <header>
                <?php
                require "assets/themes/" . $mc_settings['mc_theme'] . "/inc/header.php";
                ?>
            </header>
            <?php
            if ($page_header == 1) {
            ?>
                <div id="banner-wrapper">
                    <?php
                    if (pathinfo($page_header_media, PATHINFO_EXTENSION)) {
                        $page_arr = array("infanzia", "primaria");

                    ?>
                        <div id="banner" class="box container" style="background-image: url(uploads/img/<?= $page_header_media ?>);">
                            <div id="header_text" class="row">
                                <div class="col-7 col-12-medium">
                                    <?php
                                    if ($page_use_name == 1) {
                                    ?>
                                        <h2><?= $mc_settings['mc_site_name'] ?></h2>
                                    <?php
                                    }

                                    if ($page_use_description == 1) {
                                    ?>

                                        <p><?= $mc_settings['mc_site_description'] ?></p>
                                    <?php
                                    }
                                    if (in_array($page_class, $page_arr)) {
                                        $page_title = ucfirst($page_class);
                                    ?>
                                        <div id="titlePage">
                                            <h2><?= $page_title ?></h2>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <script>
                            $('#myVisualCarousel').carousel({
                                interval: 2000,
                                cycle: true
                            })
                        </script>

                        <div id="#myVisualCarousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <?php

                                $dirCarousel = "uploads/gallery/g_$page_header_media/";

                                $idx = 0;
                                foreach (glob($dirCarousel . "*") as $item) {

                                    $active = "";
                                    if ($idx == 0) {
                                        $active = "class=\"active\"";
                                    }

                                ?>
                                    <li data-target="#myVisualCarousel" data-slide-to="<?= $idx ?>" <?= $class ?>></li>
                                <?php

                                    $idx++;
                                }
                                ?>
                            </ol>
                            <div class="carousel-inner">

                                <?php
                                $idx = 0;
                                foreach (glob($dirCarousel . "*") as $item) {
                                    $img = pathinfo($item, PATHINFO_FILENAME);
                                    $ext = pathinfo($item, PATHINFO_EXTENSION);
                                    $imgName = $img . "." . $ext;

                                    $active = "";
                                    if ($idx == 0) {
                                        $active = "active";
                                    }

                                    $numberArr = array('first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'tenth');

                                    $number = $numberArr[$idx];

                                ?>
                                    <div class="carousel-item <?= $active ?>">
                                        <img class="<?= $number ?>-slide" src="<?= $dirCarousel ?>/<?= $imgName ?>" alt="<?= $number ?> slide">
                                    </div>
                                <?php
                                    $idx++;
                                }
                                ?>

                            </div>

                        </div>
                    <?php
                        $idx = 0;
                    }
                    ?>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="clearfix"></div>