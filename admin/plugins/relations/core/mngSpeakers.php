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

    $relation->table = "speakers";

    $relation->id = filter_input(INPUT_GET,"idToDel");

    $stmt = $relation->showAllWhere('id',['id']);
    $avatar="";
    foreach($stmt as $row){
        $avatar = $row['avatar'];
    }

    if($relation->delete('id')){
        unlink("../uploads/avatar/$avatar");
        header("Location: ../index.php?p=allSpeakers&msg=speakerDel");
        exit;
    }else{
        header("Location: ../index.php?p=allSpeakers&err=speakerNoDel");
        exit;
    }

}

$operation = filter_input(INPUT_POST,"operation") ;

// check if there's an account to edit or add

if(filter_input(INPUT_POST,"idToMod")){
    
    $id = filter_input(INPUT_POST,"idToMod");
    $relation->id = $id;
    $relation->table = "speakers" ;
    
        // $relation->id = $id ;
        $stmt = $relation->showAllWhere('id',['id']);
        
        foreach($stmt as $item){
            $old_name=$item['speakers_name'];
        }
        $name = filter_input(INPUT_POST,"name");
    
        $relation->speakers_name = $name;
       
        if($relation->itemExists('speakers_name') && $name!=$old_name){
            header("Location: ../index.php?p=editSpeaker&err=speakerExist");
            exit;   
        }else{
                    
        $relation->speakers_name = filter_input(INPUT_POST,"name") ;
        $relation->description = filter_input(INPUT_POST,"description") ;

        require "speakersDetails.php";

        $details_arr = [] ;
        $details_opt_arr = [] ;

        foreach($speakers_details as $item){
            $details_arr[] = array("$item" => "".$_POST[$item]."");
        }

        if($details_arr){
            $details_str = serialize($details_arr);
            $speakers->details = $details_str;
        }

        foreach($speakers_details_opt as $item){
            $details_opt_arr[] = array("$item" => "".$_POST[$item]."");
        }

        if($details_opt_arr){
            $details_opt_str = serialize($details_opt_arr);
            $speakers->details_opt = $details_opt_str ;
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
                $relation->avatar = $_FILES['avatar']['name'] ;
                
                if($_POST['avatar_orig']!="default.png"){
                    unlink("../uploads/avatar/".filter_input(INPUT_POST,"avatar_orig"));
                }
            }else{
                header("Location: ../index.php?p=allSpeakers&err=noAvatarUpload");
                exit;
            }            
        }else{
            $relation->avatar = filter_input(INPUT_POST,"avatar_orig");
        }


        if($relation->update(['speakers_name','avatar','description','details','details_opt'],'id')){
            header("Location: ../index.php?p=editSpeaker&idToMod=$id&msg=speakerEdit");
            exit;
        }else{
            header("Location: ../index.php?p=editSpeaker&idToMod=$id&err=speakerNoEdit");
            exit;
        }        
    }

}else if($operation == "add"){
    
    $relation->table = "speakers";
    $relation->speakers_name = filter_input(INPUT_POST,"name");

    if($relation->itemExists('speakers_name')){
        header("Location: ../index.php?p=addSpeaker&err=speakerExist");
        exit;
    }else{

        $relation->speakers_name = filter_input(INPUT_POST,"name") ;
        $relation->description = filter_input(INPUT_POST,"description") ;

        require "speakersDetails.php";

        $details_arr = [] ;
        $details_opt_arr = [] ;

        foreach($speakers_details as $item){
            $details_arr[] = array("$item" => "".$_POST[$item]."");
        }

        $details_str = serialize($details_arr);
        $relation->details = $details_str;

        foreach($speakers_details_opt as $item){
            $details_opt_arr[] = array("$item" => "".$_POST[$item]."");
        }
        $details_opt_str = serialize($details_opt_arr);
        $relation->details_opt = $details_opt_str ;

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
                $relation->avatar = $_FILES['avatar']['name'] ;
            }else{
                $errUpload = "&err=noAvatarUpload" ;
                $relation->avatar = "default.png" ;
            }
        }else{
            $relation->avatar = "default.png" ;
        }

        if($relation->insert(['speakers_name','avatar','description','details','details_opt'])){

                //success
                header("Location: ../index.php?p=allSpeakers&msg=speakersSucc$errUpload");
                exit;

            }else{

                // failed, delete the user inserted
           
                if(!$errUpload){
                    unlink("../uploads/avatar/".$_FILES['avatar']['name']."");
                }               
                header("Location: ../index.php?p=allSpeakers&err=speakersFail");
                exit;
            }

    }




}else{
    header("Location: ../index.php?p=allSpeakers&err=noPost");
    exit;
}