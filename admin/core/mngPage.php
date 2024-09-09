<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__ . "/coreConfig.php";




// check if there's an account to delete

if (filter_input(INPUT_GET, "idToDel")) {

    $idToDel = filter_input(INPUT_GET, "idToDel");

    // TODO

}

$operation = filter_input(INPUT_POST, "operation");

// check if there's an account to edit or add

if (filter_input(INPUT_POST, "idToMod")) {

    // replicare l'add con l'aggiunta dei dati




} else if ($operation == "add") {

    $page_name = filter_input(INPUT_POST, 'page_name');
    $page_name = strtolower($page_name);
    $page_name = str_replace(" ", "_", $page_name);

    $counter = filter_input(INPUT_POST, 'counter');

    $arr0 = array(
        "name"    => $page_name
    );

    for ($i = 1; $i <= $counter; $i++) {

        // get the type of the block
        $post_type = filter_input(INPUT_POST, 'block_' . $i . '_type');
        $post_type_arr = explode('_', $post_type);
        $type = $post_type_arr[0];

        $array_name = "arr$i";

        $colorBg = filter_input(INPUT_POST, 'bg_color_' . $i . '');
        $colorText = filter_input(INPUT_POST, 'text_color_' . $i . '');

        if ($type == 'text') {

            $editor = preg_replace('/^\s+/', '', filter_input(INPUT_POST, 'text_' . $i . ''));
            $$array_name = array(
                'block' . $i . '_type'  => 'text',
                'block' . $i . ''       => $editor,
                'block' . $i . '_bg'    => $colorBg,
                'block' . $i . '_text'  => $colorText
            );
        } else if ($type == 'image') {

            if ($_FILES['img_' . $i . '']['size'] > 0) {
                $file->filename = $_FILES['img_' . $i . '']['name'];
                $filename = $_FILES['img_' . $i . '']['name'];

                if ($file->countFile() > 0) {
                    header("Location: ../index.php?p=allFiles&err=fileExists");
                    exit;
                }
                // set data for file uploading
                $file->inputFileName = $_FILES['img_' . $i . '']['tmp_name'];
                $file->label = $_FILES['img_' . $i . '']['name'];
                $file->path = "../../uploads/";
                $file->origin = filter_input(INPUT_POST, "origin");

                $file->operation = "add";
                if ($file->uploadFile()) {
                    //success
                    $img = $_FILES['img_' . $i . '']['name'];
                } else {
                    $img = filter_input(INPUT_POST, 'visual.jpg');
                    $err_file = "&err=infoImgFail";
                }
            } else {
                $img = filter_input(INPUT_POST, 'visual.jpg');
            }

            $$array_name = array(
                'block' . $i . '_type'  => 'image',
                'block' . $i . ''       => $img,
                'block' . $i . '_bg'    => $colorBg,
                'block' . $i . '_text'  => $colorText
            );
        } else if ($type == 'info') {

            if ($_FILES['info_img_' . $i . '']['size'] > 0) {
                $file->filename = $_FILES['info_img_' . $i . '']['name'];
                $filename = $_FILES['info_img_' . $i . '']['name'];

                if ($file->countFile() > 0) {
                    header("Location: ../index.php?p=allFiles&err=fileExists");
                    exit;
                }
                // set data for file uploading
                $file->inputFileName = $_FILES['info_img_' . $i . '']['tmp_name'];
                $file->label = $_FILES['info_img_' . $i . '']['name'];
                $file->path = "../../uploads/";
                $file->origin = filter_input(INPUT_POST, "origin");

                $file->operation = "add";
                if ($file->uploadFile()) {
                    //success
                    $img_info = $_FILES['info_img_' . $i . '']['name'];
                } else {
                    $img_info = filter_input(INPUT_POST, 'visual.jpg');
                    $err_file = "&err=infoImgFail";
                }
            } else {
                $img_info = filter_input(INPUT_POST, 'visual.jpg');
            }

            $$array_name = array(
                'block' . $i . '_type'  => 'info',
                'block' . $i . '_info'  => $img_info,
                'block' . $i . '_desc'  => filter_input(INPUT_POST, 'info_content_' . $i . ''),
                'block' . $i . '_bg'    => $colorBg,
                'block' . $i . '_text'  => $colorText
            );
        } else if ($type == 'gallery') {

            $$array_name = array(
                'block' . $i . '_type'  => 'gallery',
                'block' . $i . ''       => filter_input(INPUT_POST, 'gallery_name_' . $i . ''),
                'block' . $i . '_bg'    => $colorBg,
                'block' . $i . '_text'  => $colorText
            );
        } else if ($type == 'quote') {

            $$array_name = array(
                'block' . $i . '_type'  => 'quote',
                'block' . $i . '_bg'    => $colorBg,
                'block' . $i . '_text'  => $colorText
            );
        } else if ($type == 'post') {

            $$array_name = array(
                'block' . $i . '_type'  => 'post',
                'block' . $i . '_bg'    => $colorBg,
                'block' . $i . '_text'  => $colorText
            );
        }
    }

    $arr_tot = array($arr0);

    for ($i = 1; $i <= $counter; $i++) {
        $array_name = "arr$i";
        $arr_tot[] = $$array_name;
    }

    $target_directory = '../inc/pages/' ;
    if(!file_exists( $target_directory ) || !is_dir( $target_directory)){
        mkdir($target_directory) ;
        $oldmask = umask(0);
        chmod($target_directory, 0777);
        umask($oldmask);
    }

    $json_file = $target_directory . $page_name . '.json';
    $json = json_encode($arr_tot);

    file_put_contents($json_file, $json, FILE_APPEND);
    chmod($json_file, 0777);

    // prepare data for the db query
    $mc->page_name = $page_name;

    $mc->layout = filter_input(INPUT_POST, 'layout');

    $err_file = '';

    // check if use_header is checked
    if (filter_input(INPUT_POST, 'use_header')) {

        $mc->header = 1;
        
        // check the type of the header media
        if (filter_input(INPUT_POST, 'header') == 'image') {

            if ($_FILES['img_header']['size'] > 0) {
                $file->filename = $_FILES['img_header']['name'];
                $filename = $_FILES['img_header']['name'];

                if ($file->countFile() > 0) {
                    header("Location: ../index.php?p=allFiles&err=fileExists");
                    exit;
                }
                // set data for file uploading
                $file->inputFileName = $_FILES['img_header']['tmp_name'];
                $file->label = $_FILES['img_header']['name'];
                $file->path = "../../uploads/";
                $file->origin = filter_input(INPUT_POST, "origin");

                $file->operation = "add";
                if ($file->uploadFile()) {
                    //success
                    $mc->header_media = $_FILES['img_header']['name'];
                } else {
                    $mc->header_media = filter_input(INPUT_POST, 'visual.jpg');
                    $err_file = "&err=headerImgFail";
                }
            } else {
                $mc->header_media = filter_input(INPUT_POST, 'visual.jpg');
            }
        } else if (filter_input(INPUT_POST, 'header') == 'gallery') {

            $mc->header_media = filter_input(INPUT_POST, 'header_gallery');
        }
        
    } else {
        
        $mc->header = 0;
        $mc->header_media = NULL;
    }
    
    $mc->use_name = filter_input(INPUT_POST,'use_name') ? 1 : 0 ;
    $mc->use_desc = filter_input(INPUT_POST,'use_desc') ? 1 : 0 ;

    $mc->counter = $counter;

    $mc->table = 'mc_pages';

    if($mc->insert(['page_name','layout','header','header_media','use_name','use_desc','counter'])){

        if (copy('../template/master.php', '../../master.php')) {
            rename('../../master.php', '../../' . $page_name . '.php');
            chmod('../../' . $page_name . '.php', 0777);

            header("Location: ../index.php?p=allPages&msg=pageCustomSucc");
            exit;
        } else {
            header("Location: ../index.php?p=allPages&err=pageCustomFileErr");
            exit;
        }

    }else{
        header("Location: ../index.php?p=allPages&err=pageCustomDbErr");
        exit;
    }

} else {
    header("Location: ../index.php?p=allPages&err=noPost");
    exit;
}
