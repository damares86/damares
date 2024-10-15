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
    if (isset($_POST['orderedItems']) && isset($_POST['nomenuItems'])) {
        // Recupera i dati inviati dal client
        $orderedItems = json_decode($_POST['orderedItems'], true);
        $nomenuItems = json_decode($_POST['nomenuItems'], true);

        // Verifica e prepara la struttura dei dati
        $data = [
            'parent' => [],
            'child' => [],
            'nomenu' => []
        ];

        foreach ($orderedItems as $item) {
            $data['parent'][] = $item['id'];
            // Registriamo i child
            foreach ($item['children'] as $childId) {
                $data['child'][] = [
                    'parent_id' => $item['id'],
                    'id' => [$childId] // Ogni child viene salvato correttamente
                ];
            }
        }

        // Aggiungi i nomenu
        foreach ($nomenuItems as $nomenu) {
            $data['nomenu'][] = $nomenu['id'];
        }

        // Salva nel file JSON
        $json_data = json_encode($data, JSON_PRETTY_PRINT);
        $file_path = '../inc/menu/menu.json'; // Modifica il percorso se necessario

        if (file_put_contents($file_path, $json_data)) {
            $response = [
                'success' => true,
                'message' => 'Menu salvato con successo.'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Errore nel salvataggio del file JSON.'
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Messaggio di errore se mancano i parametri necessari
        $response = [
            'success' => false,
            'message' => 'Parametro "orderedItems" o "nomenuItems" non trovato nella richiesta POST.'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
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

