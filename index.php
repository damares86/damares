<?php
require "admin/template/inc/header.php";
?>
<div id="bottomContainer">
    <?php
    if (!$one) {
        $file = basename($_SERVER['PHP_SELF']);
        $page_class = pathinfo($file, PATHINFO_FILENAME);

        $mc->page_name = $page_class;

        require "admin/template/page_recall.php";
    } else {

        foreach ($page_order as $page_req) {
            if ($page_req != 3) {

                //   if($page_req==1){
                //         require "admin/template/page_recall.php";
                //     }else{
    ?>
                <div id="<?= $page_req ?>">
                    <?php
                    if ($page_req == 2) {
                        require "admin/template/contact_form.php";
                    } else {
                        require "admin/template/page_recall.php";
                    }
                    ?>
                </div>
    <?php
            }
        }
    }
    // }
    ?>
</div>
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
                            data-parsley-type="email" name="email" placeholder="Email address..." aria-label="Email address..." aria-describedby="button-newsletter" data-parsley-required="true"/>
                        <button class="btn btn-outline-light mt-3" id="button-newsletter" type="submit">Sign up</button>
                    </form>
                </div>
                <div class="small text-white-50">We care about privacy, and will never share your data.</div>
            </div>
        </div>
    </aside>
</div>
<?php

require "admin/template/inc/footer.php";
