<?php
require "inc/header.php";

if (!filter_input(INPUT_POST, 'prod'))

?>

<body>
  <script src="../admin/assets/js/initTheme.js"></script>
  <div id="app">

    <?php
  include "inc/sidebar.php";
    ?>

    <div id="main">

      <div class="content-wrapper container">

        <?php
        if ($page == 'dashboard') {
        ?>
          <div class="page-heading">
            <h3>Damares <?= $common_dashboard ?></h3>
          </div>
        <?php
        }
        ?>
        <div class="page-content">

          <?php

          //   require "inc/alert.php";

          if (filter_input(INPUT_GET, "p")) {
            include "inc/func/$page.php";
          } else {

          ?>




            <section class="row">

              <div class="col-12">
                <div class="card shadow">
                  <h4>Benvenuto</h4>
                  <ul>
                  <?php

                  // DA MODIFICARE AGGIUNGENDO IL VINCOLO DELL'UTENZA

                  $luna->table = 'luna_products';
                  $stmt1 = $luna->showAll('id');

                  while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                    extract($row1);
                  ?>

                    <li><a href="manual.php?prod=<?=$row1['id']?>"><?=$row1['name']?> (v. <?=$row1['version']?>)</a></li>

                  <?php
                  }
                  ?>
                  </ul>
                </div>
              </div>

            <?php
          }
            ?>
            </section>

        </div>
      </div>

      <?php
      include "inc/footer.php";
      ?>