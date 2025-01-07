<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__ . "/coreConfig.php";

// check if there's an account to delete

if (filter_input(INPUT_GET, "idToDel")) {

    // ELIMINA FILE DELL'ARCHIVIO

    // $idToDel = filter_input(INPUT_GET,"idToDel");
    $accountroles->account_id = filter_input(INPUT_GET, "idToDel");
    $accountroles->delete('account_id');
    $account->table = "accounts";

    $account->id = filter_input(INPUT_GET, "idToDel");

    if ($account->delete('id')) {
        header("Location: ../index.php?p=allAccounts&msg=accountDel");
        exit;
    } else {
        header("Location: ../index.php?p=allAccounts&err=accountNoDel");
        exit;
    }
}else if (filter_input(INPUT_GET, "idYearToDel")){

    // ELIMINA ANNO
    $idToDel = filter_input(INPUT_GET,'idYearToDel') ;
    $archive->table = "archive_files" ;
    $archive->archive_year_id = $idToDel ;

    if(!$archive->itemExists('archive_year_id')){

        $archive->table = "archive_years" ;
        $archive->id = $idToDel ;

        if($archive->delete('id')){
            header("Location:../index.php?p=allArchiveYear&msg=yearDelSucc");
            exit;
        }else{
            header("Location:../index.php?p=allArchiveYear&err=yearDleFail");
            exit;
        }

    }

}

$operation = filter_input(INPUT_POST, "operation");

// check if there's an account to edit or add

if($operation == "addYear") {

    $archive->table = 'archive_years' ;
    $archive->year = filter_input(INPUT_POST,'year') ;

    if(!$archive->itemExists('year')){

        $archive->table = 'archive_years' ;
        $archive->year = filter_input(INPUT_POST,'year') ;
        if($archive->insert(['year'])){
            header("Location:../index.php?p=allArchiveYear&msg=yearAddSucc");
            exit;
        }else{
            header("Location:../index.php?p=allArchiveYear&err=yearAddFail");
            exit;
        }

    }else{
        header("Location:../index.php?p=allArchiveYear&err=yearExists");
        exit;
    }
    

}else if($operation == "add"){

}else if($operation == "editYear"){

    $archive->table = 'archive_years' ;
    $archive->year = filter_input(INPUT_POST,'year') ;
    $idToMod =  filter_input(INPUT_POST,'idToMod') ;
    $archive->id = $idToMod ;

    if($archive->update(['year'],'id')){
        header("Location:../index.php?p=editArchiveYear&idToMod=$idToMod&msg=yearEditSucc");
        exit;
    }else{
        header("Location:../index.php?p=editArchiveYear&idToMod=$idToMod&err=yearEditFail");
        exit;
    }


}else if($operation == "edit"){

} else {
    header("Location: ../index.php?p=allArchive&err=noPost");
    exit;
}
