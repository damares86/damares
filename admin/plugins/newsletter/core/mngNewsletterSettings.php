<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__ . "/coreConfig.php";

$operation = filter_input(INPUT_POST, "operation");

$post = $_POST;

$error = 0;


if ($operation == 'settings') {

    $newsletter->table = 'newsletter_settings';
    $newsletter->name = 'confirmation';
    $newsletter->value = filter_input(INPUT_POST, 'confirmation') ? 1 : 0;
    if ($newsletter->update(['value'], 'name')) {
        header("Location:../index.php?p=allNewsletterSettings&msg=settingUpdate");
        exit;
    } else {
        header("Location:../index.php?p=allNewsletterSettings&err=settingUpdateEr");
        exit;
    }
} else if ($operation == "mail") {
    $exclude = array('operation', '.origin');
    foreach ($post as $k => $v) {        
        if($k == 'password'  && trim($v) === ''){
            continue ;
        }
        $newsletter->table = "newsletter_settings";
        $newsletter->name = $k;
        $newsletter->value = $v;

        if (!$newsletter->update(['value'], 'name')) {
            $error++;
        }
    }

    if ($error == 0) {
        header("Location:../index.php?p=allNewsletterSettings&msg=settingUpdate");
        exit;
    } else {
        header("Location:../index.php?p=allNewsletterSettings&err=settingUpdateEr");
        exit;
    }
}
