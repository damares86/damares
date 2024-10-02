<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__ . "/coreConfig.php";

// check if there's a page to delete

if (filter_input(INPUT_GET, "idToDel")) {

    // gestire il discorso del colore usato

    $idToDel = filter_input(INPUT_GET, "idToDel");

    $mc->table = 'mc_galleries';
    $mc->id = $idToDel;

    if ($mc->delete('id')) {
        ///////////////////////////////
        // REMOVE ALL FILES
        ///////////////////////////////

        header("Location: ../index.php?p=allQuotes&msg=quoteDelSucc");
        exit;
    } else {
        header("Location: ../index.php?p=allQuotes&err=quoteDelFail");
        exit;
    }
}

?>

<pre>

<?php
// print_r($_POST);
// $count = count($_FILES['myfile']['name']);
// echo $count ;
// print_r($_FILES);
?>
</pre>

<?php

// exit;

$operation = filter_input(INPUT_POST, "operation");

// check if there's an account to edit or add

if ($operation == 'add') {

    // insert gallery in db
    $mc->table = 'mc_galleries';
    $gallery_name = filter_input(INPUT_POST, 'gallery_name'); 
    $mc->gallery_name = $gallery_name ;
    $error = 0;
    if (!$mc->insert(['gallery_name'])) {
        header("Location: ../index.php?p=allGalleries&err=galleryAddFail");
        exit;
    } else {

        $mc->table = 'mc_galleries' ;
        $stmt = $mc->showAllLimitDesc('id',1);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $last_id = $row['id'];

        for ($i = 0; $i < count($_FILES['myfile']['name']); $i++) {

            if ($_FILES['myfile']['size'][$i] > 0) {

                $filename = $_FILES['myfile']['name'][$i];
                $mc->filename = $filename;
                $mc->inputFileName = $_FILES['myfile']['tmp_name'][$i];
                // $mc->label =  $gallery_name . '_'.$i ;
                $mc->path = "../../uploads/gallery/g_$last_id/";
                $mc->origin = filter_input(INPUT_POST, "origin");

                $mc->operation = filter_input(INPUT_POST, "operation");

                if (!$mc->uploadFile()) {
                    $error++;
                }
            }

            $error_msg = '';
            if ($error > 0) {
                $error_msg = '&err=errFileImg';
            }
        }
        header("Location: ../index.php?p=allGalleries&msg=galleryAddSucc$error_msg");
        exit;
    }
} else if ($operation == 'edit') {

    $mc->quote = filter_input(INPUT_POST, 'quote');
    $mc->author = filter_input(INPUT_POST, 'author');
    $mc->id = filter_input(INPUT_POST, 'idToMod');
    $mc->table = 'mc_quotes';

    if ($mc->update(['quote', 'author'], 'id')) {
        header("Location: ../index.php?p=allQuotes&msg=quoteEditSucc");
        exit;
    } else {
        header("Location: ../index.php?p=allQuotes&err=quoteEditFail");
        exit;
    }
} else {
    header("Location: ../index.php?p=allTheme&err=noPost");
    exit;
}
