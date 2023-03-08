<?php

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

    if($_FILES['myfile']['size'] > 0){

        $file->filename = $_FILES['myfile']['name'] ;
        $filename = $_FILES['myfile']['name'] ;
        $file->inputFileName = $_FILES['myfile']['tmp_name'] ;
        $file->path = "../uploads/" ;
        $file->origin = filter_input(INPUT_POST,"origin");

        $file->operation = filter_input(INPUT_POST,"operation") ;

        
        
        if($file->uploadFile()){
            $filename_orig = $_POST['filename_orig'];
            unlink("../uploads/$filename_orig");

            $plugin->pluginname = "file_for_role" ;
            if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
                    $file->filename = $filename ;
                    $stmt = $fileforrole->showRoleFile();
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        
                        $fileforrole->id = $row['id'] ;
                        $fileforrole->delete('id');
                    }
                
                    require "mngFileforrole.php" ;
                }

           
            header("Location: ../index.php?p=allFiles&msg=fileEditSucc");
            exit;
        }else{
            header("Location: ../index.php?p=allFiles&err=fileEdiFail");
            exit;
        }

    } else{

        if($file->update(['label'],'id')){
            $plugin->pluginname = "file_for_role" ;
            
            $stmt = $file->showAllWhere('id',['id']);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $filename = $row['filename'] ;


            if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
                    $fileforrole->file_id = $idToMod ;
                    $stmt = $fileforrole->showAllWhere('id',['file_id']);
                    
                    $file->filename = $filename ;
                    
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);                        
                        $fileforrole->id = $row['id'] ;
                        $fileforrole->delete('id');
                    }
                    require "mngFileforrole.php" ;
                }

            header("Location: ../index.php?p=allFiles&msg=fileEditSucc");
            exit;
        }else{
            header("Location: ../index.php?p=allFiles&msg=fileEditFail");
            exit;
        }
        
    }

        

}else if($operation == "add"){ 

    if($_FILES['myfile']['size'] > 0){
        $file->filename = $_FILES['myfile']['name'] ;
        $filename = $_FILES['myfile']['name'] ;

        if($file->countFile()>0){
            
            header("Location: ../index.php?p=allFiles&err=fileExists");
            exit;
        }
        // set data for file uploading
        $file->inputFileName = $_FILES['myfile']['tmp_name'] ;
        $file->label = filter_input(INPUT_POST,"label") ;
        $file->path = "../uploads/" ;
        $file->origin = filter_input(INPUT_POST,"origin");
        
        $file->operation = "add" ;
        
        if($file->uploadFile()){
            $plugin->pluginname = "file_for_role" ;
            if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
                    $file->filename = $filename ;
                    require "mngFileforrole.php" ;
                }
                //success
                header("Location: ../index.php?p=allFiles&msg=fileSucc");
                exit;
            }else{
                header("Location: ../index.php?p=allFiles&err=fileFail");
                exit;
            }
        }else{
            header("Location: ../index.php?p=allFiles&err=fileErr");
            exit;
        }

}else{
    header("Location: ../index.php?p=allFiles&err=noFilePost");
    exit;
}