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


<section class="section">
  <div class="card shadow">
    <div class="card-body">
      <div class='wrapper'>
        <div id="alert-placeholder"></div>

        <!-- Blocco Parent -->
        <div id='parent-block' class='container-pages p-3'>
          <h4>In menu</h4>
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
            <div id="<?= $row['id'] ?>" class='container-pages parent_item px-5 rounded m-2'>
              <b><?= $page_name ?></b>
              <a class="btn icon btn-sm btn-info mx-2 shadow" data-bs-toggle="collapse" href="#child_<?= $row['id'] ?>" role="button" aria-expanded="false" aria-controls="child_<?= $row['id'] ?>">
                <i class="bi bi-chevron-down"></i>
              </a>

              <div id="child_<?= $row['id'] ?>" class='collapse container-pages child_block p-2 rounded m-2'>
                <?php
                // Se il parent ha child, li mostriamo qui
                foreach ($pages_data['child'] as $child) {
                  if ($child['parent_id'] == $parent) {
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
                  }
                }
                ?>
              </div>
            </div>
          <?php
          }
          ?>
        </div>

        <!-- Blocco NoMenu -->
        <div id='nomenu-block' class='container-pages p-3'>
          <h4>No Menu Pages</h4>
          <?php
          foreach ($pages_data['nomenu'] as $nomenu) {
            $mc->table = 'mc_pages';
            $mc->id = $nomenu;

            $stmt = $mc->showAllWhere('id', ['id']);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            $nomenu_div_arr[] = $row['id'];

            $page_name = $row['page_name'];
            $page_name = str_replace('_', ' ', $page_name);
            $page_name = ucfirst($page_name);
          ?>
            <div id="<?= $row['id'] ?>" class='container-pages nomenu_item rounded m-2'>
              <b><?= $page_name ?></b>
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
  // Array per il drag and drop
  var blocks_array = [
    document.getElementById('parent-block'),
    document.getElementById('nomenu-block')
  ];

  // Aggiungi i blocchi child per il drag and drop
  <?php
  foreach ($parent_div_arr as $item) {
  ?>
    blocks_array.push(document.getElementById('child_<?= $item ?>'));
  <?php
  }
  ?>

  // Configura Dragula
  dragula(blocks_array, {
    moves: function(el, container, handle) {
      // Permetti di spostare tutti i div all'interno di parent-block e nomenu-block
      return true;
    },
    accepts: function(el, target) {
      // Permetti il drop solo nei blocchi container-pages e nomenu
      return target.classList.contains('container-pages') || target.id === 'nomenu-block';
    }
  }).on('drop', function(el, target, source, sibling) {
    // Log dell'elemento rilasciato per il debug
    console.log('Element dropped:', el.id, 'into', target.id);
  });

  // Funzione per salvare l'ordine
  $("#save").click(function() {
    let orderedItems = [];
    let nomenuItems = [];

    // Scansiona parent-block e salva gli elementi ordinati
    $('#parent-block').find('.parent_item, .child_item').each(function() {
      let id = this.id;
      if (id && /^[0-9]+$/.test(id)) {
        orderedItems.push({
          id: id,
          livello: $(this).parents('.container-pages').length - 1 // Calcola il livello
        });
      }
    });

    // Scansiona nomenu-block per salvare i nomenu
    $('#nomenu-block').find('.nomenu_item').each(function() {
      let id = this.id;
      if (id && /^[0-9]+$/.test(id)) {
        nomenuItems.push({
          id: id,
          livello: 0 // Livello per i nomenu
        });
      }
    });

    console.log("orderedItems -> ", orderedItems);
    console.log("nomenuItems -> ", nomenuItems);

    // AJAX per salvare i dati
    $.ajax({
      url: 'core/mngMenu.php',
      method: 'POST',
      data: {
        orderedItems: orderedItems, // Non convertirli manualmente in JSON
        nomenuItems: nomenuItems
      },
      success: function(response) {
        if (response.success) {
          showAlert(response.message, 'success');
        } else {
          showAlert(response.message, 'danger');
        }
      },
      error: function(xhr, status, error) {
        console.error('Errore AJAX:', error);
        showAlert('Si è verificato un errore durante la richiesta AJAX.', 'danger');
      }
    });
  });

  // Funzione per mostrare l'alert
  function showAlert(message, type) {
    $('#alert-placeholder').html(
      '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
      message +
      '<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>' +
      '</div>'
    );
  }
</script>