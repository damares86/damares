<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__ . "/coreConfig.php";
header('Content-Type: application/json');

if (filter_input(INPUT_GET, "idToDel")) {

    $id = $_POST['id'] ?? 0;
    $id = intval($id);

    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid ID"]);
        exit;
    }

    $stmt = $db->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true]);
        header("Location: ../index.php?p=calendar&msg=delEventOk");
        exit;
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Delete failed"]);
        header("Location: ../index.php?p=calendar&err=delEventOk");
        exit;
    }
}

$operation = filter_input(INPUT_POST, "operation");

if ($operation == "add") {


    // Ricevo dati POST
    $title = $_POST['title'] ?? '';
    $start = $_POST['start'] ?? '';
    $end = $_POST['end'] ?? '';
    $url = $_POST['url'] ?? null;
    $color = $_POST['color'] ?? null;

    if (!$title || !$start || !$end) {
        http_response_code(400);
        echo json_encode(["error" => "Missing required fields"]);
        exit;
    }

    $stmt = $db->prepare("INSERT INTO events (title, start, end, url, color) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $start, $end, $url, $color);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true, "id" => $stmt->insert_id]);
        header("Location: ../index.php?p=calendar&msg=addEventOk");
        exit;
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Insert failed"]);
        header("Location: ../index.php?p=calendar&err=addEventKo");
        exit;
    }
} else if ($operation == "edit") {

    $url_tablePage = filter_input(INPUT_POST, 'url_tablePage');
    $url_pageName = filter_input(INPUT_POST, 'url_pageName');

    $url_data = "&tablePage=$url_tablePage&pageName=$url_pageName";

    $calendar->id = filter_input(INPUT_POST, 'idToMod');
    $calendar->cat_name = filter_input(INPUT_POST, "cat_name");
    $calendar->cat_color = filter_input(INPUT_POST, "cat_color");

    if ($calendar->update(['cat_name', 'cat_color'], 'id')) {
        header("Location: ../index.php?p=allCalendars&msg=editCalOk$url_data");
        exit;
    } else {
        header("Location: ../index.php?p=allCalendars&err=editCalFail$url_data");
        exit;
    }
}
