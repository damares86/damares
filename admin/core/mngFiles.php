<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

require __DIR__."/coreConfig.php";

// check if there's a file to delete

if(filter_input(INPUT_GET,"idToDel")){


    $idToDel = filter_input(INPUT_GET,"idToDel");
    $file->id = $idToDel;
    
    $filename = $file->showFilenameById();
    $file->id = $idToDel;

    if($file->delete('id')){

        unlink("../uploads/$filename");

        header("Location: ../index.php?p=allFiles&msg=fileDel");
        exit;
    }else{
        header("Location: ../index.php?p=allFiles&err=fileNoDel");
        exit;
    }

}

$operation = filter_input(INPUT_POST,"operation") ;

// check if there's an account to edit or add

if(filter_input(INPUT_POST,"idToMod")){
    
    $idToMod = filter_input(INPUT_POST,"idToMod");
    
    $file->id = $idToMod ;
    $file->label = filter_input(INPUT_POST,"label") ;

    $url_tablePage = filter_input(INPUT_POST,'url_tablePage');
    $url_pageName = filter_input(INPUT_POST,'url_pageName');

    $url_data = "&tablePage=$url_tablePage&pageName=$url_pageName" ;

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

    } else{

        if($file->update(['label'],'id')){
            header("Location: ../index.php?p=allFiles&msg=fileEditSucc$url_data");
            exit;
        }else{
            header("Location: ../index.php?p=allFiles&msg=fileEditFail$url_data");
            exit;
        }
        
    }

        

}else if($operation == "add"){ 

    if($_FILES['myfile']['size'] > 0){
        $file->filename = $_FILES['myfile']['name'] ;
        $filename = $_FILES['myfile']['name'] ;

        if($file->countFile()>0){
            
            header("Location: ../index.php?p=allFiles&err=fileExists$url_data");
            exit;
        }
        // set data for file uploading
        $file->inputFileName = $_FILES['myfile']['tmp_name'] ;
        $file->label = filter_input(INPUT_POST,"label") ;
        $file->path = "../uploads/" ;
        $file->origin = filter_input(INPUT_POST,"origin");
        
        $file->operation = "add" ;
        
        if($file->uploadFile()){
            //success
            header("Location: ../index.php?p=allFiles&msg=fileSucc$url_data");
            exit;
        }else{
            header("Location: ../index.php?p=allFiles&err=fileFail$url_data");
            exit;
        }
    }else{
        header("Location: ../index.php?p=allFiles&err=fileErr$url_data");
        exit;
    }

}else{
    header("Location: ../index.php?p=allFiles&err=noFilePost$url_data");
    exit;
}