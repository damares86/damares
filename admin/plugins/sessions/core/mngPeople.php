<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__."/coreConfig.php";

// check if there's an account to delete

if(filter_input(INPUT_GET,"idToDel")){

    $session->table = "people";

    $session->id = filter_input(INPUT_GET,"idToDel");

    $stmt = $session->showAllWhere('id',['id']);
    $avatar="";
    foreach($stmt as $row){
        $avatar = $row['avatar'];
    }

    if($session->delete('id')){

        $session->table = "people_cat_id";
        $session->people_id = filter_input(INPUT_GET,"idToDel");
        $session->delete('people_id');

        if($_POST['avatar_orig']!="default.png"){
            unlink("../uploads/avatar/$avatar");
        }
        
        header("Location: ../index.php?p=allPeople&msg=peopleDel");
        exit;
    }else{
        header("Location: ../index.php?p=allPeople&err=peopleNoDel");
        exit;
    }

}

$operation = filter_input(INPUT_POST,"operation") ;


if(filter_input(INPUT_POST,"idToMod")){
    
    $peopleId = filter_input(INPUT_POST,"idToMod");
    $session->id = $peopleId;
    $session->table = "people" ;
    
        // $session->id = $id ;
        $stmt = $session->showAllWhere('id',['id']);

        foreach($stmt as $item){
            $old_name=$item['people_name'];
        }
        $name = filter_input(INPUT_POST,"name");
        $session->people_name = $name;
        
        if($session->itemExists('people_name') && $name!=$old_name){
            header("Location: ../index.php?p=editPeople&err=peopleExist");
            exit;   
        }else{

        $session->people_name = filter_input(INPUT_POST,"name") ;
        $session->description = filter_input(INPUT_POST,"description") ;

        require "peopleDetails.php";

        $details_arr = [] ;
        $details_opt_arr = [] ;

        foreach($people_details as $item){
            $details_arr[] = array("$item" => "".$_POST[$item]."");
        }

        if($details_arr){
            $details_str = serialize($details_arr);
            $session->details = $details_str;
        }

        foreach($speople_details_opt as $item){
            $details_opt_arr[] = array("$item" => "".$_POST[$item]."");
        }

        if($details_opt_arr){
            $details_opt_str = serialize($details_opt_arr);
            $session->details_opt = $details_opt_str ;
        }

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
                $session->avatar = $_FILES['avatar']['name'] ;
                
                if($_POST['avatar_orig']!="default.png"){
                    unlink("../uploads/avatar/".filter_input(INPUT_POST,"avatar_orig"));
                }
            }else{
                header("Location: ../index.php?p=allPeople&err=noAvatarUpload");
                exit;
            }            
        }else{
            $session->avatar = filter_input(INPUT_POST,"avatar_orig");
        }

        if($session->update(['people_name','avatar','description','details','details_opt'],'id')){
            
            $catId = filter_input(INPUT_POST,"people_cat");
            // get the role id
            $session->table = "people_cat_id";
            $session->people_id = $peopleId ;
            $stmt = $session->showAllWhere('id',['people_id']);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);

            if($catId!=$row['cat_id']){
                $session->table = "people_cat_id";
                $session->people_id = $peopleId ;
                $session->cat_id = $catId;
                $session->update(['cat_id'],'people_id');
            }

            header("Location: ../index.php?p=editPeople&idToMod=$id&msg=peopleEdit");
            exit;
        }else{
            header("Location: ../index.php?p=editPeople&idToMod=$id&err=peopleNoEdit");
            exit;
        }        
    }

}else if($operation == "add"){
    
    $session->table = "people";
    $session->people_name = filter_input(INPUT_POST,"name");
    
    if($session->itemExists('people_name')){
        header("Location: ../index.php?p=addPeople&err=peopleExist");
        exit;
    }else{
        
        $session->people_name = filter_input(INPUT_POST,"name") ;
        $session->description = filter_input(INPUT_POST,"description") ;
        $people_cat_id = filter_input(INPUT_POST,"people_cat") ;
        


        require "peopleDetails.php";

        $details_arr = [] ;
        $details_opt_arr = [] ;

        foreach($people_details as $item){
            $details_arr[] = array("$item" => "".$_POST[$item]."");
        }

        $details_str = serialize($details_arr);
        $session->details = $details_str;

        foreach($people_details_opt as $item){
            $details_opt_arr[] = array("$item" => "".$_POST[$item]."");
        }
        $details_opt_str = serialize($details_opt_arr);
        $session->details_opt = $details_opt_str ;

        // upload avatar
        $errUpload = "";
        $file->operation = filter_input(INPUT_POST,"operation") ;
        
        if($_FILES['avatar']['size'] > 0){
            
            // set data for file uploading
            $file->filename = $_FILES['avatar']['name'] ;
            $file->inputFileName = $_FILES['avatar']['tmp_name'] ;
            $name = filter_input(INPUT_POST,"name") ;
            $name = str_replace(" ","_",$name);
            $name = strtolower($name);
            $file->label = 'avatar_'.$name ;
            $file->path = "../uploads/avatar/" ;
            $file->origin = filter_input(INPUT_POST,"origin");

            if($file->uploadFile()){
                $session->avatar = $_FILES['avatar']['name'] ;
            }else{
                $errUpload = "&err=noAvatarUpload" ;
                $session->avatar = "default.png" ;
            }
        }else{
            $session->avatar = "default.png" ;
        }

        if($session->insert(['people_name','avatar','description','details','details_opt'])){

                // get the role id
                $session->table = "people_cat";
                $session->id = $people_cat_id ;
                $stmt = $session->showAllWhere('id',['id']);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                extract($row);

                $session->cat_id = $row['id'];

                //get the id of inserted people
                $session->table = "people";
                $session->people_name = filter_input(INPUT_POST,"name") ;
                $stmt1 = $session->showAllWhere('id',['people_name']);
                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                extract($row1);

                $session->people_id = $row1['id'];

                // insert into pivot table
                $session->table = "people_cat_id";
                
                if($session->insert(['people_id','cat_id'])){

                    //success
                    header("Location: ../index.php?p=allPeople&msg=peopleSucc$errUpload");
                    exit;

                }else{
                    
                    header("Location: ../index.php?p=allPeople&msg=peopleSucc&err=peopleRoleFail$errUpload");
                    exit;

                }

            }else{

                // failed, delete the user inserted
           
                if(!$errUpload){
                    unlink("../uploads/avatar/".$_FILES['avatar']['name']."");
                }               
                header("Location: ../index.php?p=allPeople&err=peopleFail");
                exit;
            }

    }




}else{
    header("Location: ../index.php?p=allPeople&err=noPost");
    exit;
}