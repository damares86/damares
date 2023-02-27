<?php

require __DIR__."/coreConfig.php";

// check if there's an account to delete

if(filter_input(INPUT_GET,"idToDel")){


    $file->id = filter_input(INPUT_GET,"idToDel");

    if($file->delete('id')){
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

    /////////////////// TODO

    $idToMod = filter_input(INPUT_POST,"idToMod");
 
        $account->username = filter_input(INPUT_POST,"username") ;
        $account->email = filter_input(INPUT_POST,"email") ;

        if($_FILES['avatar']['size'] > 0){
            // set data for file uploading
            $file->filename = $_FILES['avatar']['name'] ;
            $file->inputFileName = $_FILES['avatar']['tmp_name'] ;
            $file->label = 'avatar_'.filter_input(INPUT_POST,"username") ;
            $file->path = "../uploads/avatar/" ;
            $file->origin = filter_input(INPUT_POST,"origin");
            $file->filename_orig = filter_input(INPUT_POST,"avatar_orig");
            $file->id = $file->showIdByFilename();
            $file->operation = $operation ;

            if($file->uploadFile()){
                $account->avatar = $_FILES['avatar']['name'] ;
                $_SESSION['avatar'] = $_FILES['avatar']['name'] ;
                unlink("../uploads/avatar/".filter_input(INPUT_POST,"avatar_orig"));
            }else{
                header("Location: ../index.php?p=allAccounts&err=noAvatarUpload");
                exit;
            }            
        }else{
            $account->avatar = filter_input(INPUT_POST,"avatar_orig");
        }


        if($account->update(['username','email','avatar'],'id')){

            $accountroles->role_id = filter_input(INPUT_POST,"role") ;
            $accountroles->account_id = $id ;
            
            if($accountroles->update(['role_id'],'account_id')){
                header("Location: ../index.php?p=editAccount&idToMod=$id&msg=accountEdit");
                exit;
            }else{
                header("Location: ../index.php?p=editAccount&idToMod=$id&err=accountRoleNoEdit");
                exit;  
            }

        }else{
            header("Location: ../index.php?p=editAccount&idToMod=$id&err=accountNoEdit");
            exit;
        }


        

    

}else if($operation == "add"){ 
    if($_FILES['myfile']['size'] > 0){
        
        // set data for file uploading
        $file->filename = $_FILES['myfile']['name'] ;
        $file->inputFileName = $_FILES['myfile']['tmp_name'] ;
        $file->label = filter_input(INPUT_POST,"label") ;
        $file->path = "../uploads/" ;
        $file->origin = filter_input(INPUT_POST,"origin");
        
        $file->operation = "add" ;
        
        if($file->uploadFile()){

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
    header("Location: ../index.php?p=allFiles&err=noPost");
    exit;
}