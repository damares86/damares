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
                    <h4>In Menu</h4>
                    <?php
                    $pages_json = file_get_contents('inc/menu/menu.json');
                    $pages_data = json_decode($pages_json, true);
                    
                    // Iteriamo sui parent
                    foreach ($pages_data['inmenu'] as $parent) {
                        $mc->table = 'mc_pages';
                        $mc->id = $parent['id'];

                        $stmt = $mc->showAllWhere('id', ['id']);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        extract($row);
                        $page_name = str_replace('_', ' ', ucfirst($row['page_name']));
                    ?>
                        <div id="<?= $row['id'] ?>" class='container-pages parent_item px-5 rounded m-2' draggable="true">
                            <b><?= $page_name ?></b>
                            <a class="btn icon btn-sm btn-info mx-2 shadow" data-bs-toggle="collapse" href="#child_<?= $row['id'] ?>" role="button" aria-expanded="false" aria-controls="child_<?= $row['id'] ?>">
                                <i class="bi bi-chevron-down"></i>
                            </a>

                            <div id="child_<?= $row['id'] ?>" class='collapse container-pages child_block p-2 rounded m-2'>
                                <?php
                                if (isset($parent['child'])) {
                                    foreach ($parent['child'] as $childId) {
                                        $mc->table = 'mc_pages';
                                        $mc->id = $childId;
                                        $stmt1 = $mc->showAllWhere('id', ['id']);
                                        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                        extract($row1);
                                ?>
                                        <div id="<?= $row1['id'] ?>" class="child_item rounded m-2" draggable="true">
                                            <b><?= $row1['page_name'] ?></b>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                    <!-- Blocco NoMenu -->
                    <div id='nomenu-block' class='container-pages p-3 bg-warning'>
                        <h4>No Menu Pages</h4>
                        <?php
                        foreach ($pages_data['nomenu'] as $nomenu) {
                            $mc->table = 'mc_pages';
                            $mc->id = $nomenu;
                            $stmt = $mc->showAllWhere('id', ['id']);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            extract($row);
                            $page_name = str_replace('_', ' ', ucfirst($row['page_name']));
                        ?>
                            <div id="<?= $row['id'] ?>" class='container-pages nomenu_item rounded m-2' draggable="true">
                                <b><?= $page_name ?></b>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <button id="save" class="btn btn-success m-3 w-25">Save</button>
    </div>
</section>
<script src='script/dragula.js'></script>
<script>
    // Funzione per inizializzare Dragula
    function initDragula() {
        var drake = dragula([document.getElementById('parent-block'), document.getElementById('nomenu-block')]);

        // Permettere il drop nei child
        drake.containers.push(...document.querySelectorAll('.child_block'));

        drake.on('drop', function(el, target, source, sibling) {
            // Verifica se l'elemento è stato spostato in un parent, un child o un nomenu
            if ($(target).hasClass('child_block')) {
                // Se viene rilasciato in un child_block, è un child
                var parentId = $(target).closest('.parent_item').attr('id');
                $(el).detach().appendTo($('#child_' + parentId));
                $(el).removeClass('parent_item nomenu_item').addClass('child_item'); // Aggiorna le classi
            } else if ($(target).attr('id') === 'parent-block') {
                // Se viene rilasciato nel parent-block, è un parent
                $(el).removeClass('child_item nomenu_item').addClass('parent_item'); // Aggiorna le classi
            } else if ($(target).attr('id') === 'nomenu-block') {
                // Se viene rilasciato nel nomenu-block, è un elemento di nomenu
                $(el).removeClass('parent_item child_item').addClass('nomenu_item'); // Aggiorna le classi
            }

            // Posiziona l'elemento nel target nella posizione corretta
            $(el).detach().appendTo(target);
            if (sibling) {
                // Se c'è un elemento "sibling", posiziona l'elemento prima di esso
                $(el).insertBefore(sibling);
            }

            // Aggiorna il JSON dopo il drop
            updateJSON();
        });

        drake.on('remove', function(el, container) {
            console.log("Element removed:", el.id);
            updateJSON(); // Aggiorna JSON quando un elemento viene rimosso
        });
    }

    // Chiamata per inizializzare Dragula
    initDragula();

    function getInMenuItems() {
        let items = [];

        // Itera su tutti i parent nel blocco parent
        $('#parent-block').children('.parent_item').each(function() {
            let parentId = this.id; // Ottieni l'ID del parent
            let children = [];

            // Cerca i child dentro il blocco collapse relativo al parent
            $(this).find('.child_block .child_item').each(function() {
                children.push(this.id); // Aggiungi l'ID del child
            });

            // Se ci sono child, includili nel JSON come array
            if (children.length > 0) {
                items.push({ id: parentId, child: children });
            } else {
                // Se non ci sono child, aggiungi solo l'ID del parent
                items.push({ id: parentId });
            }
        });

        return items;
    }

    function getNoMenuItems() {
        let noMenuItems = [];

        // Itera su tutti gli elementi nel blocco nomenu
        $('#nomenu-block').children('.nomenu_item').each(function() {
            noMenuItems.push(this.id); // Aggiungi l'ID a nomenu
        });

        return noMenuItems;
    }

    // Funzione per aggiornare il JSON
    function updateJSON() {
        let inMenuItems = getInMenuItems();
        let noMenuItems = getNoMenuItems();

        // Costruisci l'oggetto per il JSON
        let jsonData = {
            inmenu: inMenuItems,
            nomenu: noMenuItems
        };

        console.log("JSON attuale:", jsonData); // Log per debugging

        // AJAX per salvare i dati
        $.ajax({
            url: 'core/mngMenu.php',
            method: 'POST',
            data: {
                menuData: JSON.stringify(jsonData) // Invia il JSON come stringa
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
    }

    // Funzione per il salvataggio
    $("#save").click(function() {
        updateJSON(); // Aggiorna JSON quando si clicca su Salva
    });

    // Funzione per mostrare un alert di successo o errore
    function showAlert(message, type) {
        $('#alert-placeholder').html(
            '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
            message +
            '<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>' +
            '</div>'
        );
    }
</script>
