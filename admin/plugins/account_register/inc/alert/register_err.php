<?php

$err=filter_input(INPUT_GET,"err");

if($err){
    if($err=="mailExists"){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_mailExists?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else  if($err=="noRegDelete"){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_noRegDelete?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else  if($err=="errSendMail"){
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
    } else  if($err=="noReg"){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_noReg?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else  if($err=="errRegRequest"){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_errRegRequest?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    }  else  if($err=="accountNoReg"){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_accountNoReg?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    }  else  if($err=="regRoleNotUpdated"){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_regRoleNotUpdated?>
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