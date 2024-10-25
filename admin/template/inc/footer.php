<div class="clearfix"></div>
<?php
if (!$one) {
?>
    <footer>
        <div class="row">
            <div class="col-12">
                <div id="copyright">
                    <ul class="menu">
                        <li><?= $mc_settings['mc_footer'] ?></a></li>
                        <!-- <li>&copy; Untitled. All rights reserved</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li> -->
                    </ul>
                </div>
            </div>
        </div>
        <p class="copyright" style="font-size:0.7em;">Made with Mini Cms <?= $mc_version ?> - a project by &nbsp; &nbsp; <a href="https://www.dmweblab.com"><img src="admin/assets/images/logo/dmweblab_logo.png"></a></p>
    </footer>
<?php
}
?>
</div>


<script src="admin/script/quotes.js"></script>
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