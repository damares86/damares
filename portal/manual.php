<?php
require "inc/header.php";

if (!filter_input(INPUT_GET, 'prod')) {
  header('Location: index.php');
  exit;
}
$page_id = filter_input(INPUT_GET,'page');
?>

<body>
  <?php

  // DA MODIFICARE AGGIUNGENDO IL VINCOLO DELL'UTENZA

  $luna->table = 'luna_products';
  $prod_id = filter_input(INPUT_GET, 'prod');
  $luna->id = $prod_id;
  $stmt4 = $luna->showAllWhere('id', ['id']);

  while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
    extract($row4);
  ?>
    <script src="../admin/assets/js/initTheme.js"></script>
    <div id="app">

      <?php
      include "inc/sidebar.php";
      ?>

      <div id="main">

        <div class="content-wrapper container">

          <div class="page-content">

            <section class="row">

              <div class="col-12">
                <div class="card shadow">
                  <div class="card-header">
                  <h4>Manuale di <?= $row4['name'] ?></h4>
                  </div>
                  <div class="card-content p-4">
                    Contenuto
                  </div>
                  <ul>


                    
                  </ul>
                </div>
              </div>

            </section>
          <?php
        }
          ?>

          </div>
        </div>

        <?php
        include "inc/footer.php";
        ?>