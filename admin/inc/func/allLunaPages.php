<?php

// get the product data
$prod_id = filter_input(INPUT_GET, 'prod');

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
      <!-- Alert di successo (da mostrare quando il salvataggio è riuscito) -->
      <div class="alert alert-success" style="display: none;" role="alert">
        Salvataggio riuscito!
      </div>

      <!-- Alert di errore (da mostrare quando si verifica un errore durante il salvataggio) -->
      <div class="alert alert-danger" style="display: none;" role="alert">
        Si è verificato un errore durante il salvataggio.
      </div>

      <div class='wrapper'>

        <div id='parent-block' class='container-pages p-3'>
          <?php
            if (!file_exists('inc/luna_pages/pages_' . $prod_id . '.json') && !file_exists('inc/luna_pages/bck/pages_' . $prod_id . '.json')) {
            echo "Nessuna pagina presente";
          } else {
            if (file_exists('inc/luna_pages/pages_' . $prod_id . '.json')) {

              $pages_json = file_get_contents('inc/luna_pages/pages_' . $prod_id . '.json') ;
              $pages_data = json_decode($pages_json,true);

            } else {
              
              $pages_json = file_get_contents('inc/luna_pages/bck/pages_' . $prod_id . '.json') ;
              $pages_data = json_decode($pages_json,true);
            }

            print_r($pages_data[1][0]);

            for($idx = 1; $idx < 4; $idx++){

              foreach($pages_data[$idx] as $parent){

                $luna->table = 'luna_pages_' . $prod_id;
                $luna->id = $parent;
                $stmt = $luna->showAllWhere('id', ['id']);
                
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                extract($row);
              }

          ?>

              <div id="<?= $row['id'] ?>" class='container-pages parent_item px-5 rounded m-2'> <!-- p_1 deve essere l'id della pagina-->
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
    let orderedItems = [];

    $('#parent-block').find('*').each(function() {
      if (this.id) {
        let elementId = this.id;
        let elementLevel = $(this).parents('.container-pages').length;

        orderedItems.push({
          id: elementId,
          livello: elementLevel
        });
      }
    });

    let additionalData = {
      luna_product_id: <?= $prod_id ?>
    };

    let postData = {
      orderedItems: JSON.stringify(orderedItems),
      additionalData: JSON.stringify(additionalData)
    };

    // Invia l'array al server utilizzando AJAX
    $.ajax({
      url: 'core/mngLunaOrder.php', // URL della pagina PHP per il salvataggio
      method: 'POST', // Metodo HTTP da utilizzare
      data: postData, // Dati da inviare (convertiti in stringa JSON)
      success: function(response) {
        console.log(response)
        if (response && response.success) {
          $('.alert-success').html(response.message).fadeIn();
        } else {
          $('.alert-danger').html(response.message || 'Si è verificato un errore durante il salvataggio.').fadeIn();
        }
      },
      error: function(xhr, status, error) {
        console.error('Errore AJAX:', error);
        $('.alert-danger').html('Si è verificato un errore durante la richiesta AJAX.').fadeIn();
      }
    });
  });
</script>