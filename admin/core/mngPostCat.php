<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__ . "/coreConfig.php";

// check if there's a customer to delete

if (filter_input(INPUT_GET, "idToDel")) {

    $idToDel = filter_input(INPUT_GET, "idToDel");
    $post->id = $idToDel;

    $post->table = 'post';
    $stmt = $post->showAll('id');

    $num = 0;

    while ($row  = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $catArr = explode(',', $row['category_id']);
        if (in_array($idToDel, $catArr)) {
            $num++;
        }
    }

    $post->table = 'post_categories';
    $post->id = $idToDel;
    $stmt1 = $post->showAllWhere('id', ['id']);
    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    extract($row1);
    if ($row1['assign_page'] != NULL) {
        header("Location: ../index.php?p=allPostsCat&err=postCatPage");
        exit;
    }

    if ($num > 0) {
        header("Location: ../index.php?p=allPostsCat&err=postCatCount");
        exit;
    } else {

        $post->table = 'post_categories';

        if ($post->delete('id')) {
            header("Location: ../index.php?p=allPostsCat&msg=postCatDel");
            exit;
        } else {
            header("Location: ../index.php?p=allPostsCat&err=postCatNoDel");
            exit;
        }
    }
}

$operation = filter_input(INPUT_POST, "operation");

// check if there's a customer to edit or add

if ($operation == "edit") {

    $idToMod = filter_input(INPUT_POST, "idToMod");

    $url_tablePage = filter_input(INPUT_POST, 'url_tablePage');
    $url_pageName = filter_input(INPUT_POST, 'url_pageName');

    $url_data = "&tablePage=$url_tablePage&pageName=$url_pageName";

    $post->id = $idToMod;
    $post->category_name = filter_input(INPUT_POST, 'category_name');
    filter_input(INPUT_POST, 'assign_page') == 'none' ? $post->assign_page = NULL : $post->assign_page = filter_input(INPUT_POST, 'assign_page');
    $post->table = 'post_categories';

    if ($post->update(['category_name', 'assign_page'], 'id')) {
        //success
        header("Location: ../index.php?p=editPostCat&idToMod=$idToMod&msg=postCatEditSucc$url_data");
        exit;
    } else {

        // fail
        header("Location: ../index.php?p=editPostCat&idToMod=$idToMod&&err=postCatEditFail$url_data");
        exit;
    }
} else if ($operation == "add") {

    $post->category_name = filter_input(INPUT_POST, 'category_name');
    filter_input(INPUT_POST, 'assign_page') == 'none' ? NULL : $post->assign_page = filter_input(INPUT_POST, 'assign_page');
    $post->table = 'post_categories';

    if ($post->insert(['category_name', 'assign_page'])) {

        //success
        header("Location: ../index.php?p=allPostsCat&msg=postCatAddSucc");
        exit;
    } else {

        // fail
        header("Location: ../index.php?p=allPostsCat&err=postCatAddFail");
        exit;
    }
} else {
    header("Location: ../index.php?p=allPostsCat&err=noPost");
    exit;
}
