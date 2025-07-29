<?php
require __DIR__ . "/coreConfig.php";

header('Content-Type: application/json');

$messageId = intval($_POST['message_id'] ?? 0);
$db = $database->getConnection();

$stmt = $db->prepare("
    SELECT ns.email 
    FROM newsletter_queue nq
    JOIN newsletter_subscribers ns ON nq.subscriber_id = ns.id
    WHERE nq.message_id = ? AND nq.status = 'failed'
");
$stmt->execute([$messageId]);
$emails = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode([
    'failed' => $emails
]);
