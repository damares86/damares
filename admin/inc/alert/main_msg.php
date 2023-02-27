<?php

$msg=filter_input(INPUT_GET,"msg");

if($msg){
    if($msg=="accountDel"){
    ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Account successfully deleted
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
            Password modified
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
            Account successfully modified
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
            Account created
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
            Role successfully deleted
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
            Role successfully modified
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
            Role created
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