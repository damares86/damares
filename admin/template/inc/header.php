<?php

// require 'admin/vendor/autoload.php';		// If installed via composer
// $debug = new \bdk\Debug(array(
// 	'collect' => true,
// 	'output' => true,
// ));

session_start();
// loading class

if(!is_file('admin/class/Database.php')){
    require "admin/inc/dbdata.php";
    exit;
}

require "admin/inc/version.php";


spl_autoload_register('autoloader');
    function autoloader($class){
        include("admin/class/$class.php");
    }


$prefix_table="";
if(is_file("admin/core/prefix.php")){
    include "admin/core/prefix.php";
    $prefix_table=$prefix;
}

$database = new Database();
$db = $database->getConnection();

$files=glob("admin/class/*.php", GLOB_BRACE);
rsort($files); 

if(!is_file('admin/inc/class_initialize.php')){
$file_handle = fopen('admin/inc/class_initialize.php', 'w');
fwrite($file_handle, '<?php');
fwrite($file_handle, "\n");
foreach ($files as $filename) {
    $nomefile = pathinfo($filename);
    $file=$nomefile['filename'];
    $file_var = strtolower($file);
    fwrite($file_handle, '$'.$file_var.' = new '.$file.'($db);');
    fwrite($file_handle, "\n");
    fwrite($file_handle, '$'.$file_var.'->prx = "'.$prefix_table.'";');
    fwrite($file_handle, "\n");

}
fwrite($file_handle,"?>");
chmod('admin/inc/class_initialize.php',0777);

}

include "admin/inc/class_initialize.php";

$stmt2=$settings->showSettings();

$stmt3=$settings->showLangAndName();
$lang=$settings->dashboard_language;


foreach (glob("admin/locale/$lang/*.php") as $file){
    require "$file";
}

// prendo il nome del file (con estensione)
$file = basename($_SERVER['PHP_SELF']);

$post_title="";
if(filter_input(INPUT_GET,"id")){
$post_id=filter_input(INPUT_GET,"id");

$post->id=$post_id;
$post->showById();
$post_title = $post->title;
}


$page_name="";
$page_class="";
if($file=="login.php"){
    if (isset($_SESSION['loggedin'])) {
        header('Location: admin/');
        exit;
    }
}

$root="";

if($file=="index.php"){
    $page_name="Home";
    $page_class = pathinfo($file, PATHINFO_FILENAME);
} else if($file=="post.php"){
    $page_name=$post_title." - Blog ";
    $page_class="blog";
}else if($file=="contact.php"){
    $page_name=$cont_form_page;
    $page_class="contact";
}else if($file=="blog.php"){
    $page_class="blog";
}else{
// mi prendo solo il nome senza l'estensione
$page_name = pathinfo($file, PATHINFO_FILENAME);
$page_class = pathinfo($file, PATHINFO_FILENAME);
// rimuovo gli _ (underscore) che ho messo nel nome file
$page_name=str_replace("_"," ", $page_name);
// metto la prima lettera maiuscola
$page_name=ucfirst($page_name);
}

$lang="";

    $page->page_name=$page_class;

$default="";
$showDefault=$page->showAllDefault();
$name="";
if($file=="index.php"){
    $name="index";
}else{
    $name=ucfirst($page_class);
}
foreach($showDefault as $row){
    if($name==$row['page_name']){
        $default=1;
    }
}

if($default==1){
    $stmt=$page->showByNameDefault();
}else{

    $stmt=$page->showByName();
}


    $img=$page->img;


while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
    
    extract($row);
    $theme=$row['theme'];
    $lang=$row['dashboard_language'];

    $one="";
    if(is_file("assets/$theme/one.php")){
        $one=1;
    }

    if($one){
        ?>
            <script>      
            var path = window.location.pathname;
            var page = path.split("/").pop();
            var hash = window.location.hash;
            if(!hash&&page==('index.php')){
                console.log("ciao");
                location.href = 'index.php#index';
            }
            </script>

        <?php
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
        <meta property="og:title" content="<?=$site_name?>">
        <meta property="og:description" content="<?=$site_description?>">
        <meta property="og:url" content="<?=$url?>" />
        <meta property="og:image" content="uploads/img/<?=$img?>">
        <meta property="og:image:type" content="image/jpeg">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="800">

        <!-- TWITTER meta tag -->
        <meta name="twitter:card" value="summary">
        <meta name="twitter:title" content="<?=$site_name?>"> 
        <meta name="twitter:description" content="<?=$site_description?>"> 
        <meta name="twitter:site" content="<?=$url?>"/>
        <meta name="twitter:image" content="uploads/img/<?=$img?>"> 
        

		<title><?=$page_name?> - <?=$site_name?></title>
        <link rel="icon" href="assets/<?= $theme ?>/img/favicon.ico">

        
        <link rel="stylesheet" href="admin/assets/css/my-login.css" />
        <link href='admin/scripts/simplelightbox/simple-lightbox.min.css' rel='stylesheet' type='text/css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="admin/scripts/simplelightbox/simple-lightbox.jquery.min.js"></script>
        <script src="admin/assets/js/bootstrap.min.js"></script>
        <link type="text/css" href="admin/assets/css/bootstrap.min.css" rel="stylesheet">

<?php
foreach (glob("admin/template/inc/css/*.css") as $cssfile){
    ?>
    <link href='<?=$cssfile?>' rel='stylesheet' type='text/css'>
<?php
}
$root="";
require "admin/inc/func/check.php";
if(($file=="login.php")||($file=="contact.php")){
    require "admin/template/inc/recaptcha.php";
}
?>
<link rel="stylesheet" href="admin/assets/css/carousel.css" />  
<?php
require "assets/".$theme."/inc/scripts.php";
?>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
	</head>

	<body>
    <div id="index"></div>

    <?php
    if(is_file("admin/class/Popup.php")){
    $popup->page_popup=$name;
    $popup->id_popup=0;
    $popup_exist=$popup->showPopupByPage();
    if($popup->id_popup!=0){
    ?>

    <script>
        $(document).ready(function(){
            $("#myPopup").modal('show');
        });
    </script>

    <div id="myPopup" class="modal fade popup <?=$name?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?=$popup->title_popup?></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <?=$popup->editor_popup?>
                </div>
            </div>
        </div>
    </div>

    <?php
}
    }

    ?>
            <script type='text/javascript'>
                $(document).ready(function(){                
                    // Intialize gallery
                    var gallery = $('.gallery a').simpleLightbox();                    
                    });
                </script>
        <?php
            $style="";
            if(isset($_SESSION['loggedin'])){
                $style="style='margin-top:1.8em'";
        ?>
        <div id="adminBar">
            <a href="admin"><?=$goToAdmin?></a>
            &nbsp; - &nbsp;
            <a href="admin/core/logout.php">Logout</a>
        </div>
        <?php
            }
        ?>
        <div id="siteContainer" <?=$style?>>
            <div id="topContainer">
                <header>
                <?php
                    require "assets/".$theme."/inc/header.php";
                ?>  
                </header>
                <?php
                    if($page->header==1){
                        ?>
                <div id="banner-wrapper">
                <?php    
                if(pathinfo($page->img, PATHINFO_EXTENSION)){
                ?>
                    <div id="banner" class="box container" style="background-image: url(<?=$root?>uploads/img/<?=$img?>);">
						<div id="header_text" class="row">
                            <div class="col-7 col-12-medium">
                            <?php
                            if($page->use_name==1){
                            ?>
								<h2><?=$site_name?></h2>
                            <?php
                            }
                            
                            if($page->use_desc==1){
                            ?>

								<p><?=$site_description?></p>
                            <?php
                            }
                            ?>
							</div>
						</div>
					</div>
                <?php
                }else{
                        $gallery_name_visual=$page->img;
                        $folder_visual= str_replace(" ","_", $gallery_name_visual);
                        $folder_visual=strtolower($folder_visual);
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

                                $dirCarousel="misc/gallery/img/$folder_visual/";

                                $idx=0;
                                foreach (glob($dirCarousel."*") as $file) {
                                    
                                    $active="";
                                    if($idx==0){
                                    $active="class=\"active\"";
                                    }
                                
                                ?>
                                <li data-target="#myVisualCarousel" data-slide-to="<?=$idx?>" <?=$class?>></li>
                                <?php

                                    $idx++;
                                }
                                ?>
                                </ol>
                                <div class="carousel-inner">

                                <?php
                                $idx=0;
                                foreach (glob($dirCarousel."*") as $file) {
                                    $img=pathinfo($file, PATHINFO_FILENAME);
                                    $ext=pathinfo($file, PATHINFO_EXTENSION);
                                    $imgName=$img.".".$ext;

                                    $active="";
                                    if($idx==0){
                                    $active="active";
                                    }

                                    $numberArr=array('first','second','third','fourth','fifth','sixth','seventh','eighth','ninth','tenth');

                                    $number=$numberArr[$idx];

                                    ?>
                                <div class="carousel-item <?=$active?>">
                                    <img class="<?=$number?>-slide" src="<?=$dirCarousel?>/<?=$imgName?>" alt="<?=$number?> slide">
                                </div>
                                <?php
                                $idx++;
                                }
                                ?>
                                
                                </div>
                                
                            </div>
                <?php
                $idx=0;
                }
                ?>
				</div>
                    <?php
                    }
                ?> 
            </div>
            <div class="clearfix"></div>
            <?php
}
?>