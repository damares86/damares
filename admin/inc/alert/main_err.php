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
    } else if($err=="pluginUploadFormatErr"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_pluginUploadFormatErr?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="pluginUploadErr"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_pluginUploadErr?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="pluginAddErr"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_pluginAddErr?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="pluginDisErr"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_pluginDisErr?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="pluginRmErr"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_pluginRmErr?>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    <?php
    } else if($err=="settingUpdateErr"){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?=$err_settingUpdateErr?>
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