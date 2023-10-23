
<footer>
  <!-- Footer Nav -->
  <div class="footer-nav-area" id="footerNav">
    <div class="container px-0">
      <!-- Footer Content -->
      <div class="footer-nav position-relative">
        <ul class="h-100 d-flex align-items-center justify-content-between ps-0">

          <?php
            $active="";
            if($page_menu=="home"){
              $active=" class=\"active\"";
            }
          ?>
          <li <?=$active?>>
            <a href="home.php">
              <i class="bi bi-house"></i>
              <span><?=$fe_bar_home?></span>
            </a>
          </li>

          <?php
            $active="";
            if($page_menu=="calendar"){
              $active=" class=\"active\"";
            }
          ?>
          <li <?=$active?>>
            <a href="calendar.php">
              <i class="bi bi-calendar3"></i>
              <span><?=$fe_bar_calendar?></span>
            </a>
          </li>

          <?php
            $active="";
            if($page_menu=="sessions"){
              $active=" class=\"active\"";
            }
          ?>
          <li <?=$active?>>
            <a href="sessions.php">
              <i class="bi bi-person-video3"></i>
              <span><?=$fe_bar_sessions?></span>
            </a>
          </li>

          <?php
            $active="";
            if($page_menu=="speakers"){
              $active=" class=\"active\"";
            }
          ?>
          <li <?=$active?>>
            <a href="speakers.php">
              <i class="bi bi-mortarboard"></i>
              <span><?=$fe_bar_speakers?></span>
            </a>
          </li>

          <?php
            $active="";
            if($page_menu=="profile"){
              $active=" class=\"active\"";
            }
          ?>
          <li <?=$active?>>
            <a href="profile.php">
              <i class="bi bi-person-circle"></i>
              <span><?=$fe_bar_profile?></span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
 
  <!-- All JavaScript Files -->
  <script src="admin/assets/extensions/jquery/jquery.min.js"></script>
  <script src="admin/assets/extensions/parsleyjs/parsley.min.js"></script>
  <script src="admin/assets/js/pages/parsley.js"></script>
  <script src="admin/assets/js/pages/<?=$lang?>.js"></script>
  <script src="admin/assets/js/pages/<?=$lang?>.extra.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/slideToggle.min.js"></script>
  <script src="assets/js/tiny-slider.js"></script>
  <script src="assets/js/venobox.min.js"></script>
  <script src="assets/js/countdown.js"></script>
  <script src="assets/js/rangeslider.min.js"></script>
  <script src="assets/js/vanilla-dataTables.min.js"></script>
  <script src="assets/js/index.js"></script>
  <script src="assets/js/imagesloaded.pkgd.min.js"></script>
  <script src="assets/js/isotope.pkgd.min.js"></script>
  <!-- <script src="assets/js/dark-rtl.js"></script> -->
  <script src="assets/js/active.js"></script>
  <script src="assets/js/pwa.js"></script>

        </footer>

</body>
</html>