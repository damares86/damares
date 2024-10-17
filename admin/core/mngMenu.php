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

    if (isset($_POST['menuData'])) {
        // Decodifica i dati inviati dal frontend
        $menuData = json_decode($_POST['menuData'], true);

        // Percorso al file menu.json
        $menuFilePath = '../inc/menu/menu.json';

        // Salva i dati aggiornati nel file JSON
        if (file_put_contents($menuFilePath, json_encode($menuData, JSON_PRETTY_PRINT))) {
            echo json_encode(['success' => true, 'message' => 'Menu salvato con successo']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Errore durante il salvataggio del file JSON.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Parametro "menuData" non trovato nella richiesta POST.']);
    }
}