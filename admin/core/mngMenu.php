<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

require __DIR__ . "/coreConfig.php";

$setting->name = "lang";
$stmt = $setting->showByName();
$lang = $stmt['value'];

foreach (glob("../locale/$lang/*.php") as $row) {
    require "$row";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['orderedItems'])) {
        $orderedItems = $_POST['orderedItems']; // Dovrebbe essere già un array
        $nomenuItems = $_POST['nomenuItems'];  // Anche questo dovrebbe essere un array

        // Verifica i dati
        error_log(print_r($orderedItems, true));
        error_log(print_r($nomenuItems, true));

        // Creazione di una struttura gerarchica degli ID delle pagine
        $hierarchicalStructure = createTree($orderedItems, $nomenuItems);

        // Converte la struttura gerarchica in formato JSON
        $jsonContent = json_encode($hierarchicalStructure);

        // Salva il contenuto JSON su un file
        $menu_file = '../inc/menu/menu.json';
        if (file_put_contents($menu_file, $jsonContent) === false) {
            // Errore durante il salvataggio del file
            error_log('Errore nel salvataggio del file JSON.');
            $response = [
                'success' => false,
                'message' => 'Errore nel salvataggio del file JSON.',
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            chmod($menu_file, 0777);
            $response = [
                'success' => true,
                'message' => 'Ordine pagine salvato',
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    } else {
        // Se il parametro 'orderedItems' non è presente nella richiesta POST, invia una risposta JSON con un messaggio di errore
        $response = [
            'success' => false,
            'message' => 'Parametro "orderedItems" non trovato nella richiesta POST.'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    // Se il metodo HTTP non è consentito, invia una risposta JSON con un messaggio di errore
    $response = [
        'success' => false,
        'message' => 'Metodo HTTP non consentito. Si prega di utilizzare il metodo POST.'
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Funzione per creare una struttura gerarchica degli ID delle pagine
function createTree($orderedItems, $nomenuItems) {
    $tree = [];
    $parent = [];
    $child_map = []; // Mappa per i child

    // Creazione struttura per gli orderedItems
    foreach ($orderedItems as $item) {
        $id = $item['id'];
        $level = $item['livello'];

        if ($level == 0) {
            // È una pagina parent
            $parent[] = $id;
        } else if ($level == 2) {
            // È una pagina child
            $parent_id = end($parent); // Prendi l'ultimo parent
            if (!isset($child_map[$parent_id])) {
                $child_map[$parent_id] = [];
            }
            $child_map[$parent_id][] = $id;
        }
    }

    // Creazione struttura per i nomenuItems
    $nomenu_tree = [];
    foreach ($nomenuItems as $item) {
        $nomenu_tree[] = $item['id'];
    }

    // Costruisci la struttura finale
    $child_tree = [];
    foreach ($parent as $parent_id) {
        $child_tree[] = [
            "parent_id" => $parent_id,
            "id" => isset($child_map[$parent_id]) ? $child_map[$parent_id] : []
        ];
    }

    // Combinazione della struttura
    $tree = [
        'parent' => $parent,
        'child' => $child_tree,
        'nomenu' => $nomenu_tree
    ];

    return $tree;
}

