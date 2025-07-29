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

    if($newsletter->delete('id')){
        header("Location:../index.php?p=allSubscribers&msg=subscriberDel");
        exit;        
    }else{
        header("Location:../index.php?p=allSubscribers&err=subscriberNoDel");
        exit;
    }

}

$operation = filter_input(INPUT_POST,'operation') ;

if ($operation == 'add') {
    
    $goback = filter_input(INPUT_POST,'backend') ? '../index.php?p=allSubscribers' : '../../index.php?p=1';

    $newsletter->name = filter_input(INPUT_POST,"name");
    $newsletter->email = filter_input(INPUT_POST,"email");
    $data = ['name','email'];
    if(filter_input(INPUT_POST,'backend')){
        $newsletter->confirmed = 1;
        $data[] = 'confirmed';
    }
    $newsletter->table = "newsletter_subscribers";
    

    if($newsletter->insert($data)){

        $newsletter->table = "newsletter_settings";
        $newsletter->name = "confirmation";
        $stmt = $newsletter->showAllWhere('id',['name']);
        $confirmation = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $confirm_message = '' ;
        if($confirmation['value'] == 1 && !filter_input(INPUT_POST,'backend')){
            $confirm_message = '&msg=NoConfirm' ;
        }
        
        header("Location: $goback&msg=subscriberSucc$confirm_message");
        exit;
        
    }else{
        header("Location: $goback&err=subscriberErr");
        exit;
    }
    
} else if ($operation == 'edit') {

    $newsletter->name = filter_input(INPUT_POST,"name");
    $newsletter->email = filter_input(INPUT_POST,"email");
    $newsletter->id = filter_input(INPUT_POST,"idToMod");
    $newsletter->table = "newsletter_subscribers";

    if($newsletter->update(['name','email'],'id')){
        header("Location:../index.php?p=allSubscribers&msg=subscriberEdit");
        exit;        
    }else{
        header("Location:../index.php?p=allSubscribers&err=subscriberNoEdit");
        exit;
    }

}else if (filter_input(INPUT_GET, "confirm")) {

    $newsletter->table = "newsletter_subscribers";
    $newsletter->id = filter_input(INPUT_GET,'id');
    $newsletter->confirmed = 1 ;

    if($newsletter->update(['confirmed'],'id')){
        header("Location:../index.php?p=allSubscribers&msg=subscriberConfirm");
        exit;        
    }else{
        header("Location:../index.php?p=allSubscribers&err=subscriberErrConfirm");
        exit;
    }

} else {
    header("Location: ../index.php?p=allSubscribers&err=noPost");
    exit;
}
