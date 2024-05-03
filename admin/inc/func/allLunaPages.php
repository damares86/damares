<?php

// get the product data
$prod_id = filter_input(INPUT_GET, 'prod');
// $luna->table = 'luna_pages_'.$prod_id;
// $stmt = $luna->showAll('id');
// if($stmt->rowCount()>0)
// {
//   $row = $stmt->fetch(PDO::FETCH_ASSOC);
//   extract($row);
// }

$luna->table = 'luna_products';
$luna->id = $prod_id;
$stmt1 = $luna->showAllWhere('id', ['id']);
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
extract($row1);

?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?= $row1['name'] ?> - Pages Management</h3>
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
      <a href="index.php?p=addLunaPage&prod=<?= $prod_id ?>" class="btn icon icon-left btn-success shadow"><i data-feather="plus-circle"></i> Add a new parent page</a>
    </div>
    <div class="card-body">

    <div class='wrapper'>

    <div id='parent-block' class='container-pages p-3'>
      <?php
      if (!file_exists('inc/luna_pages/pages_' . $prod_id . '.php') || !file_exists('inc/luna_pages/bck/pages_' . $prod_id . '.php')) {
        echo "Nessuna pagina presente";
      } else {
        if (file_exists('inc/luna_pages/pages_' . $prod_id . '.php')) {
          require 'inc/luna_pages/pages_' . $prod_id . '.php';
        } else {
          require 'inc/luna_pages/bck/pages_' . $prod_id . '.php';
        }


        foreach ($pages as $page) {

          $luna->table = 'luna_pages_' . $prod_id;
          $luna->id = $page;
          $stmt = $luna->showAllWhere('id', ['id']);

          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          extract($row);

      ?>

          <div id="parent_<?= $row['id'] ?>" class='container-pages parent_item px-5 rounded m-2'> <!-- p_1 deve essere l'id della pagina-->
            <?= $row['title'] ?>
          </div>

      <?php

        }
      }
      ?>
    </div>

    </div>
    </div>
    <button id="save" class="btn btn-success m-3 w-25">Save</button>

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