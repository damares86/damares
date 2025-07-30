<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/newsletter_error.log');
error_reporting(E_ALL);
require __DIR__ . "/coreConfig.php";
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

$messageId = intval($_POST['message_id'] ?? 0);
$batchSize = intval($_POST['batch_size'] ?? 10);

if (!$messageId) {
    echo json_encode(['error' => $send_no_id]);
    exit;
}


// get settings
$newsletter->table = 'newsletter_settings';
$stmt = $newsletter->showAll('id');

$newsletter_settings = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    extract($row);
    $newsletter_settings[$row['name']] = $row['value'];
}

error_log("SMTP SETTINGS: " . print_r($newsletter_settings, true));


$phpmailer_log_path = __DIR__ . '/logs/phpmailer_debug.log';
$db = $database->getConnection();

// Recupera i prossimi N record "pending"
$query = "
    SELECT nq.id as queue_id, ns.email, ns.name, nm.subject, nm.body 
    FROM newsletter_queue nq
    JOIN newsletter_subscribers ns ON nq.subscriber_id = ns.id
    JOIN newsletter_messages nm ON nq.message_id = nm.id
    WHERE nq.message_id = :messageId AND nq.status = 'pending'
    LIMIT $batchSize
";

$stmt = $db->prepare($query);
$stmt->execute(['messageId' => $messageId]);

$queue = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sent = 0;
$failed = 0;

foreach ($queue as $row) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $newsletter_settings['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $newsletter_settings['email'];
        $mail->Password = $newsletter_settings['password'] ;
        $mail->SMTPSecure = $newsletter_settings['secure'];
        $mail->Port = $newsletter_settings['port'];

        $mail->setFrom($newsletter_settings['email'], $newsletter_settings['name']);
        $mail->addAddress($row['email'], $row['name']);
        $mail->Subject = $row['subject'];
        $mail->isHTML(true);
        $mail->Body = $row['body'];

        $mail->send();

        $db->prepare("UPDATE newsletter_queue SET status = 'sent', sent_at = NOW() WHERE id = ?")
            ->execute([$row['queue_id']]);
        $sent++;
    } catch (Exception $e) {
        $db->prepare("UPDATE newsletter_queue SET status = 'failed', error = ? WHERE id = ?")
            ->execute([$mail->ErrorInfo, $row['queue_id']]);
        $failed++;
    }
}

// Quanti ancora pending?
$remainingStmt = $db->prepare("SELECT COUNT(*) FROM newsletter_queue WHERE message_id = ? AND status = 'pending'");
$remainingStmt->execute([$messageId]);
$remaining = $remainingStmt->fetchColumn();

echo json_encode([
    'sent' => $sent,
    'failed' => $failed,
    'remaining' => $remaining
]);
