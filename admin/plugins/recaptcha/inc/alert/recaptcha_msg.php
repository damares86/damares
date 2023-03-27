<?php

$msg=filter_input(INPUT_GET,"msg");

if($msg){
    if($msg=="recapMod"){
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?=$msg_recapMod?>
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