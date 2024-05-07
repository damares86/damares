<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

use Composer\InstalledVersions;

require __DIR__ . "/coreConfig.php";

// check if there's a customer to delete

if (filter_input(INPUT_GET, "idToDel")) {

    // TODO

}


$operation = filter_input(INPUT_POST, "operation");

// check if there's a customer to edit or add

if ($operation == "editLunaProduct") {
    $idToMod = filter_input(INPUT_POST, "idToMod");
    $luna->id = $idToMod;
    $luna->name = filter_input(INPUT_POST, "name");
    $luna->version = filter_input(INPUT_POST, "version");
    $luna->table = 'luna_products';

    if ($luna->update(['name', 'version'], 'id')) {
        header("Location:../index.php?p=editLunaProduct&msg=lunaProdEditSucc&idToMod=$idToMod");
        exit;
    } else {
        header("Location:../index.php?p=editLunaProduct&err=lunaProdEditFail&idToMod=$idToMod");
        exit;
    }
} else if ($operation == "addLunaProduct") {

    $luna->name = filter_input(INPUT_POST, 'name');
    $luna->version = filter_input(INPUT_POST, 'version');
    $luna->table = 'luna_products';

    if ($luna->insert(['name', 'version'])) {
        $luna->table = 'luna_products';
        $luna->name = filter_input(INPUT_POST, 'name');
        $stmt = $luna->showAllWhere('id', ['name']);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $query_text = "CREATE TABLE IF NOT EXISTS luna_pages_" . $row['id'] . "
        ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        last_editor INT(5) NOT NULL,
        last_edit_time datetime DEFAULT CURRENT_TIMESTAMP)";

        if (!$db->query($query_text)) {
            $luna->table = 'luna_products';
            $luna->id = $row['id'];
            $luna->delete('id');
            header('Location:../index.php?p=allLunaProducts&err=lunaProdFailDb');
            exit;
        } else {
            header('Location:../index.php?p=allLunaProducts&msg=lunaProdSucc');
            exit;
        }
    } else {
        header('Location:../index.php?p=allLunaProducts&err=lunaProdFail');
        exit;
    }
} else if ($operation == 'addPage') {
    // $type = filter_input(INPUT_POST,'type') ;
    $prod_id = filter_input(INPUT_POST, 'product_id');
    $luna->table = 'luna_pages_' . $prod_id;
    $luna->title = filter_input(INPUT_POST, 'title');
    $luna->content = filter_input(INPUT_POST, 'content');
    $luna->last_editor = $_SESSION['account_id'];

    if ($luna->insert(['title', 'content', 'last_editor'])) {
        $luna->table = 'luna_pages_' . $prod_id;
        $luna->title = filter_input(INPUT_POST, 'title');
        $stmt = $luna->showAllWhere('id', ['title']);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $page_id = $row['id'];

        $real_file = '../inc/luna_pages/pages_' . $prod_id . '.json';
        $bck_file = '../inc/luna_pages/bck/pages_' . $prod_id . '.json';

        if (file_exists($real_file)) {
            //   - leggo il file
            //   - ricompongo l'array:
            //      - se pagina parent la metto al fondo
            //      - se pagina child o paragrafo, recupero l'id di riferimento e quando lo 
            //            incontro ciclando l'array inserisco la pagina appena aggiunta al posto giusto
            //   - elimino il file di backup
            //   - copio in bck il file esistente
            //   - se la copia va a buon fine, elimino il file originale nella cartella principale
            //   - ricreo il file con il nuovo array
            //   SE FALLISCE QUALCOSA:
            //      - ripristino il file originale dal bck
            //      - cosa ne faccio della pagina?
            
            
            $pages_json = file_get_contents('../inc/luna_pages/pages_' . $prod_id . '.json');
            $pages_data = json_decode($pages_json, true);

            // $new_pages_data = [] ;

            if (filter_input(INPUT_POST, 'child_id')) {
                
                $child_id = filter_input(INPUT_POST, 'child_id');
                $inserted = '' ;

                foreach( $pages_data[0]['paragraph'] as $item){
                    
                    if($item['child_id'] == $child_id ){
                        $item['id'][] = $page_id ;                        
                        $inserted = true ;
                    }

                    $par_arr[] = $item ;
                }
                
                if(!$inserted){
                    $par_arr[] = ['child_id' => $child_id,'id' => [$page_id]];
                }


                $new_pages_data = ['parent' =>$pages_data[0]['parent'],'child' => $pages_data[0]['child'],'paragraph' =>$par_arr] ;

            }else if (filter_input(INPUT_POST, 'parent_id')) {

                $parent_id = filter_input(INPUT_POST, 'parent_id');
                $inserted = '' ;

                foreach( $pages_data[0]['child'] as $item){
                    
                    if($item['parent_id'] == $parent_id ){
                        $item['id'][] = $page_id ;                        
                        $inserted = true ;
                    }

                    $child_arr[] = $item ;
                }
                
                if(!$inserted){
                    $child_arr[] = ['parent_id' => $parent_id,'id' => [$page_id]];
                }


                $new_pages_data = ['parent' =>$pages_data[0]['parent'],'child' => $child_arr,'paragraph' =>$pages_data[0]['paragraph']] ;


            } else{

                $pages_data['parent'][] = $page_id ;

            }
            
            $jsonContent = json_encode($new_pages_data);

            if (file_put_contents($real_file, $jsonContent)) {
                chmod($real_file, 0777);
                unlink($bck_file);
                copy($real_file, $bck_file);
                chmod($bck_file, 0777);
                header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentSucc");
                exit;
            } else {
                header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentTreeFail");
                exit;
            }

        } else {
            // non esiste:
            //   - composizione array
            //   - creo il file nella cartella principale e in quella bck

            $pages = "<?php" . PHP_EOL . "\$pages = [0 => " . $row['id'] . "];" . PHP_EOL . "?>";
            if (file_put_contents($real_file, $pages, FILE_APPEND)) {

                chmod($real_file, 0777);
                $err_bck = '';
                if (!copy($real_file, $bck_file)) {
                    chmod($bck_file, 0777);
                    $err_bck = '&err=bckFileFail';
                }

                header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentSucc");
                exit;
            } else {
            }
        }
    }

} else if ($operation == 'editPage') {

    $idToMod = filter_input(INPUT_POST, 'idToMod');

    $prod_id = filter_input(INPUT_POST, 'product_id');
    $title = filter_input(INPUT_POST, 'title');
    $content = filter_input(INPUT_POST, 'content');

    if (filter_input(INPUT_POST, 'child_id')) {
        // è un paragrafo
        $luna->id = $idToMod;
        $luna->title = $title;
        $luna->content = $content;
        $luna->last_editor = $_SESSION['account_id'];
        $luna->table = 'luna_paragraph';

        if ($luna->update(['title', 'content', 'last_editor'], 'id')) {
            header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentEditSucc");
            exit;
        } else {
            header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentEditTreeFail");
            exit;
        }
    } else if (filter_input(INPUT_POST, 'parent_id')) {
        // è un child
        $luna->id = $idToMod;
        $luna->title = $title;
        $luna->content = $content;
        $luna->last_editor = $_SESSION['account_id'];
        $luna->table = 'luna_child';

        if ($luna->update(['title', 'content', 'last_editor'], 'id')) {

            header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentEditSucc");
            exit;
        } else {
            header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentEditTreeFail");
            exit;
        }
    } else {
        // it's a parent
        $luna->id = $idToMod;
        $luna->title = $title;
        $luna->content = $content;
        $luna->luna_products_id = $prod_id;
        $luna->last_editor = $_SESSION['account_id'];
        $luna->table = 'luna_parent';

        if ($luna->update(['title', 'content', 'luna_products_id', 'last_editor'], 'id')) {

            header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentEditSucc");
            exit;
        } else {
            header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentEditTreeFail");
            exit;
        }
    }
} else {
    header("Location: ../index.php?err=noPost");
    exit;
}
