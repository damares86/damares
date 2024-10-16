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

                        $page_name = str_replace('_', ' ', ucfirst($row['page_name']));
                    ?>
                        <div id="<?= $row['id'] ?>" class='container-pages parent_item px-5 rounded m-2' draggable="true">
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
                                            <div id="<?= $row1['id'] ?>" class="child_item rounded m-2" draggable="true"> <!-- Rendi i child draggable -->
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
                            $nomenu_div_arr[] = $row['id'];

                            $page_name = str_replace('_', ' ', ucfirst($row['page_name']));
                        ?>
                            <div id="<?= $row['id'] ?>" class='container-pages nomenu_item rounded m-2' draggable="true"> <!-- Rendi anche i nomenu draggable -->
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
    // Funzione per mantenere l'ordine degli elementi
    function getOrderedItems(container) {
        let items = [];
        $(container).children('.parent_item, .child_item, .nomenu_item').each(function() {
            let id = this.id;
            let children = [];

            // Se il div è un parent, aggiungi i suoi child
            if ($(this).hasClass('parent_item')) {
                // Cattura i child solo se esistono
                $(this).find('.child_item').each(function() {
                    children.push(this.id);
                });
            }

            items.push({
                id: id,
                children: children // Aggiunge i children trovati
            });
        });
        return items;
    }

    // Inizializzazione di Dragula
    var drake = dragula([
        document.getElementById('parent-block'),
        document.getElementById('nomenu-block'),
        ...document.querySelectorAll('.child_block')
    ], {
        moves: function(el, container, handle) {
            return true; // Permetti sempre il movimento
        },
        accepts: function(el, target, source, sibling) {
            return true; // Consenti a tutti gli elementi di essere rilasciati in qualsiasi target
        }
    }).on('drop', function(el, target, source, sibling) {
        // Rinfresca i contenitori dopo il drop
        refreshContainers();
    });

    // Rinfresca i contenitori per assicurarsi che l'ordine sia corretto
    function refreshContainers() {
        console.log("Containers refreshed.");
    }

    // Funzione per il salvataggio
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
                orderedItems: JSON.stringify(orderedItems), // Aggiorna il formato per mantenere la struttura
                nomenuItems: JSON.stringify(nomenuItems) // Aggiorna il formato per mantenere la struttura
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

    function showAlert(message, type) {
        $('#alert-placeholder').html(
            '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
            message +
            '<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>' +
            '</div>'
        );
    }
</script>
