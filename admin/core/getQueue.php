<?php
require __DIR__ . "/coreConfig.php";
$messageId = intval($_POST['message_id']);

$stmt = $db->prepare("SELECT id as queue_id FROM newsletter_queue WHERE message_id = ? AND status = 'pending'");
$stmt->execute([$messageId]);
$queue = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($queue);
