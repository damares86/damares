<footer>
  <div class="container">
    <div class="footer clearfix mb-0 text-muted">
      <?php
      // require 'inc/version.php';
      ?>
      <div class="float-end">
        <p>
          <img src="assets/img/logo/luna_rid.png" alt="Logo" /> &nbsp; <strong>luna portal v.<?= $luna_version ?></strong> - powered by 
          <img src="assets/img/logo/damares_rid.png" alt="Logo" /> &nbsp; <strong>damares v.<?= $damares_version ?></strong> - developed by
          <a href="http://www.dmweblab.com" target="_blank">
            <img src="assets/img/logo/dmweblab_logo.png" alt="Logo" />
          </a>
        </p>
      </div>
    </div>
  </div>
</footer>

</div>
</div>
<script src="../admin/assets/js/bootstrap.js"></script>
<script src="../admin/assets/js/app.js"></script>
<script src="../admin/assets/js/pages/dashboard.js"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
<script>
  <?php
  $lc_lang = strtolower($lang);
  $uc_lang = strtoupper($lang);
  ?>
  let jquery_datatable = $(".table").DataTable({
    // localization
    language: {
      url: '//cdn.datatables.net/plug-ins/2.0.1/i18n/<?= $lc_lang ?>-<?= $uc_lang ?>.json',
    }
  })
</script>
<!-- <script src="assets/js/pages/datatables.js"></script> -->

<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<!-- <script src="assets/extensions/parsleyjs/parsley.min.js"></script>
<script src="assets/js/pages/parsley.js"></script>
<script src="assets/js/pages/<?= $lang ?>.js"></script>
<script src="assets/js/pages/<?= $lang ?>.extra.js"></script>
<script src="assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
<script src="assets/js/pages/form-element-select.js"></script> -->

</body>

</html>