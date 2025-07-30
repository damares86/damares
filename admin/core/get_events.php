<?php

require __DIR__ . "/coreConfig.php";

header('Content-Type: application/json');

try {
    $stmt = $db->query("SELECT id, title, start, end, url, color FROM calendar_events");
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($events);
} catch (PDOException $e) {
    echo json_encode([]);
}
