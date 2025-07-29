<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################
ini_set('display_errors', 0); // Non mostrare a schermo
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/newsletter_error.log');
error_reporting(E_ALL);

$messageId = intval($_POST['message_id']);
error_log("Ricevuto messageId: $messageId");


require __DIR__ . "/coreConfig.php";
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// get settings
$newsletter->table = 'newsletter_settings';
$stmt = $newsletter->showAll('id');

$newsletter_settings = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    extract($row);
    $newsletter_settings[$row['name']] = $row['value'];
}




// 1. Recupera tutti i subscriber confermati
$newsletter->table = "newsletter_subscribers";
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

if (empty($queue)) {
    file_put_contents($phpmailer_log_path, "[" . date('Y-m-d H:i:s') . "] Nessun record da inviare (messageId: $messageId)\n", FILE_APPEND);
}


$results = [];
$start = microtime(true);
$phpmailer_log_path = __DIR__ . '/logs/phpmailer_debug.log';
foreach ($queue as $row) {
    $mail = new PHPMailer(true);
    // File di log dedicato per PHPMailer
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

        // 🔍 Debug SMTP
        $mail->SMTPDebug = 3;
        $mail->Debugoutput = function ($str, $level) use ($phpmailer_log_path) {
            file_put_contents($phpmailer_log_path, "[" . date('Y-m-d H:i:s') . "] SMTP DEBUG [$level]: $str\n", FILE_APPEND);
        };


        $mail->send(); // disattivato per stress test
        //usleep(10000); // simula ritardo invio (10ms)
        file_put_contents($phpmailer_log_path, "[" . date('Y-m-d H:i:s') . "] Email inviata a: {$row['email']}\n", FILE_APPEND);

        $db->prepare("UPDATE newsletter_queue SET status = 'sent', sent_at = NOW() WHERE id = ?")
            ->execute([$row['queue_id']]);
        $results[] = ['email' => $row['email'], 'status' => 'sent'];
    } catch (Exception $e) {
        file_put_contents($phpmailer_log_path, "[" . date('Y-m-d H:i:s') . "] ERRORE invio a: {$row['email']} - " . $mail->ErrorInfo . "\n", FILE_APPEND);

        $db->prepare("UPDATE newsletter_queue SET status = 'failed', error = ? WHERE id = ?")
            ->execute([$mail->ErrorInfo, $row['queue_id']]);
        $results[] = ['email' => $row['email'], 'status' => 'failed', 'error' => $mail->ErrorInfo];
    }
}

// 4. Elimina i record "sent"
$db->prepare("DELETE FROM newsletter_queue WHERE status = 'sent' AND message_id = ?")
    ->execute([$messageId]);
$duration = microtime(true) - $start;
file_put_contents($phpmailer_log_path, "Tempo totale invio: {$duration} secondi", FILE_APPEND);
// 5. Ritorna JSON con gli errori
$errors = array_filter($results, fn($r) => $r['status'] === 'failed');
file_put_contents($phpmailer_log_path, "[" . date('Y-m-d H:i:s') . "] Invio completato. Risultati: " . json_encode($results) . "\n", FILE_APPEND);

echo json_encode([
    'status' => 'done',
    'errors' => $errors
]);
