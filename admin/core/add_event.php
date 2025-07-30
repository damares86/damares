<?php

require __DIR__ . "/coreConfig.php";

header('Content-Type: application/json');

$title = $_POST['title'] ?? null;
$start = $_POST['start'] ?? null;
$end   = $_POST['end'] ?? null;
$url   = $_POST['url'] ?? null;
$color = $_POST['color'] ?? '#008db1';

if (!$title || !$start || !$end) {
    echo json_encode(["success" => false, "error" => "Campi obbligatori mancanti"]);
    exit;
}

try {
    $stmt = $db->prepare("INSERT INTO calendar_events (title, start, end, url, color) VALUES (:title, :start, :end, :url, :color)");
    $stmt->execute([
        ':title' => $title,
        ':start' => $start,
        ':end'   => $end,
        ':url'   => $url,
        ':color' => $color
    ]);

    echo json_encode(["success" => true, "id" => $db->lastInsertId()]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
