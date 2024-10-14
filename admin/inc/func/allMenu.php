<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Menu management</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?= $common_dashboard ?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Menu management
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
    <!-- <div class="card-header">Menu management&nbsp; &nbsp; &nbsp;
    </div> -->
    <div class="card-body">

      <div class='wrapper'>
        <div id="alert-placeholder"></div>
        <div id='parent-block' class='container-pages p-3'>

          <?php

          // get menu order
          $pages_json = file_get_contents('inc/menu/menu.json');
          $pages_data = json_decode($pages_json, true);

          foreach ($pages_data['parent'] as $parent) {

            $mc->table = 'mc_pages';
            $mc->id = $parent;

            $stmt = $mc->showAllWhere('id', ['id']);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            $parent_div_arr[] = $row['id'];

            $page_name = $row['page_name'];
            $page_name = str_replace('_', ' ', $page_name);
            $page_name = ucfirst($page_name);
          ?>
            <div id="<?= $row['id'] ?>" class='container-pages parent_item px-5 rounded m-2'> <!-- p_1 deve essere l'id della pagina-->
              <b><?= $page_name ?></b>
              <a class="btn icon btn-sm btn-info mx-2 shadow" data-bs-toggle="collapse" href="#child_<?= $row['id'] ?>" role="button" aria-expanded="false" aria-controls="child_<?= $row['id'] ?>">
                <i class="bi bi-chevron-down"></i>
              </a>

              <?php

              // check se esistono dei child

              foreach ($pages_data['child'] as $child) {

                if ($child['parent_id'] == $parent) {
              ?>

                  <div id="child_<?= $row['id'] ?>" class='collapse container-pages child_block p-2 rounded m-2'> <!-- 1 deve essere l'id della pagina-->

                    <?php
                    foreach ($child['id'] as $item) {

                      $mc->table = 'mc_pages';
                      $mc->id = $item;
                      $stmt1 = $mc->showAllWhere('id', ['id']);


                      $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                      extract($row1);
                      $child_div_arr[] = $row1['id'];
                    ?>
                      <div id="<?= $row1['id'] ?>" class="child_item rounded m-2">

                        <b> <?= $row1['page_name'] ?></b>
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
      // Utilizza una regex per verificare se l'ID è numerico
      let id = this.id;
      if (id && /^[0-9]+$/.test(id)) {
        let elementId = this.id;
        let elementLevel = $(this).parents('.container-pages').length;

        if (elementLevel > 1) {
          elementLevel = elementLevel - 1
        }
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

    console.log(orderedItems);
    // Funzione per mostrare l'alert di Bootstrap
    function showAlert(message, type) {
      $('#alert-placeholder').html(
        '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
        message +
        '<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span>' +
        '</button>' +
        '</div>'
      );
    }
    // Invia l'array al server utilizzando AJAX

    $.ajax({
      url: 'core/mngLunaOrder.php', // URL della pagina PHP per il salvataggio
      method: 'POST', // Metodo HTTP da utilizzare
      data: postData, // Dati da inviare (convertiti in stringa JSON)
      success: function(response) {
        if (response.success) {
          showAlert(response.message, 'success');
        } else {
          showAlert(response.message, 'danger');
        }
      },
      error: function(xhr, status, error) {
        console.error('Errore AJAX:', error);
        $('.alert-danger').html('Si è verificato un errore durante la richiesta AJAX.').fadeIn();
      }
    });
  });
</script>