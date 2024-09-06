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
} else if ($operation == "add") {

    $mc->page_name = filter_input(INPUT_POST, 'page_name');
    $mc->layout = filter_input(INPUT_POST, 'layout');

    $query_str = '';
    $err_file = '';

    // check if use_header is checked
    if (filter_input(INPUT_POST, 'use_header')) {

        $mc->header = 1;

        // check the type of the header media
        if (filter_input(INPUT_POST, 'header') == 'image') {

            if ($_FILES['myfile']['size'] > 0) {
                $file->filename = $_FILES['myfile']['name'];
                $filename = $_FILES['myfile']['name'];

                if ($file->countFile() > 0) {
                    header("Location: ../index.php?p=allFiles&err=fileExists");
                    exit;
                }
                // set data for file uploading
                $file->inputFileName = $_FILES['myfile']['tmp_name'];
                $file->label = $_FILES['myfile']['name'];
                $file->path = "../../uploads/";
                $file->origin = filter_input(INPUT_POST, "origin");

                $file->operation = "add";
                if ($file->uploadFile()) {
                    //success
                    $mc->header_media = $_FILES['myfile']['name'];
                } else {
                    $mc->header_media = filter_input(INPUT_POST, 'visual.jpg');
                    $err_file = "&err=headerImgFail";
                }
            } else {
                $mc->header_media = filter_input(INPUT_POST, 'visual.jpg');
            }
        } else if (filter_input(INPUT_POST, 'header') == 'gallery') {

            $mc->header_media = filter_input(INPUT_POST, 'gallery');
        }

        $query_str = ', header_media';
    } else {

        $mc->header = 0;
    }

    $counter = filter_input(INPUT_POST, 'counter');
    $mc->counter = $counter;



    for ($i = 1; $i <= $counter; $i++) {

        // get the type of the block
        $post_type = filter_input(INPUT_POST, 'block_' . $i . '_type');
        $post_type_arr = explode('_', $post_type);
        $type = $post_type_arr[0];

        $array_name = "arr$i";


        if($type == 'text'){


            
        }else if ($type == 'image'){
            // caricamento immagine 
            
        }else if($type== 'info'){
            // caricamento immagine
            // prendo contenuto testo
        }else if($type == 'gallery'){
            // prendo id gallery

        }else if($type == 'quote'){

        }else if($type == 'post'){

        }


?>
        <pre>
        <?php
        print_r($_POST);
        exit;
        ?>
    </pre>
<?php




        $sess_type = "sess_type_$i";
        $sess_bg = "sess_bg_$i";
        $sess_text = "sess_text_$i";
        $array_name = "arr$i";



        if ($_SESSION["$sess_type"] == "p") {
            if ($_SESSION['sess_pict_' . $i . '']) {
                $page->img_pict = $_SESSION['sess_pict_' . $i . ''];
                $page->img_tmp_pict = $_SESSION['sess_pict_' . $i . '_tmp'];
            } else {
                $page->img_pict = $_FILES['pict' . $i . '']['name'];
                $page->img_tmp_pict = $_FILES['pict' . $i . '']['tmp_name'];
            }
            $page->uploadPicture();
            $$array_name = array(
                'block' . $i . '_type'     => $_SESSION["$sess_type"],
                'block' . $i . '_pict'     => $page->img_pict,
                'block' . $i . '_bg'    => $_SESSION['' . $sess_bg . ''],
                'block' . $i . '_text'  => $_SESSION['' . $sess_text . '']
            );
        } else if ($_SESSION["$sess_type"] == "i") {
            if ($_SESSION['sess_pict_info_' . $i . '']) {
                $page->img_info = $_SESSION['sess_pict_info_' . $i . ''];
                $page->img_tmp_info = $_SESSION['sess_pict_info_' . $i . '_tmp'];
            } else {
                $page->img_info = $_FILES['info' . $i . '']['name'];
                $page->img_tmp_info = $_FILES['info' . $i . '']['tmp_name'];
            }
            $page->uploadInfo();
            $editor = preg_replace('/^\s+/', '', $_SESSION["sess_info_editor$i"]);
            $$array_name = array(
                'block' . $i . '_type'     => $_SESSION["$sess_type"],
                'block' . $i . '_info'     => $page->img_info,
                'block' . $i . '_desc'     => $editor,
                'block' . $i . '_bg'    => $_SESSION['' . $sess_bg . ''],
                'block' . $i . '_text'  => $_SESSION['' . $sess_text . '']
            );
        } else if ($_SESSION["$sess_type"] == "t") {
            $editor = preg_replace('/^\s+/', '', $_SESSION["sess_editor$i"]);
            $$array_name = array(
                'block' . $i . '_type'     => $_SESSION["$sess_type"],
                'block' . $i . ''        => $editor,
                'block' . $i . '_bg'    => $_SESSION['' . $sess_bg . ''],
                'block' . $i . '_text'  => $_SESSION['' . $sess_text . '']
            );
        } else {
            $$array_name = array(
                'block' . $i . '_type'     => $_SESSION["$sess_type"],
                'block' . $i . '_bg'    => $_SESSION['' . $sess_bg . ''],
                'block' . $i . '_text'  => $_SESSION['' . $sess_text . '']
            );
        }
    }

    $arr_tot = array($arr0);

    for ($i = 1; $i <= $counter; $i++) {
        $array_name = "arr$i";
        $arr_tot[] = $$array_name;
    }

    $page_name = preg_replace('/\s+/', '_', $_SESSION['sess_page_name']);
    $page_name = strtolower($page_name);

    $file = '../inc/pages/' . $page_name . '.json';
    $json = json_encode($arr_tot);

    file_put_contents($file, $json, FILE_APPEND);
    chmod($file, 0777);

    if ($page->insert()) {

        $str = $page->page_name;
        $str = preg_replace('/\s+/', '_', $str);

        $str = strtolower($str);

        if (copy('../template/master.php', '../../master.php')) {
            rename('../../master.php', '../../' . $str . '.php');
            chmod('../../' . $str . '.php', 0777);

            $page->counter = $counter;

            $page->destroyCheckSessVar();

            header("Location: ../index.php?man=page&op=show&type=custom&msg=pageSucc");
            exit;
        } else {
            header("Location: ../index.php?man=page&op=show&type=custom&msg=pageErr");
            exit;
        }
    } else {
        header("Location: ../index.php?man=page&op=show&type=custom&msg=pageErr");
        exit;
    }
} else {
    header("Location: ../index.php?p=allAccounts&err=noPost");
    exit;
}
