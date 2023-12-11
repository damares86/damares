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

    $cfa->id = filter_input(INPUT_GET,"idToDel");

    if($cfa->delete('id')){
        header("Location: ../index.php?p=allCollaboratori&msg=collabDel");
        exit;
    }else{
        header("Location: ../index.php?p=allCollaboratori&err=collabNoDel");
        exit;
    }

}

$operation = filter_input(INPUT_POST,"operation") ;

// check if there's an account to edit or add

//////////////////////////////////////////////////////////////////////////////////////////////////////////

if(filter_input(INPUT_POST,"idToMod")){
    
    $id = filter_input(INPUT_POST,"idToMod");

}else if($operation == "add"){

   

}else{
    header("Location: ../index.php?p=allAccounts&err=noPost");
    exit;
}