<footer>
          <div class="footer clearfix mb-0 text-muted">
            <?php
            require 'inc/version.php';
            ?>
            <div class="float-end">
              <p>
              <img src="assets/images/logo/damares_rid.png" alt="Logo"/> &nbsp; <strong>damares v.<?=$version?></strong> - developed by 
                <a href="http://www.dmweblab.com" target="_blank">
                    <img src="assets/images/logo/dmweblab_logo.png" alt="Logo"/>
                </a>
              </p>
            </div>
          </div>
        </footer>

        </div>
    </div>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.js"></script>

    <?php
      if($apex)
      {
    ?>
      <script src="assets/extensions/dayjs/dayjs.min.js"></script>
      <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>

      <script>
      var barOptions = {
          series: [
            {
              name: "<?=$title1?>",
              // data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
              data: [<?=$arr1?>],
            },
            {
              name: "<?=$title2?>",
              data: [<?=$arr2?>],
            },
            {
              name: "<?=$title3?>",
              data: [<?=$arr3?>],
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
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="assets/js/pages/datatables.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    
    <script src="assets/extensions/parsleyjs/parsley.min.js"></script>
    <script src="assets/js/pages/parsley.js"></script>
    <script src="assets/js/pages/<?=$lang?>.js"></script>
    <script src="assets/js/pages/<?=$lang?>.extra.js"></script>
    <script src="assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
    <script src="assets/js/pages/form-element-select.js"></script>
    <script src="assets/extensions/tinymce/tinymce.min.js"></script>
    <script src="assets/js/pages/tinymce.js"></script>



    <?php
    
    if($page=="addPaziente"||$page=="editPaziente"){
      if(isset($count)){
  ?>
          <script>
              var i=<?=$count?>-1;
          </script>
  <?php
      }else{
  ?>        
      <script>
          var i=1;
      </script>
  <?php
      }
  ?> 
      <script src="script/mngFarmaci.js"></script>
 
  <?php
  }

    if($page=="addQuiz"||$page=="editQuiz"){
        if(isset($count)){
    ?>
            <script>
                var i=<?=$count?>-1;
            </script>
    <?php
        }else{
    ?>        
        <script>
            var i=1;
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