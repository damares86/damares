<?php

$err=filter_input(INPUT_GET,"err");

if($err){
    if($err=="noResetDelete"){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_noResetDelete?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="mailNotReg"){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_mailNotReg?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="errSendMail"){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_errSendMail?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="noReset"){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_noReset?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="errResetRequest"){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_ResetRequest?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="keyDelErr"){
    ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?=$err_keyDelErrt?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="pswEditErr"){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_pswEditErr?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="noLogin"){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_noLogin?>
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