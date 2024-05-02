<?php

// get the product data
$prod_id = filter_input(INPUT_GET, 'prod');
$luna->table = 'luna_pages_'.$prod_id;
$stmt = $luna->showAll('id');
$row = $stmt->fetch(PDO::FETCH_ASSOC);
extract($row);

exit;

?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Pages Management</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?= $common_dashboard ?></a>
          </li>
          <li class="breadcrumb-item active">
            <a href="index.php?p=allLunaProducts">All Luna Products</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Pages Management
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>


<!-- Basic Tables start -->
<section class="section">
  <div class="card shadow">
    <div class="card-header">
      <h4 class="d-inline"><?= $row['name'] ?></h4> &nbsp; &nbsp; &nbsp;
      <a href="index.php?p=addLunaPage&prod=1" class="btn icon icon-left btn-success shadow"><i data-feather="plus-circle"></i> Add a new parent page</a>
    </div>
    <div class="card-body">

      <div class='wrapper'>

        <div id='parent-block' class='container-pages p-3'>

          <?php

          $parent_div_arr = [];
          $child_div_arr = [];
          $paragraph_div_arr = [];

          $luna->table = 'luna_parent';
          $luna->luna_products_id = $prod_id;
          $stmt1 = $luna->showAllWhere('id', ['luna_products_id']);
          while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            extract($row1);

            $parent_div_arr[] = $row1['id'];
            $child_div_arr[] = $row1['id'];

            // check if there are some children
            $disable = '';

            $luna->table = 'luna_parent_child';
            $luna->parent_pages_id = $row1['id'];
            $stmt2 = $luna->showAllWhere('id', ['parent_pages_id']);



          ?>
            <div id="parent_<?= $row1['id'] ?>" class='container-pages parent_item px-5 rounded m-2'> <!-- p_1 deve essere l'id della pagina-->
              <?= $row1['title'] ?>
              <?php
              if ($stmt2->rowCount() > 0) {
              ?>
                <a class="btn icon btn-sm btn-info mx-2 <?= $disable ?>" data-bs-toggle="collapse" href="#child_<?= $row1['id'] ?>" role="button" aria-expanded="false" aria-controls="child_<?= $row1['id'] ?>">
                  <i class="bi bi-chevron-down"></i>
                </a>
              <?php
              }
              ?>
               &nbsp;
              <a href="index.php?p=editLunaPage&prod=<?= $prod_id ?>&parent=<?= $row1['id'] ?>" class="btn icon icon-left btn-warning shadow"> <i class="bi bi-pencil-square"></i> Edit page</a>
              &nbsp;
              <a href="index.php?p=addLunaPage&prod=<?= $prod_id ?>&parent=<?= $row1['id'] ?>" class="btn icon icon-left btn-success shadow"><i data-feather="plus-circle"></i> Add a child page</a>
              <?php
              if ($stmt2->rowCount() > 0) {
                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                extract($row2);
                $child_arr = explode(',', $row2['child_pages_id_arr']);

              ?>
                <div id="child_<?= $row1['id'] ?>" class='collapse container-pages child_block p-2 rounded m-2'> <!-- 1 deve essere l'id della pagina-->
                  <?php
                  foreach ($child_arr as $item) {
                    $luna->table = 'luna_child';
                    $luna->id = $item;
                    $stmt4 = $luna->showAllWhere('id', ['id']);
                    $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
                    extract($row4);

                  ?>
                    <div id="p_<?= $row1['id'] ?>_c_<?= $row4['id'] ?>" class="child_item rounded m-2">
                      <?= $row4['title'] ?> &nbsp;

                      <?php
                      $disable = '';

                      $luna->table = 'luna_child_paragraph';
                      $luna->child_pages_id = $row4['id'];
                      $stmt3 = $luna->showAllWhere('id', ['child_pages_id']);
                      if ($stmt3->rowCount() == 0) {
                        $disable = 'disable';
                      }
                      ?>
                      <a class="btn icon btn-sm btn-info mx-2 <?= $disable ?>" data-bs-toggle="collapse" href="#paragraph_<?= $row4['id'] ?>" role="button" aria-expanded="false" aria-controls="paragraph_<?= $row4['id'] ?>">
                        <i class="bi bi-chevron-down"></i>
                      </a> &nbsp;
                      <a href="index.php?p=editLunaPage&prod=<?= $prod_id ?>&parent=<?= $row1['id'] ?>&child=<?= $row4['id'] ?>" class="btn icon icon-left btn-warning shadow"> <i class="bi bi-pencil-square"></i> Edit page</a>
                      &nbsp;
                      <a href="index.php?p=addLunaPage&prod=<?= $prod_id ?>&parent=<?= $row1['id'] ?>&child=<?= $row4['id'] ?>" class="btn icon icon-left btn-success shadow"><i data-feather="plus-circle"></i> Add a paragraph</a>
                      <?php
                      if ($stmt3->rowCount() > 0) {
                        $paragraph_div_arr[] = $row4['id'];
                      ?>
                        <div id="paragraph_<?= $row4['id'] ?>" class='collapse container-pages paragraph_block p-2 rounded m-2'><!-- 1 deve essere l'id della pagina child a cui appartengono i paragrafi-->
                          <?php
                          $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
                          extract($row3);
                          $par_arr = explode(',', $row3['paragraph_id_arr']);

                          foreach ($par_arr as $par) {
                            $luna->table = 'luna_paragraph';
                            $luna->id = $par;
                            $stmt5 = $luna->showAllWhere('id', ['id']);
                            $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
                            extract($row5);
                          ?>
                            <div id="c_<?= $row4['id'] ?>_p_<?= $row5['id'] ?>" class="paragraph_item rounded m-2">
                              <?= $row5['title'] ?> <!-- 1 deve essere l'id del paragrafo--> &nbsp;
                              <a href="index.php?p=editLunaPage&prod=<?= $prod_id ?>&parent=<?= $row1['id'] ?>&child=<?= $row4['id'] ?>&paragraph=<?= $row5['id'] ?>" class="btn icon icon-left btn-warning shadow"> <i class="bi bi-pencil-square"></i> Edit paragraph</a>
                            </div>

                          <?php
                          }
                          ?>
                        </div>
                      <?php
                      }
                      ?>
                    </div>
                  <?php
                  }
                  ?>




                </div>

              <?php
              }
              ?>
            </div>
          <?php
          }
          ?>

        </div>

      </div>


      <button id="save" class="btn btn-success m-3 w-25">Save</button>

    </div>
  </div>
</section>

<script src='script/dragula.js'></script>
<script>
  var blocks_array = [];

  var p = 'parent-block';
  blocks_array.push(p);
  <?php
  foreach ($parent_div_arr as $item) {
  ?>
    var child_<?= $item ?> = 'child_<?= $item ?>';
    blocks_array.push(child_<?= $item ?>);
  <?php
  }
  ?>

  <?php
  foreach ($paragraph_div_arr as $item_paragraph) {
  ?>

    var paragraph_<?= $item_paragraph ?> = 'paragraph_<?= $item_paragraph ?>';
    blocks_array.push(paragraph_<?= $item_paragraph ?>);
  <?php
  }
  ?>
</script>
<script src='script/example.min.js'></script>

<script>
  $("#save").click(function() {
    // Array per raccogliere tutti gli ID degli elementi e i loro livelli di innestamento
    let orderedItems = [];

    // Recupera l'ordine corrente degli elementi per tutti i div e i loro discendenti all'interno di parent-block
    $('#parent-block').find('*').each(function() {
      if (this.id) {
        // Recupera l'ID e il livello di innestamento dell'elemento corrente
        let elementId = this.id;
        let elementLevel = $(this).parents('.container-pages').length; // Calcola il livello di innestamento

        // Aggiungi l'ID e il livello di innestamento all'array
        orderedItems.push({
          id: elementId,
          livello: elementLevel
        });
      }
    });

    $.ajax({
      url: 'core/mngLuna.php', // URL della pagina PHP per il salvataggio
      method: 'POST', // Metodo HTTP da utilizzare
      data: {
        orderedItems: JSON.stringify(orderedItems)
      }, // Dati da inviare (convertiti in stringa JSON)
      success: function(response) {
        console.log('Dati inviati con successo al server');
        // Puoi gestire la risposta del server qui
      },
      error: function(xhr, status, error) {
        console.error('Si è verificato un errore durante l\'invio dei dati al server:', error);
        // Gestisci gli errori qui, se necessario
      }
    });

    // Invia l'array al server per salvarlo nel database o in un file JSON
    console.log('Ordine degli elementi con livello di innestamento:', orderedItems);
  });
</script>