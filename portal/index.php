<?php
require "inc/header.php";

if (!filter_input(INPUT_POST, 'prod'))

?>

<body>
  <script src="../admin/assets/js/initTheme.js"></script>
  <div id="app">

    <div id="main" class="home">

      <div class="content-wrapper container">


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
                  <div class="card-header text-center">
                    <h3>Benvenuto</h3>
                  </div>
                  <div class="card-content home p-5">
                    
                    <p>
                      Clicca sulla guida che ti interessa:
                    <ul>
                      <?php

                      // DA MODIFICARE AGGIUNGENDO IL VINCOLO DELL'UTENZA

                      $luna->table = 'luna_products';
                      $stmt1 = $luna->showAll('id');

                      while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                        extract($row1);
                      ?>

                        <li><a href="manual.php?prod=<?= $row1['id'] ?>"><?= $row1['name'] ?> (v. <?= $row1['version'] ?>)</a></li>

                      <?php
                      }
                      ?>
                    </ul>
                    </p>
                  </div>
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