<?php
// core/sendOne.php
require __DIR__ . "/coreConfig.php";
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$queue_id = intval($_POST['queue_id']);

$db = $database->getConnection();

$stmt = $db->prepare("SELECT nq.id as queue_id, ns.email, ns.name, nm.subject, nm.body 
    FROM newsletter_queue nq
    JOIN newsletter_subscribers ns ON nq.subscriber_id = ns.id
    JOIN newsletter_messages nm ON nq.message_id = nm.id
    WHERE nq.id = ? AND nq.status = 'pending'");
$stmt->execute([$queue_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo json_encode(['status' => 'skip']);
    exit;
}

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'mail.dmweblab.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreply@dmweblab.com';
    $mail->Password = 'Salomon-86';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('noreply@dmweblab.com', 'Newsletter');
    $mail->addAddress($row['email'], $row['name']);
    $mail->Subject = $row['subject'];
    $mail->isHTML(true);
    $mail->Body = $row['body'];

    $mail->send();

    $db->prepare("UPDATE newsletter_queue SET status = 'sent', sent_at = NOW() WHERE id = ?")->execute([$queue_id]);

    echo json_encode(['status' => 'sent', 'email' => $row['email']]);
} catch (Exception $e) {
    $db->prepare("UPDATE newsletter_queue SET status = 'failed', error = ? WHERE id = ?")
        ->execute([$mail->ErrorInfo, $queue_id]);

    echo json_encode(['status' => 'failed', 'email' => $row['email'], 'error' => $mail->ErrorInfo]);
}

