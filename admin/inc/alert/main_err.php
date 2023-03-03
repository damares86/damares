<?php

$err=filter_input(INPUT_GET,"err");

/////// ERROR ON LOGIN????

if($err){
    if($err=="accountNoDel"){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_accountNoDel?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="passNoMod"){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_passNoMod?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="noAvatarUpload"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_noAvatarUpload?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="accountRoleNoEdit"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_accountRoleNoEdit?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="accountNoEdit"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_accountNoEdit?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="accountExist"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_accountExist?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="accountFail"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_accountFail ?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="roleNoDel"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_roleNoDel?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="roleNoEdit"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_roleNoEdit?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="roleExist"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_roleExist?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="roleFail"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_roleFail?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="formatErr"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_formatErr?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="fileNoDel"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_fileNoDel?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="fileFail"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_fileFail?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="fileEditFail"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_fileEditFail?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="fileExists"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_fileExists?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="fileErr"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_fileErr?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="noFilePost"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_fileErr?>
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