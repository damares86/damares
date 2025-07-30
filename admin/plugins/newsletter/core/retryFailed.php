<?php
require __DIR__ . "/coreConfig.php";
$message_id = $_POST['message_id'] ?? null;

if (!$message_id) {
    http_response_code(400);
    echo json_encode(['error' => $send_no_id]);
    exit;
}

$update = "UPDATE newsletter_queue SET status = 'pending' WHERE message_id = ? AND status = 'failed'";
$stmt = $db->prepare($update);
$stmt->execute([$message_id]);

$count = $db->prepare("SELECT COUNT(*) FROM newsletter_queue WHERE message_id = ? AND status = 'pending'");
$count->execute([$message_id]);
$total = $count->fetchColumn();

echo json_encode(['total' => (int)$total]);
