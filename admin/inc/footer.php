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

    <!-- Need: Apexcharts -->
  
    <script src="assets/js/pages/dashboard.js"></script>
    <script src="assets/extensions/jquery/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="assets/js/pages/datatables.js"></script>
    <script src="assets/extensions/parsleyjs/parsley.min.js"></script>
    <script src="assets/js/pages/parsley.js"></script>
    <script src="assets/js/pages/<?=$lang?>.js"></script>
    <script src="assets/js/pages/<?=$lang?>.extra.js"></script>
    <script src="assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
    <script src="assets/js/pages/form-element-select.js"></script>
    <script src="assets/extensions/tinymce/tinymce.min.js"></script>
    <script src="assets/js/pages/tinymce.js"></script>

    <?php
    
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