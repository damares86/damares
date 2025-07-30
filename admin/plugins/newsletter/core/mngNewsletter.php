<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

use Pelago\Emogrifier\CssInliner;

require __DIR__ . "/coreConfig.php";

if (filter_input(INPUT_GET, 'idToDel')) {

    $newsletter->table = 'newsletter_messages';
    $newsletter->id = filter_input(INPUT_GET, 'idToDel');

    if ($newsletter->delete('id')) {
        header("Location: ../index.php?p=allEmails&msg=emailDel");
        exit;
    } else {
        header("Location: ../index.php?p=allEmails&err=emailNoDel");
        exit;
    }
}

$operation = filter_input(INPUT_POST, 'operation');

if ($operation == 'clone') {

    $idToClone = filter_input(INPUT_POST, 'idToClone');

    $newsletter->table = 'newsletter_messages';
    $newsletter->id = $idToClone;

    $stmt = $newsletter->showAllWhere('id', ['id']);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($record);

    $newsletter->table = 'newsletter_messages';
    $newsletter->subject = filter_input(INPUT_POST, 'subject');
    $newsletter->body = $record['body'];

    if ($newsletter->insert(['subject', 'body'])) {
        header("Location: ../index.php?p=allEmails&msg=emailClone");
        exit;
    } else {
        header("Location: ../index.php?p=allEmails&err=emailNoClone");
        exit;
    }
} else if ($operation == 'add') {

    $newsletter->table = 'newsletter_messages';
    $newsletter->subject = filter_input(INPUT_POST, 'subject');

    // css inline conversion
    $body = filter_input(INPUT_POST, 'body');
    $converted = CssInliner::fromHtml($body)->inlineCss()->render();
    $newsletter->body = $converted;

    if ($newsletter->insert(['subject', 'body'])) {

        $newsletter->table = 'newsletter_messages';
        $stmt = $newsletter->showAll('id', 1, null, 'DESC');
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $row['id'];
        $newsletter->table = "newsletter_subscribers";
        $stmt1 = $newsletter->showAll('id');
        $error = 0;
        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $newsletter->table = "newsletter_queue";
            $newsletter->subscriber_id = $row1['id'];
            $newsletter->message_id = $id;

            if (!$newsletter->insert(['subscriber_id', 'message_id'])) {
                $error++;
            }
        }

        $err_queue = $error > 0 ? '&err=newsletterQueue' : '';
        header("Location: ../index.php?p=editEmail&idToMod=$id&msg=newsletterAdd");
        exit;
    } else {
        header("Location: ../index.php?p=allEmails&err=newsletterNoAdd");
        exit;
    }
} else if ($operation == 'edit') {

    $newsletter->table = 'newsletter_messages';
    $idToMod = filter_input(INPUT_POST, 'idToMod');
    $newsletter->id = $idToMod;
    $newsletter->subject = filter_input(INPUT_POST, 'subject');
    $newsletter->body = filter_input(INPUT_POST, 'body');

    if ($newsletter->update(['subject', 'body'], 'id')) {
        header("Location: ../index.php?p=editEmail&idToMod=$idToMod&msg=newsletterEdit");
        exit;
    } else {
        header("Location: ../index.php?p=editEmail&idToMod=$idToMod&err=newsletterNoEdit");
        exit;
    }
}
