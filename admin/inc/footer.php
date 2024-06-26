<footer>
  <div class="container">
    <div class="footer clearfix mb-0 text-muted">

      <div class="float-end">
        <p>
          <img src="assets/images/logo/damares_rid.png" alt="Logo" /> &nbsp; <strong>damares v.<?= $damares_version ?></strong> - developed by
          <a href="http://www.dmweblab.com" target="_blank">
            <img src="assets/images/logo/dmweblab_logo.png" alt="Logo" />
          </a>
        </p>
      </div>
    </div>
  </div>
</footer>

</div>
</div>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/app.js"></script>

<script src="assets/js/pages/horizontal-layout.js"></script>

<?php
if ($apex) {
?>
  <script src="assets/extensions/dayjs/dayjs.min.js"></script>
  <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>

  <script>
    var barOptions = {
      series: [{
          name: "<?= $title1 ?>",
          data: [<?= $arr1 ?>],
        },
        {
          name: "<?= $title2 ?>",
          data: [<?= $arr2 ?>],
        },
        {
          name: "<?= $title3 ?>",
          data: [<?= $arr3 ?>],
        },
      ],
      chart: {
        type: "bar",
        height: 350,
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: "55%",
          endingShape: "rounded",
        },
      },
      dataLabels: {
        enabled: false,
      },
      stroke: {
        show: true,
        width: 2,
        colors: ["transparent"],
      },
      xaxis: {
        categories: ["Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],
      },
      yaxis: {
        title: {
          text: "$ (thousands)",
        },
      },
      fill: {
        opacity: 1,
      },
      tooltip: {
        y: {
          formatter: function(val) {
            return "$ " + val + " thousands";
          },
        },
      },
    };

    var bar = new ApexCharts(document.querySelector("#bar"), barOptions);
    bar.render();
  </script>
<?php
}
?>

<script src="assets/js/pages/dashboard.js"></script>
<script src="assets/js/pages/datatables.min.js"></script>

<script>
  <?php
  $lc_lang = strtolower($lang);
  if ($lang == 'en') {
    $uc_lang = 'GB';
  } else {
    $uc_lang = strtoupper($lang);
  }

  $local_url = '';
  $local_file = 'assets/js/pages/datatable_localization/' . $lc_lang . '-' . $uc_lang . '.json';

  if (file_exists($local_file)) {
    $local_url = $local_file;
  } else {
    $local_url = '//cdn.datatables.net/plug-ins/2.0.1/i18n/' . $lc_lang . '-' . $uc_lang . '.json';
  }
  ?>

  let pageName = "<?= $page ?>"; // Nome della pagina
  let updatingURL = false; // Variabile per evitare la sovrascrittura dell'URL
  let urlPage = getURLParameter('tablePage');

  function getURLParameter(name) {
    return new URLSearchParams(window.location.search).get(name);
  }

  function updateURLParameter(param, value) {
    if (!updatingURL) {
      let url = new URL(window.location);
      url.searchParams.set(param, value);
      history.replaceState(null, '', url);
    }
  }

  
    let table = $("#table").DataTable({
      // localization
      language: {
        url: "<?= $local_url ?>",
      },
      drawCallback: function(settings) {
        let currentPage = table.page();
        updateLinks(currentPage);
        updateURLParameter('tablePage', currentPage + 1); // Aggiungere 1 perché l'URL usa l'indice 1-based
      },
      initComplete: function() {
        if (urlPage !== null) {
          let pageIndex = parseInt(urlPage) - 1; // DataTables usa zero-index per le pagine
          table.page(pageIndex).draw(false);
        }
        $('#table_wrapper').show(); // Mostra la tabella dopo l'inizializzazione
      }
  });

  // Recuperare la pagina dall'URL e impostarla
  console.log('Pagina dall\'URL: ' + urlPage);
  if (urlPage !== null) {
    let pageIndex = parseInt(urlPage) - 1; // DataTables usa zero-index per le pagine
    console.log('Impostazione pagina a: ' + pageIndex);
    table.page(pageIndex).draw(false);
  }

  function updateLinks(pageNumber) {
    let links = document.querySelectorAll('.edit-link');
    links.forEach(link => {
      let baseUrl = link.getAttribute('data-base-url');
      link.href = `${baseUrl}&tablePage=${pageNumber + 1}`;
      // console.log('Aggiornato link: ' + link.href);
    });
  }

  // Aggiungi un listener per l'evento 'page' della DataTable
  table.on('page.dt', function() {
    let currentPage = table.page();
    console.log('Pagina corrente durante evento page: ' + currentPage);
    updateLinks(currentPage);
    updateURLParameter('tablePage', currentPage + 1); // Aggiungere 1 perché l'URL usa l'indice 1-based
  });

</script>


<!-- <script src="assets/js/pages/datatables.js"></script> -->

<script src="assets/js/pages/dataTables.buttons.min.js"></script>
<script src="assets/js/pages/jszip.min.js"></script>
<script src="assets/js/pages/vfs_fonts.js"></script>
<script src="assets/js/pages/buttons.html5.min.js"></script>
<script src="assets/js/pages/buttons.print.min.js"></script>

<script src="assets/extensions/parsleyjs/parsley.min.js"></script>
<script src="assets/js/pages/parsley.js"></script>
<script src="assets/js/pages/<?= $lang ?>.js"></script>
<script src="assets/js/pages/<?= $lang ?>.extra.js"></script>
<script src="assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
<script src="assets/js/pages/form-element-select.js"></script>

<?php
if ($summernote) {
?>

  <script src="assets/extensions/summernote/summernote-lite.min.js"></script>
  <script src="assets/js/pages/summernote.js"></script>
<?php
} else {
?>
  <script src="assets/extensions/tinymce/tinymce.min.js"></script>
  <script src="assets/js/pages/tinymce.js"></script>
<?php
}
?>

<?php

if ($page == "addPaziente" || $page == "editPaziente") {
  if (isset($count)) {
?>
    <script>
      var i = <?= $count ?> - 1;
    </script>
  <?php
  } else {
  ?>
    <script>
      var i = 1;
    </script>
  <?php
  }
  ?>
  <script src="script/mngFarmaci.js"></script>

  <?php
}

if ($page == "addQuiz" || $page == "editQuiz") {
  if (isset($count)) {
  ?>
    <script>
      var i = <?= $count ?> - 1;
    </script>
  <?php
  } else {
  ?>
    <script>
      var i = 1;
    </script>
  <?php
  }
  ?>
  <script src="script/mngQuiz.js"></script>

<?php
}
?>

</body>

</html>