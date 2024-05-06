<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

require __DIR__ . "/coreConfig.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['orderedItems'])) {
        $orderedItems = json_decode($_POST['orderedItems'], true);
        // $orderedItems = array(
        //     array('id' => 1, 'livello' => 1),
        //     array('id' => 2, 'livello' => 1),
        //     array('id' => 3, 'livello' => 2),
        //     array('id' => 4, 'livello' => 1),
        //     array('id' => 5, 'livello' => 2),
        //     array('id' => 6, 'livello' => 3)
        // );
        $prod_arr = json_decode($_POST['additionalData'], true);

        $prod_id = $prod_arr['luna_product_id'];

        // In questo punto, $orderedItems contiene l'array dei dati gerarchici delle pagine
        // Puoi procedere con la manipolazione e l'elaborazione dei dati come desideri
        // Ad esempio, puoi creare l'array gerarchico qui

        // Creazione di una struttura gerarchica degli ID delle pagine
        $hierarchicalStructure = createTree($orderedItems);

        // Converte la struttura gerarchica in formato JSON
        $jsonContent = json_encode($hierarchicalStructure);

        // Salva il contenuto JSON su un file
        $real_file = '../inc/luna_pages/pages_' . $prod_id . '.json';
        $bck_file = '../inc/luna_pages/bck/pages_' . $prod_id . '.json';

        if (file_put_contents($real_file, $jsonContent)) {

            chmod($real_file, 0777);
            $response = [
                'success' => true, // o false se c'è stato un errore
                'message' => 'Struttura gerarchica salvata correttamente.',
                // Altri dati, se necessario
            ];
            // Imposta l'intestazione JSON
            header('Content-Type: application/json');

            // Invia la risposta come JSON
            echo json_encode($response);
        } else {
            unlink($real_file);
            copy($real_file, $bck_file);
            $response = [
                'success' => false, // o false se c'è stato un errore
                'message' => 'File non aggiornato',
                // Altri dati, se necessario
                // Imposta l'intestazione JSON
            ];
            header('Content-Type: application/json');

            // Invia la risposta come JSON
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
function createTree($orderedItems)
{
    $tree = [];
    $previous_id = '';
    $previous_parent = '';
    $previous_child = '';
    $previous_level = '';

    foreach ($orderedItems as $item) {
        $id = $item['id'];
        $level = $item['livello'];

        if (isset($previous_level)) {
            // non è il primo giro

            if ($previous_level != $level) {

                // è cambiato il livello

                if ($level == 1) {

                    // è una pagina parent, va al livello principale
                    $tree[] = $id;

                }else if($level == 2){

                    // è una pagina di livello child
                    if($previous_level == 1){
                        
                        // la pagina precedente era un parent, quindi è una sua child
                        if(!isset($tree[$previous_id]['child'])){
                            $tree[$previous_id]['child'] = [];
                        }
                        $tree[$previous_id]['child'][] = $id;

                    }else if($previous_level == 3){

                        // la pagina precedente era un paragrafo, quindi torna su di un livello
                        if(!isset($tree[$previous_parent]['child'])){
                            $tree[$previous_parent]['child'] = [];
                        }
                        $tree[$previous_parent]['child'][] = $id;

                    }
                }else if($level == 3){
                    
                    // è un paragrafo
                    if(!isset($tree[$previous_parent][$previous_child]['paragraph'])){
                        $tree[$previous_parent][$previous_child]['paragraph'] = [];
                    }
                    $tree[$previous_parent][$previous_child]['paragraph'] = $id;
                }

            } else if ($previous_level == $level) {

                if($level == 1){

                    // è un parent
                    $tree[] = $id;

                }else if($level == 2){

                    // è un child
                    $tree[$previous_parent]['child'][] = $id;
                    
                }else if($level == 3){
                    
                    // è un paragrafo
                    $tree[$previous_parent][$previous_child]['paragraph'][] = $id;
                    
                }

            }
        } else {

            // è il primo giro
            $tree[] = [];
            $tree[] = $id;
        }

        $previous_id = $id;
        $previous_level = $level;
        if($level == 1){
            $previous_parent = $id ;
        }else if($level == 2){
            $previous_child = $id ;
        }

    }

    return $tree;
}
