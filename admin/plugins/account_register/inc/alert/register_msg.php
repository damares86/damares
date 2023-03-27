<?php

$msg=filter_input(INPUT_GET,"msg");

if($msg){
    if($msg=="sentRegMail"){
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?=$msg_sentRegMail?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($msg=="accountReg"){
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?=$msg_accountReg?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    }else if($msg=="regRoleUpdated"){
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?=$msg_regRoleUpdated?>
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