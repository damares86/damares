<?php

$msg=filter_input(INPUT_GET,"msg");

if($msg){
    if($msg=="sentMail"){
    ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?=$msg_sentMail?>
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
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?=$msg_accountReg?>
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