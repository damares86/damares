<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__ . "/coreConfig.php";

if (filter_input(INPUT_GET, "idToDel")) {

    $newsletter->table = "newsletter_subscribers";
    $newsletter->id = filter_input(INPUT_GET, "idToDel");

    if ($newsletter->delete('id')) {
        header("Location:../index.php?p=allSubscribers&msg=subscriberDel");
        exit;
    } else {
        header("Location:../index.php?p=allSubscribers&err=subscriberNoDel");
        exit;
    }
}

$operation = filter_input(INPUT_POST, 'operation');

if ($operation == 'add') {

    $goback = filter_input(INPUT_POST, 'backend') ? '../index.php?p=allSubscribers' : '../../index.php?p=1';


    if (isset($_POST['recaptcha_response'])) {
        $stmt = $verify->showAll('id');
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $secret = $row['secret'];
        // Costruire il POST request:      

        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = $secret;
        $recaptcha_response = $_POST['recaptcha_response'];

        // Istanziare e decodificare la richiesta POST:      

        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);

        // Azioni da compiere basate sul punteggio ottenuto:      

        if (!$recaptcha->score >= 0.5) {
            header("Location:$goback&err=errRecaptcha");
            exit;
        }
    }

    $newsletter->name = filter_input(INPUT_POST, "name");
    $newsletter->email = filter_input(INPUT_POST, "email");
    $data = ['name', 'email'];
    if (filter_input(INPUT_POST, 'backend')) {
        $newsletter->confirmed = 1;
        $data[] = 'confirmed';
    }
    $newsletter->table = "newsletter_subscribers";


    if ($newsletter->insert($data)) {

        $newsletter->table = "newsletter_settings";
        $newsletter->name = "confirmation";
        $stmt = $newsletter->showAllWhere('id', ['name']);
        $confirmation = $stmt->fetch(PDO::FETCH_ASSOC);

        $confirm_message = '';
        if ($confirmation['value'] == 1 && !filter_input(INPUT_POST, 'backend')) {
            $confirm_message = '&err=noConfirm';
        }

        header("Location: $goback&msg=subscriberSucc$confirm_message");
        exit;
    } else {
        header("Location: $goback&err=subscriberErr");
        exit;
    }
} else if ($operation == 'edit') {

    $newsletter->name = filter_input(INPUT_POST, "name");
    $newsletter->email = filter_input(INPUT_POST, "email");
    $newsletter->id = filter_input(INPUT_POST, "idToMod");
    $newsletter->table = "newsletter_subscribers";

    if ($newsletter->update(['name', 'email'], 'id')) {
        header("Location:../index.php?p=allSubscribers&msg=subscriberEdit");
        exit;
    } else {
        header("Location:../index.php?p=allSubscribers&err=subscriberNoEdit");
        exit;
    }
} else if (filter_input(INPUT_GET, "confirm")) {

    $newsletter->table = "newsletter_subscribers";
    $newsletter->id = filter_input(INPUT_GET, 'id');
    $newsletter->confirmed = 1;

    if ($newsletter->update(['confirmed'], 'id')) {

        // get subscriber email
        $newsletter->table = "newsletter_subscribers";
        $newsletter->id = filter_input(INPUT_GET, 'id');
        $stmt_sub = $newsletter->showAllWhere('id', ['id']);
        $row_sub = $stmt_sub->fetch(PDO::FETCH_ASSOC);
        extract($row_sub);
        $email = $row_sub['email'];

        $newsletter->table = 'newsletter_settings';
        $news_stmt = $newsletter->showAll('id');

        $newsletter_settings = [];

        while ($news_row = $news_stmt->fetch(PDO::FETCH_ASSOC)) {

            extract($news_row);
            $newsletter_settings[$news_row['name']] = $news_row['value'];
        }

        // get email for send
        $from = $newsletter_settings['email'];

        $mc->table = 'mc_settings';
        $mc_stmt = $mc->showAll('id');

        $mc_settings = [];

        while ($mc_row = $mc_stmt->fetch(PDO::FETCH_ASSOC)) {

            extract($mc_row);
            $mc_settings[$mc_row['name']] = $mc_row['value'];
        }
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        // Create email headers
        $headers .= 'From: ' . $from . "\r\n" .
            'Reply-To: ' . $from . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $output = '<p>' . $subreg_body1;
        $output .= '<a href="http://' . $mc_settings['mc_site_url'] . '" target="_blank">' . $mc_settings['mc_site_name'] . '</a></p>';
        $output .= '<p>' . $subreg_body2 . '</p>';

        $to = $email;
        $subject = $subreg_subject . $mc_settings['mc_site_name'];

        $err_send = '';
        if (!mail($to, $subject, $output, $headers)) {
            $err_send = '&err=errSendConfirm';
        }

        header("Location:../index.php?p=allSubscribers&msg=subscriberConfirm");
        exit;
    } else {
        header("Location:../index.php?p=allSubscribers&err=subscriberErrConfirm");
        exit;
    }
} else {
    header("Location: ../index.php?p=allSubscribers&err=noPost");
    exit;
}
