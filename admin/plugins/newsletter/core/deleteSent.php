<?php
require __DIR__ . "/coreConfig.php";
$message_id = $_POST['message_id'] ?? null;

if (!$message_id) {
    http_response_code(400);
    echo json_encode(['error' => $send_no_id]);
    exit;
}

$query = "DELETE FROM newsletter_queue WHERE message_id = ? AND status = 'sent'";
$stmt = $db->prepare($query);
$stmt->execute([$message_id]);

echo json_encode(['deleted' => $stmt->rowCount()]);
