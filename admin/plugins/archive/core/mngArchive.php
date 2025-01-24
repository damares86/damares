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

    $archive->table = 'archive_files';
    $archive->id = filter_input(INPUT_GET, "idToDel");

    if ($archive->delete('id')) {
        header("Location: ../index.php?p=allArchive&msg=archiveFileDel");
        exit;
    } else {
        header("Location: ../index.php?p=allArchive&err=archiveFileNoDel");
        exit;
    }
} else if (filter_input(INPUT_GET, "idYearToDel")) {

    // ELIMINA ANNO
    $idToDel = filter_input(INPUT_GET, 'idYearToDel');
    $archive->table = "archive_files";
    $archive->archive_year_id = $idToDel;

    if (!$archive->itemExists('archive_year_id')) {

        $archive->table = "archive_years";
        $archive->id = $idToDel;

        if ($archive->delete('id')) {
            header("Location:../index.php?p=allArchiveYear&msg=yearDelSucc");
            exit;
        } else {
            header("Location:../index.php?p=allArchiveYear&err=yearDelFail");
            exit;
        }
    }else {
        header("Location:../index.php?p=allArchiveYear&err=yearArchiveExists");
        exit;
    }
}

$operation = filter_input(INPUT_POST, "operation");

// check if there's an account to edit or add

if ($operation == "addYear") {

    $archive->table = 'archive_years';
    $archive->year = filter_input(INPUT_POST, 'year');

    if (!$archive->itemExists('year')) {

        $archive->table = 'archive_years';
        $archive->year = filter_input(INPUT_POST, 'year');
        if ($archive->insert(['year'])) {
            header("Location:../index.php?p=allArchiveYear&msg=yearAddSucc");
            exit;
        } else {
            header("Location:../index.php?p=allArchiveYear&err=yearAddFail");
            exit;
        }
    } else {
        header("Location:../index.php?p=allArchiveYear&err=yearExists");
        exit;
    }
} else if ($operation == "add") {


    if ($_FILES['myfile']['size'] > 0) {
        $archive->file_name = $_FILES['myfile']['name'];
        $filename = $_FILES['myfile']['name'];

        if ($file->countFile() > 0) {

            header("Location: ../index.php?p=allArchive&err=fileExists$url_data");
            exit;
        }
        // set data for file uploading
        $archive->table = 'archive_files';
        $archive->inputFileName = $_FILES['myfile']['tmp_name'];
        $archive->title = filter_input(INPUT_POST, "title");
        $archive->archive_year_id = filter_input(INPUT_POST, "year_id");
        if (filter_input(INPUT_POST, "month")) {
            $archive->month = filter_input(INPUT_POST, "month");
        } else {
            $archive->month = NULL;
        }

        $archive->path = "../../uploads/archive/";
        $archive->origin = filter_input(INPUT_POST, "origin");

        $archive->operation = "add";

        if ($archive->uploadFile()) {
            //success
            header("Location: ../index.php?p=allArchive&msg=fileSucc$url_data");
            exit;
        } else {
            header("Location: ../index.php?p=allArchive&err=fileFail$url_data");
            exit;
        }
    } else {
        header("Location: ../index.php?p=allArchive&err=fileErr$url_data");
        exit;
    }
} else if ($operation == "editYear") {

    $archive->table = 'archive_years';
    $archive->year = filter_input(INPUT_POST, 'year');
    $idToMod =  filter_input(INPUT_POST, 'idToMod');
    $archive->id = $idToMod;

    if ($archive->update(['year'], 'id')) {
        header("Location:../index.php?p=editArchiveYear&idToMod=$idToMod&msg=yearEditSucc");
        exit;
    } else {
        header("Location:../index.php?p=editArchiveYear&idToMod=$idToMod&err=yearEditFail");
        exit;
    }
} else if ($operation == "edit") {

    $idToMod = filter_input(INPUT_POST, "idToMod");
    
    $archive->table = 'archive_files';
    $archive->id = $idToMod;
    $archive->title = filter_input(INPUT_POST, "title");
    $archive->archive_year_id = filter_input(INPUT_POST, "year_id");
    if (filter_input(INPUT_POST, "month")) {
        $archive->month = filter_input(INPUT_POST, "month");
    } else {
        $archive->month = NULL;
    }
    
    $url_tablePage = filter_input(INPUT_POST, 'url_tablePage');
    $url_pageName = filter_input(INPUT_POST, 'url_pageName');

    $url_data = "&tablePage=$url_tablePage&pageName=$url_pageName";

    if ($_FILES['myfile']['size'] > 0) {

        $archive->file_name = $_FILES['myfile']['name'];
        $filename = $_FILES['myfile']['name'];

        if ($file->countFile() > 0) {

            header("Location: ../index.php?p=allArchive&err=fileExists$url_data");
            exit;
        }
        // set data for file uploading
        $archive->table = 'archive_files';
        $archive->inputFileName = $_FILES['myfile']['tmp_name'];

        $archive->path = "../../uploads/archive/";
        $archive->origin = filter_input(INPUT_POST, "origin");

        $archive->operation = "edit";

        if ($archive->uploadFile()) {
            //success
            header("Location: ../index.php?p=allArchive&msg=fileSucc$url_data");
            exit;
        } else {
            header("Location: ../index.php?p=allArchive&err=fileFail$url_data");
            exit;
        }
    } else {
        // update solo db
        if ($archive->update(['title', 'archive_year_id', 'month'], 'id')) {
            header("Location: ../index.php?p=allArchive&msg=archiveEditSucc$url_data");
            exit;
        } else {
            header("Location: ../index.php?p=allArchive&err=archiveEditErr$url_data");
            exit;
        }
    }
} else {


    header("Location: ../index.php?p=allArchive&err=noPost");
    exit;
}
