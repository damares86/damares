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




    header('Content-Type: application/json');

    if (isset($_POST['orderedItems']) && isset($_POST['nomenuItems'])) {
        $orderedItems = json_decode($_POST['orderedItems'], true);
        $nomenuItems = json_decode($_POST['nomenuItems'], true);

        // Carica i dati esistenti dal file JSON
        $menuFilePath = '../inc/menu/menu.json';
        $menuData = json_decode(file_get_contents($menuFilePath), true);

        // Pulire i dati esistenti
        $menuData['parent'] = [];
        $menuData['child'] = [];
        $menuData['nomenu'] = [];

        // Aggiornare la sezione parent e child
        foreach ($orderedItems as $item) {
            // Aggiungi il parent
            $menuData['parent'][] = $item['id'];

            // Aggiungi i child
            if (isset($item['children']) && !empty($item['children'])) {
                $menuData['child'][] = [
                    'parent_id' => $item['id'],
                    'id' => $item['children'] // Assicurati che 'id' contenga i children
                ];
            }
        }

        // Aggiornare la sezione nomenu
        foreach ($nomenuItems as $nomenu) {
            $menuData['nomenu'][] = $nomenu['id'];
        }

        // Salva i dati aggiornati nel file JSON
        if (file_put_contents($menuFilePath, json_encode($menuData, JSON_PRETTY_PRINT))) {
            echo json_encode(['success' => true, 'message' => 'Menu salvato con successo']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Errore durante il salvataggio del file JSON.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Parametro "orderedItems" o "nomenuItems" non trovato nella richiesta POST.']);
    }







}
