<?php
require __DIR__ . "/coreConfig.php";

$message_id = intval($_POST['message_id']);

$newsletter->table = "newsletter_subscribers";
$stmt = $newsletter->showAll('id');
$subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$db = $database->getConnection();
$insertStmt = $db->prepare("INSERT IGNORE INTO newsletter_queue (message_id, subscriber_id) VALUES (?, ?)");

foreach ($subscribers as $subscriber) {
    $insertStmt->execute([$message_id, $subscriber['id']]);
}

$stmt = $db->prepare("SELECT COUNT(*) FROM newsletter_queue WHERE message_id = ?");
$stmt->execute([$message_id]);
$total = $stmt->fetchColumn();

echo json_encode(['id' => $message_id,'success' => true, 'total' => $total, 'status' => 'ok']);
