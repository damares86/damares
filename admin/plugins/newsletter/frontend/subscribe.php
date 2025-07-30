<?php

$plugin->pluginname = "recaptcha";
$recap = false;
if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {
    $recap = true;
    require "admin/template/inc/recaptcha.php";
}

?>

<div class="container">
    <aside class="bg-primary bg-gradient rounded-3 p-4 p-sm-5 my-5">
        <div class="d-flex align-items-center justify-content-between flex-column flex-xl-row text-center text-xl-start">
            <div class="mb-4 mb-xl-0">
                <div class="fs-3 fw-bold text-white">Subscribe to our newsletter</div>
                <div class="text-white-50">Let's keep in touch</div>
            </div>
            <div class="ms-xl-4">
                <div class="input-group mb-2">
                    <form action="admin/core/mngSubscriber.php" method="POST" data-parsley-validate>
                        <input class="form-control mb-3" type="text"
                            name="name" placeholder="Your name" aria-label="Your name" aria-describedby="button-newsletter" data-parsley-required="true" />
                        <input class="form-control" type="email" HTML5
                            data-parsley-type="email" name="email" placeholder="Email address..." aria-label="Email address..." aria-describedby="button-newsletter" data-parsley-required="true" />
                        <button class="btn btn-outline-light mt-3" id="button-newsletter" type="submit">Sign up</button>
                        <input type="hidden" name="operation" value="add">
                        <?php 
                        if($recap){
                        ?>
                          <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                        <?php
                        }
                        ?>
                    </form>
                </div>
                <div class="small text-white-50">We care about privacy, and will never share your data.</div>
            </div>
        </div>
    </aside>
</div>