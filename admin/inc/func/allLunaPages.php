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
      <h4 class="d-inline"><?= $row1['name'] ?></h4> &nbsp; &nbsp; &nbsp;
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

          $parent_div_arr = [];
          $child_div_arr = [];
          $paragraph_div_arr = [];

          if (!file_exists('inc/luna_pages/pages_' . $prod_id . '.json') && !file_exists('inc/luna_pages/bck/pages_' . $prod_id . '.json')) {
            echo "Nessuna pagina presente";
          } else {
            if (file_exists('inc/luna_pages/pages_' . $prod_id . '.json')) {

              $pages_json = file_get_contents('inc/luna_pages/pages_' . $prod_id . '.json');
              $pages_data = json_decode($pages_json, true);
            } else {

              $pages_json = file_get_contents('inc/luna_pages/bck/pages_' . $prod_id . '.json');
              $pages_data = json_decode($pages_json, true);
            }

            foreach ($pages_data[0]['parent'] as $parent) {

              $luna->table = 'luna_pages_' . $prod_id;
              $luna->id = $parent;
              $stmt = $luna->showAllWhere('id', ['id']);

              $row = $stmt->fetch(PDO::FETCH_ASSOC);
              extract($row);
              $parent_div_arr[] = $row['id'];
          ?>
              <div id="<?= $row['id'] ?>" class='container-pages parent_item px-5 rounded m-2'> <!-- p_1 deve essere l'id della pagina-->
                <?= $row['title'] ?>

                &nbsp;
                <a href="index.php?p=editLunaPage&prod=<?= $prod_id ?>&parent=<?= $row['id'] ?>" class="btn icon icon-left btn-warning shadow"> <i class="bi bi-pencil-square"></i> Edit page</a>
                &nbsp;
                <a href="index.php?p=addLunaPage&prod=<?= $prod_id ?>&parent=<?= $row['id'] ?>" class="btn icon icon-left btn-success shadow"><i data-feather="plus-circle"></i> Add a child page</a>

                <?php
                // check se esistono dei child

                foreach ($pages_data[0]['child'] as $child) {

                  if ($child['parent_id'] == $parent) {
                ?>
                    <a class="btn icon btn-sm btn-info mx-2" data-bs-toggle="collapse" href="#child_<?= $row['id'] ?>" role="button" aria-expanded="false" aria-controls="child_<?= $row['id'] ?>">
                      <i class="bi bi-chevron-down"></i>
                    </a>
                    <div id="child_<?= $row['id'] ?>" class='collapse container-pages child_block p-2 rounded m-2'> <!-- 1 deve essere l'id della pagina-->

                      <?php
                      foreach ($child['id'] as $item) {

                        $luna->table = 'luna_pages_' . $prod_id;
                        $luna->id = $item;
                        $stmt1 = $luna->showAllWhere('id', ['id']);


                        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                        extract($row1);
                        $child_div_arr[] = $row1['id'];
                      ?>
                        <div id="p_<?= $row['id'] ?>_c_<?= $row1['id'] ?>" class="child_item rounded m-2">

                          <?= $row1['title'] ?>
                          <a href="index.php?p=editLunaPage&prod=<?= $prod_id ?>&parent=<?= $row['id'] ?>&child=<?= $row1['id'] ?>" class="btn icon icon-left btn-warning shadow"> <i class="bi bi-pencil-square"></i> Edit page</a>
                          &nbsp;
                          <a href="index.php?p=addLunaPage&prod=<?= $prod_id ?>&parent=<?= $row['id'] ?>&child=<?= $row1['id'] ?>" class="btn icon icon-left btn-success shadow"><i data-feather="plus-circle"></i> Add a paragraph</a>
                          <?php

                          foreach ($pages_data[0]['paragraph'] as $par) {

                            if ($par['child_id'] == $row1['id']) {
                          ?>
                              <a class="btn icon btn-sm btn-info mx-2 " data-bs-toggle="collapse" href="#paragraph_<?= $row1['id'] ?>" role="button" aria-expanded="false" aria-controls="paragraph_<?= $row1['id'] ?>">
                                <i class="bi bi-chevron-down"></i>
                              </a> &nbsp;
                              <div id="paragraph_<?= $row1['id'] ?>" class='collapse container-pages paragraph_block p-2 rounded m-2'><!-- 1 deve essere l'id della pagina child a cui appartengono i paragrafi-->

                                <?php

                                foreach ($par['id'] as $par_id) {

                                  $luna->table = 'luna_pages_' . $prod_id;
                                  $luna->id = $par_id;
                                  $stmt2 = $luna->showAllWhere('id', ['id']);

                                  $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                  extract($row2);
                                  $paragraph_div_arr[] = $row2['id'];
                                ?>
                                  <div id="c_<?= $row1['id'] ?>_p_<?= $row2['id'] ?>" class="paragraph_item rounded m-2">
                                    <?= $row2['title'] ?>
                                  </div>
                                <?php
                                }
                                ?>

                              </div>
                          <?php
                            }
                          }
                          ?>
                        </div>
                      <?php
                      }
                      ?>
                      <!-- fine child -->
                    </div>
                <?php
                  }
                }
                ?>
                <!-- fine div pagine -->
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