<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

require __DIR__ . "/coreConfig.php";

// ORIG
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if (isset($_POST['orderedItems'])) {


        $orderedItems = json_decode($_POST['orderedItems'], true);
        $orderedItems = array(
            array('id' => 6, 'livello' => 1),
            array('id' => 51, 'livello' => 2),
            array('id' => 69, 'livello' => 2),
            array('id' => 85, 'livello' => 2),
            array('id' => 91, 'livello' => 3),
            array('id' => 88, 'livello' => 2),
            array('id' => 9, 'livello' => 1),
            array('id' => 52, 'livello' => 2),
            array('id' => 90, 'livello' => 3),
            array('id' => 70, 'livello' => 2),
            array('id' => 86, 'livello' => 2)
        );

        // ORIG        
        // $prod_arr = json_decode($_POST['additionalData'], true);
        // $prod_id = $prod_arr['luna_product_id'];



        // In questo punto, $orderedItems contiene l'array dei dati gerarchici delle pagine
        // Puoi procedere con la manipolazione e l'elaborazione dei dati come desideri
        // Ad esempio, puoi creare l'array gerarchico qui

        // Creazione di una struttura gerarchica degli ID delle pagine
        $hierarchicalStructure = createTree($orderedItems);

        echo "finale: ";
        print_r($hierarchicalStructure);
        echo "<br>";
        exit;
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

// ORIG
//     } else {
//         // Se il parametro 'orderedItems' non è presente nella richiesta POST, invia una risposta JSON con un messaggio di errore
//         $response = [
//             'success' => false,
//             'message' => 'Parametro "orderedItems" non trovato nella richiesta POST.'
//         ];
//         header('Content-Type: application/json');
//         echo json_encode($response);
//     }
// } else {
//     // Se il metodo HTTP non è consentito, invia una risposta JSON con un messaggio di errore
//     $response = [
//         'success' => false,
//         'message' => 'Metodo HTTP non consentito. Si prega di utilizzare il metodo POST.'
//     ];
//     header('Content-Type: application/json');
//     echo json_encode($response);
// }

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
                    $tree['parent'][] = $id;

                }else if($level == 2){

                    // è una pagina di livello child
                    if($previous_level == 1){
                        
                        // la pagina precedente era un parent, quindi è una sua child
                        if(!isset($tree['child'])){
                            $tree['child'] = [];
                        }

                        $inserted = 0 ;
                        foreach($tree['child'] as $item){
                            print_r($item);
                            echo "<br>";
                            if($item['parent_id'] == $previous_parent){
                                $item['id'][] = $id ;
                                $inserted ++;
                            }
                        }

                        echo "previous parent: ".$previous_parent ;
                        echo "<br>";
                        echo "id: ".$id ;
                        echo "<br>";
                        echo "inserted: ".$inserted ;
                        echo "<br>";

                        if($inserted == 0){
                            $tree['child'][] = array("parent_id" => $previous_parent, "id" => [$id]) ;
                        }

                    }else if($previous_level == 3){

                        if(!isset($tree['paragraph'])){
                            $tree['paragraph'] = [];
                        }

                        $inserted = 0 ;
                        foreach($tree['paragraph'] as $item){
                            if($item['child_id'] == $previous_child){
                                $item['id'][] = $id ;
                                $inserted ++;
                            }
                        }

                        if($inserted == 0){
                            $tree['paragraph'][] = array("child_id" => $previous_child, "id" => [$id]) ;
                        }

                    }
                }else if($level == 3){
                    
                    if(!isset($tree['paragraph'])){
                        $tree['paragraph'] = [];
                    }

                    $inserted = 0 ;
                    foreach($tree['paragraph'] as $item){
                        if($item['child_id'] == $previous_child){
                            $item['id'][] = $id ;
                            $inserted ++;
                        }
                    }

                    if($inserted == 0){
                        $tree['paragraph'][] = array("child_id" => $previous_child, "id" => [$id]) ;
                    }

                }
                echo "------------------------------<br>";
            } else if ($previous_level == $level) {

                if($level == 1){

                    // è un parent
                    $tree['parent'][] = $id;

                }else if($level == 2){
                    echo "id stesso livello: ".$id;
                    echo "<br>";
                    $inserted = 0 ;
                    foreach($tree['child'] as $item){
                        print_r($item);
                        if($item['parent_id'] == $previous_parent){
                            $item['id'][] = $id ;
                            echo "<br>item dopo: ";
                            print_r($item);
                            echo "<br>";
                            $inserted ++;
                        }
                    }

                    // if($inserted == 0){
                    //     $tree['child'][] = array("parent_id" => $previous_parent, "id" => [$id]) ;
                    // }
                    
                }else if($level == 3){
                    
                    if(!isset($tree['paragraph'])){
                        $tree['paragraph'] = [];
                    }

                    $inserted = 0 ;
                    foreach($tree['paragraph'] as $item){
                        if($item['child_id'] == $previous_child){
                            $item['id'][] = $id ;
                            $inserted ++;
                        }
                    }

                    if($inserted == 0){
                        $tree['paragraph'][] = array("child_id" => $previous_child, "id" => [$id]) ;
                    }
                    
                }

            }
            echo "------------------------------<br>";


        } else {

            // è il primo giro
            $tree['parent'][] = [];
            $tree['parent'][] = $id;
        }

        // $previous_id = $id;
        $previous_level = $level;
        if($level == 1){
            $previous_parent = $id ;
        }else if($level == 2){
            $previous_child = $id ;
        }

    }

    return $tree;
}
