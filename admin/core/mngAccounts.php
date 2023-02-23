<?php

require __DIR__."/coreConfig.php";

// check if there's an account to delete

if(filter_input(INPUT_GET,"idToDel")){

    echo "delete" ;

}


// check if there's an account to edit or add

if(filter_input(INPUT_POST,"idToMod")){

    echo "edit" ;

}else if(filter_input(INPUT_POST,"add")){

    echo "add" ;

}else{
    header("Location: ../index.php?p=allAccounts&msg=noPost");
    exit;
}