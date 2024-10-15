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
                <h4>No Menu Pages</h4>
                <div id='nomenu-block' class='container-pages p-3'>
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
    // Funzione per mantenere l'ordine degli elementi
    function getOrderedItems(container) {
        let items = [];
        $(container).children('.parent_item, .child_item, .nomenu_item').each(function() {
            let id = this.id;
            if (this.classList.contains('parent_item')) {
                let children = $(this).find('.child_item').map(function() {
                    return this.id;
                }).get();

                items.push({
                    id: id,
                    livello: 1,
                    children: children
                });
            } else {
                items.push({ id: id, livello: 0 });
            }
        });
        return items;
    }

    // Configurazione Dragula
    var drake = dragula([
        document.getElementById('parent-block'),
        document.getElementById('nomenu-block'),
        ...document.querySelectorAll('.child_block')
    ], {
        moves: function(el, container, handle) {
            return true; // Permetti il movimento
        },
        accepts: function(el, target) {
            return target.classList.contains('container-pages'); // Permetti solo nei blocchi designati
        }
    }).on('drop', function(el, target, source, sibling) {
        console.log("Elemento spostato:", el.id, "da:", source.id, "a:", target.id); // Log evento drop

        // Rimuovi l'elemento originale dalla sorgente
        if (source.id !== target.id) {
            target.appendChild(el);
            console.log("Elemento aggiunto:", el.id, "in target:", target.id); // Log di registrazione

            // Cambia la classe se l'elemento viene spostato in parent-block
            if (target.id === 'parent-block') {
                $(el).removeClass('nomenu_item').addClass('child_item'); // Cambia classe
                console.log("Classe cambiata:", el.id, "a child_item");
            }

            // Controlla se l'elemento proviene da 'nomenu-block'
            if (source.id === 'nomenu-block' && target.id === 'parent-block') {
                console.log("Elemento spostato da nomenu a parent:", el.id);
                // Aggiungi qui la logica per registrare l'elemento nel JSON
            }

            // Controlla se l'elemento è un child in 'parent-block'
            if (target.id === 'parent-block') {
                let parentDiv = $(el).closest('.parent_item');
                if (parentDiv.length) {
                    let parentId = parentDiv.attr('id');
                    console.log("Child spostato in parent:", el.id, "in parent:", parentId);
                    // Aggiungi qui la logica per registrare l'elemento nel JSON
                }
            }
        }
    }).on('dragend', function(el) {
        console.log("Drag ended for:", el.id); // Log quando il drag termina
    });

    // Salva l'ordine al click
    $("#save").click(function() {
        let orderedItems = getOrderedItems('#parent-block');
        let nomenuItems = getOrderedItems('#nomenu-block');

        // Debugging: log di cosa viene registrato
        console.log("orderedItems -> ", orderedItems);
        console.log("nomenuItems -> ", nomenuItems);

        // AJAX per salvare i dati
        $.ajax({
            url: 'core/mngMenu.php',
            method: 'POST',
            data: {
                orderedItems: JSON.stringify(orderedItems),
                nomenuItems: JSON.stringify(nomenuItems)
            },
            success: function(response) {
                console.log("Risposta ricevuta:", response); // Log risposta
                if (response.success) {
                    showAlert(response.message, 'success');
                } else {
                    showAlert(response.message, 'danger');
                }
            },
            error: function(xhr, status, error) {
                console.error('Errore AJAX:', error); // Log errori AJAX
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
