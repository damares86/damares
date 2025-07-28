<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

require __DIR__ . "/coreConfig.php";
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$messageId = intval($_POST['message_id']);

// 1. Recupera tutti i subscriber confermati
$newsletter->table = "newsletter_subscribers" ;
$stmt = $newsletter->showAll('id');
$subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$db = $database->getConnection();

// 2. Inserisce nella coda solo se non già esistono (grazie alla UNIQUE)

$insertStmt = $db->prepare("INSERT IGNORE INTO newsletter_queue (message_id, subscriber_id) VALUES (?, ?)");
foreach ($subscribers as $subscriber) {
    $insertStmt->execute([$messageId, $subscriber['id']]);
}

// 3. Recupera i record da inviare
$queueStmt = $db->prepare("SELECT nq.id as queue_id, ns.email, ns.name, nm.subject, nm.body 
    FROM newsletter_queue nq
    JOIN newsletter_subscribers ns ON nq.subscriber_id = ns.id
    JOIN newsletter_messages nm ON nq.message_id = nm.id
    WHERE nq.message_id = ? AND nq.status = 'pending'");
$queueStmt->execute([$messageId]);
$queue = $queueStmt->fetchAll(PDO::FETCH_ASSOC);

$results = [];

foreach ($queue as $row) {
    $mail = new PHPMailer(true);
 
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.netsons.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@dmweblab.com';
        $mail->Password = 'Salomon-86';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('noreply@dmweblab.com', 'Newsletter');
        $mail->addAddress($row['email'], $row['name']);
        $mail->Subject = $row['subject'];
        $mail->isHTML(true);
        $mail->Body = $row['body'];

        $mail->send();

        $db->prepare("UPDATE newsletter_queue SET status = 'sent', sent_at = NOW() WHERE id = ?")
            ->execute([$row['queue_id']]);
        $results[] = ['email' => $row['email'], 'status' => 'sent'];

    } catch (Exception $e) {
        $db->prepare("UPDATE newsletter_queue SET status = 'failed', error = ? WHERE id = ?")
            ->execute([$mail->ErrorInfo, $row['queue_id']]);
        $results[] = ['email' => $row['email'], 'status' => 'failed', 'error' => $mail->ErrorInfo];
    }
}

// 4. Elimina i record "sent"
$db->prepare("DELETE FROM newsletter_queue WHERE status = 'sent' AND message_id = ?")
    ->execute([$messageId]);

// 5. Ritorna JSON con gli errori
$errors = array_filter($results, fn($r) => $r['status'] === 'failed');
echo json_encode([
    'status' => 'done',
    'errors' => $errors
]);
