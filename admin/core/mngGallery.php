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

    $idToDel = filter_input(INPUT_GET, "idToDel") ;
    
    $mc->table = 'mc_galleries' ;
    $mc->id = $idToDel ;

    if($mc->delete('id')){
        ///////////////////////////////
        // REMOVE ALL FILES
        ///////////////////////////////

        header("Location: ../index.php?p=allQuotes&msg=quoteDelSucc");
        exit;
    }else{
        header("Location: ../index.php?p=allQuotes&err=quoteDelFail");
        exit;
    }

}

?>

<pre>

<?php
print_r($_POST);
print_r($_FILES);
?>
</pre>

<?php

exit;

$operation = filter_input(INPUT_POST, "operation");

// check if there's an account to edit or add

if ($operation == 'add') {

    $mc->gallery_name = filter_input(INPUT_POST,'gallery_name') ;
    $mc->author = filter_input(INPUT_POST,'author') ;
    $mc->table = 'mc_quotes' ;






    if($_FILES['myfile']['size'] > 0){

        $file->filename = $_FILES['myfile']['name'] ;
        $filename = $_FILES['myfile']['name'] ;
        $file->inputFileName = $_FILES['myfile']['tmp_name'] ;
        $file->path = "../uploads/" ;
        $file->origin = filter_input(INPUT_POST,"origin");

        $file->operation = filter_input(INPUT_POST,"operation") ;
        $filename_orig = $_POST['filename_orig'];
        
        if($file->uploadFile()){
            if(file_exists('../uploads/'.$filename_orig.'_old')){
                unlink('../uploads/'.$filename_orig.'_old');
            }else{
                unlink("../uploads/$filename_orig");
            }
          
            header("Location: ../index.php?p=allFiles&msg=fileEditSucc$url_data");
            exit;
        }else{
            header("Location: ../index.php?p=allFiles&err=fileEditFail$url_data");
            exit;
        }

    }





    if($mc->insert(['quote','author']) ){
        header("Location: ../index.php?p=allQuotes&msg=quoteAddSucc");
        exit;
    }else{
        header("Location: ../index.php?p=allQuotes&err=quoteAddFail");
        exit;
    }
    
} else if ($operation == 'edit') {

    $mc->quote = filter_input(INPUT_POST,'quote') ;
    $mc->author = filter_input(INPUT_POST,'author') ;
    $mc->id = filter_input(INPUT_POST,'idToMod') ; 
    $mc->table = 'mc_quotes' ;

    if($mc->update(['quote','author'],'id') ){
        header("Location: ../index.php?p=allQuotes&msg=quoteEditSucc");
        exit;
    }else{
        header("Location: ../index.php?p=allQuotes&err=quoteEditFail");
        exit;
    }

}else {
    header("Location: ../index.php?p=allTheme&err=noPost");
    exit;
}
