<?php

$msg=filter_input(INPUT_GET,"msg");

if($msg){
    if($msg=="accountDel"){
    ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?=$msg_accountDel?>
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
    } else if($msg=="accountEdit"){
    ?> 
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?=$msg_accountEdit?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($msg=="accountSucc"){
        ?> 
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?=$msg_accountSucc?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($msg=="roleDel"){
        ?> 
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?=$msg_roleDel?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($msg=="roleEdit"){
        ?> 
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?=$msg_roleEdit?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($msg=="roleSucc"){
        ?> 
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?=$msg_roleSucc ?>
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