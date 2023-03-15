<?php

$msg=filter_input(INPUT_GET,"msg");

if($msg){
    if($msg=="sentMail"){
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?=$msg_sentMail?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($msg=="passMod"){
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?=$msg_passMod?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($msg=="newPass"){
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?=$msg_newPass?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    }
}
?>