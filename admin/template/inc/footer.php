<div class="clearfix"></div>
</main>
<?php
if (!$one) {
?>
    <footer>
        <div class="row">
            <div class="col-12">
                <div id="copyright">
                    <?= $mc_settings['mc_footer'] ?>
                </div>
            </div>
        </div>
        <p class="copyright" style="font-size:0.7em;">
            <img class="align-middle" src="uploads/img/logo_mc_rid.png"> &nbsp; &nbsp; by  &nbsp; &nbsp; 
        <a href="https://www.dmweblab.com"><img class="align-middle" src="admin/assets/images/logo/dmweblab_logo.png"></a></p>
    </footer>
<?php
}
?>

<?php
if($quote_counter>0){
?>
    <script src="admin/script/quotes.js"></script>
<?php
}
?>
<script src="admin/assets/extensions/parsleyjs/parsley.min.js"></script>
<script src="admin/assets/js/pages/parsley.js"></script>
<script src="admin/assets/js/pages/<?= $lang ?>.js"></script>
<script src="admin/assets/js/pages/<?= $lang ?>.extra.js"></script>
<?php
require "assets/themes/" . $mc_settings['mc_theme'] . "/inc/cookie.php";

foreach (glob("admin/scripts/var/*.js") as $file) {
?>
    <script src="<?= $file ?>"></script>
<?php
}
require "assets/themes/" . $mc_settings['mc_theme'] . "/inc/footerScript.php";
?>


</body>

</html>