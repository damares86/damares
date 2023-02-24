<?php

require __DIR__."/coreConfig.php";

// check if there's an account to delete

if(filter_input(INPUT_GET,"idToDel")){

    // $idToDel = filter_input(INPUT_GET,"idToDel");
    $accountroles->account_id = filter_input(INPUT_GET,"idToDel");
    $accountroles->delete('account_id');
    $account->table = "accounts";

    $account->id = filter_input(INPUT_GET,"idToDel");

    if($account->delete('id')){
        header("Location: ../index.php?p=allAccounts&msg=accountDel");
        exit;
    }else{
        header("Location: ../index.php?p=allAccounts&err=accountNoDel");
        exit;
    }

}

$operation = filter_input(INPUT_POST,"operation") ;

// check if there's an account to edit or add

if(filter_input(INPUT_POST,"idToMod")){

    $id = filter_input(INPUT_POST,"idToMod");
    $account->id = $id;
    $account->table = "accounts" ;

    if($operation=="password"){

        $password = filter_input(INPUT_POST,"password");
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $account->password = $password_hash ;

        if($account->update(['password'],'id')){
            header("Location: ../index.php?p=editAccount&idToMod=$id&msg=passMod");
            exit;
        }else{
            header("Location: ../index.php?p=editAccount&idToMod=$id&err=passNoMod");
            exit;
        }

    }else if($operation=="edit"){
        
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


        exit;
        
    }
    exit;
    

}else if($operation == "add"){

    $auth->email = filter_input(INPUT_POST,"email");

    if($auth->emailExists()){
        header("Location: ../index.php?p=addAccount&err=accountExist");
        exit;
    }else{

        $account->username = filter_input(INPUT_POST,"username") ;
        $account->email = filter_input(INPUT_POST,"email") ;
        
        // hash password
        $password=filter_input(INPUT_POST,"password");
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $account->password = $password_hash ;
        
        // upload avatar
        $errUpload = "";
        $file->operation = filter_input(INPUT_POST,"operation") ;
        
        if($_FILES['avatar']['size'] > 0){
            
            // set data for file uploading
            $file->filename = $_FILES['avatar']['name'] ;
            $file->inputFileName = $_FILES['avatar']['tmp_name'] ;
            $file->label = 'avatar_'.filter_input(INPUT_POST,"username") ;
            $file->path = "../uploads/avatar/" ;
            $file->origin = filter_input(INPUT_POST,"origin");

            if($file->uploadFile()){
                $account->avatar = $_FILES['avatar']['name'] ;
            }else{
                $errUpload = "&err=noAvatar" ;
                $account->avatar = "default.png" ;
            }
        }else{
            $account->avatar = "default.png" ;
        }

        if($account->insert(['username','email','password','avatar'])){

            $accountroles->role_id = filter_input(INPUT_POST,"role") ;
            $insertedId = "" ;
            $account->email = filter_input(INPUT_POST,"email") ;
            
            $stmt= $account->showAllWhere('id',['email']);
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $insertedId = $row['id'];
            }

            $accountroles->account_id = $insertedId ;

            // success, insert the role in accountsRoles table
            if($accountroles->insert(['account_id','role_id'])){
                
                //success
                header("Location: ../index.php?p=allAccounts&msg=accountSucc$errUpload");
                exit;

            }else{

                // failed, delete the user inserted
           
                if(!$errUpload){
                    unlink("../uploads/avatar/".$_FILES['avatar']['name']."");
                }               
                header("Location: ../index.php?p=allAccounts&err=accountFail");
                exit;
            }


        }else{

            // error, removing avatar if uploaded
            if(!$errUpload){
                unlink("../uploads/avatar/".$_FILES['avatar']['name']."");
            }
            header("Location: ../index.php?p=allAccounts&err=accountFail");
            exit;
        }

    }




}else{
    header("Location: ../index.php?p=allAccounts&msg=noPost");
    exit;
}