<?php

$err=filter_input(INPUT_GET,"err");

/////// ERROR ON LOGIN????

if($err){
    if($err=="accountNoDel"){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Account not deleted
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
            Password not modified
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
            Avatar image not uploaded
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
            Account role not mdified
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
            Account not modified
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
            Account already exist
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
            Account not created
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
            Role not deleted
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
            Role not modified
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
            Role already exist
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
            Role not created
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