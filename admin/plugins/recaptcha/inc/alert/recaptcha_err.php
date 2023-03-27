<?php

$err=filter_input(INPUT_GET,"err");

if($err){
    if($err=="recapNoMod"){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_recapNoMod?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="errRecaptcha"){
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?=$err_errRecaptcha?>
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