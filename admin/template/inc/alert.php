<?php
	

$msg=filter_input(INPUT_GET,"msg");

if($msg=="errSend"){
    ?>
    <div class="alert alert-danger">
        <?=$al_errSend?>
    </div>

    <?php    
} else if($msg=="mailResetErr"){
    ?>
    <div class="alert alert-danger">
        <?=$al_mailResetErr?>
    </div>

    <?php    
} else if($msg=="sentMail"){
    ?>
<div class="alert alert-success" role="alert">
    <?=$log_forgot_sent?>
</div>
    <?php    
} else if($msg=="mailNotReg"){
    ?>
    <div class="alert alert-danger">
        <?=$al_mailNotReg?>
    </div>

    <?php    
} else if($msg=="pswEmpty"){
    ?>
    <div class="alert alert-danger">
        <?=$al_pswEmpty?>
    </div>

    <?php    
} else if($msg=="newPass"){
    ?>
    <div class="alert alert-success">
        <?=$al_newPass?>
    </div>

    <?php    
} else if($msg=="pswEditErr"){
    ?>
    <div class="alert alert-danger">
        <?=$al_pswEditErr?>
    </div>

    <?php    
} else if($msg=="errResetRequest"){
    ?>
    <div class="alert alert-danger">
        <?=$al_errResetRequest?>
    </div>

    <?php    
} else if($msg=="noResetDelete"){
    ?>
    <div class="alert alert-danger">
        <?=$al_noResetDelete?>
    </div>

    <?php    
} else if($msg=="noReset"){
    ?>
    <div class="alert alert-danger">
        <?=$al_noReset?>
    </div>

    <?php    
} else if($msg=="errRecaptcha"){
    ?>
    <div class="alert alert-danger">
        <?=$al_errRecaptcha?>
    </div>

    <?php    
} else if($msg=="errPost"){
    ?>
    <div class="alert alert-danger">
        <?=$al_errPost?>
    </div>

    <?php    
} else if($msg=="contactFormEmpty"){
    ?>
    <div class="alert alert-danger">
        <?=$al_contactFormEmpty?>
    </div>

    <?php    
} else if($msg=="sentContact"){
    ?>
    <div class="alert alert-success">
        <?=$al_sentContact?>
    </div>

    <?php    
} else if($msg=="errSendContact"){
    ?>
    <div class="alert alert-danger">
        <?=$al_errSendContact?>
    </div>

    <?php    
} else if($msg=="errUserPsw"){
    ?>
    <div class="alert alert-danger">
        <?=$al_errUserPsw?>
    </div>

    <?php    
    //reset email
} else

?>
