<?php
require __DIR__ . "/coreConfig.php";

$message_id = $_POST['message_id'] ?? null;

if (!$message_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing message_id']);
    exit;
}

$query = "UPDATE newsletter_messages SET status = 1 WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$message_id]);

echo json_encode(['success' => true]);
