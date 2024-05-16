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


if (filter_input(INPUT_GET, "idPageToDel")) {

    $idToDel = filter_input(INPUT_GET, "idPageToDel");
    $prod_id = filter_input(INPUT_GET, "prod");

    $luna->table = "luna_pages_$prod_id";
    $luna->id = $idToDel;
    $stmt = $luna->showAllWhere('id', ['id']);
    $page_content = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($page_content);

    $luna->table = "luna_pages_$prod_id";
    $luna->id = $idToDel;

    if ($luna->delete('id')) {
        // provo a rifare il file dell'ordine
        // se va bene sostituisco il bck e poi cancello dal db
        // se va male ripristino il bck 

        $pages_json = file_get_contents('../inc/luna_pages/pages_' . $prod_id . '.json');
        $pages_data = json_decode($pages_json, true);

        // ciclo i parent
        $parent_arr = [];
        $parent_delete = '';
        if (filter_input(INPUT_GET, 'type')) {

            $parent_delete = $idToDel;

            foreach ($pages_data['parent'] as $parent) {
                if ($parent != $row['id']) {
                    $parent_arr[] = $parent;
                }
            }
        } else {
            $parent_arr = $pages_data['parent'];
        }

        // ciclo i child   
        $child_tree = [];
        $child_tot = [];
        $child_delete = '';
        $paragraph_tree = [];
        if (filter_input(INPUT_GET, 'parent_id')) {

            // sto cancellando un child

            $child_delete = $idToDel;
            $counter = 0;
            foreach ($pages_data['child'] as $child) {
                $child_label = 'child_' . $child['parent_id'];
                if (is_array($child['id']) && in_array($child_delete, $child['id'])) {

                    // devo ciclare dentro l'array quello precedente, escludendo l'id da cancellare
                    foreach ($child['id'] as $item) {
                        if ($item != $idToDel) {
                            $$child_label[] = $item;
                            $child_tot[] = $item;
                        }
                    }
                } else {
                    // butto dentro l'array così com'è

                    if (is_array($child['id'])) {
                        $$child_label = $child['id'];
                    } else {
                        $$child_label = null;
                    }
                    foreach ($child['id'] as $item) {
                        $child_tot[] = $item;
                    }
                }
            }

            // ricreo l'array di array dei child

            foreach ($parent_arr as $item) {
                $child_arr = 'child_' . $item;
                $child_tree[] = array("parent_id" => $item, "id" => $$child_arr);
            }
        } else {
            // replicare child, tenendo conto di parent_delete o child_delete

            // sto cancellando un parent o un paragrafo
            if ($parent_delete) {

                foreach ($pages_data['child'] as $child) {
                    if ($child['parent_id'] != $parent_delete) {
                        $child_label = 'child_' . $child['parent_id'];
                        // non è il child del parent che sto eliminando
                        foreach ($child['id'] as $item) {
                            $$child_label[] = $item;
                            $child_tot[] = $item;
                        }
                    }
                }

                foreach ($parent_arr as $item) {
                    $child_arr = 'child_' . $item;
                    $child_tree[] = array("parent_id" => $item, "id" => $$child_arr);
                }
            } else {
                // non sto cancellando nè un parent nè un paragrafo
                foreach ($pages_data['child'] as $item) {
                    $child_tree[] = array("parent_id" => $item['parent_id'], "id" => $item['id']);
                    foreach ($item['id'] as $id) {
                        $child_tot[] = $id;
                    }
                }
            }
        }

        // ciclo i paragraph   
        $paragraph_tree = [];
        if (filter_input(INPUT_GET, 'child_id')) {

            // sto cancellando un paragrafo

            $counter = 0;
            foreach ($pages_data['paragraph'] as $paragraph) {

                if (in_array($paragraph['child_id'], $child_tot)) {
                    // è paragrafo di un child che non è stato cancellato
                    $paragraph_label = 'paragraph_' . $paragraph['child_id'];

                    if (is_array($paragraph['id'])) {

                        // devo ciclare dentro l'array quello precedente, escludendo l'id da cancellare
                        foreach ($paragraph['id'] as $item) {
                            if ($item != $idToDel) {
                                $$paragraph_label[] = $item;
                            }
                        }
                    } else {
                        // butto dentro l'array così com'è
                        $$paragraph_label = null;
                    }
                }
            }

            // ricreo l'array di array dei child

            foreach ($child_tot as $item) {
                $paragraph_arr = 'paragraph_' . $item;
                $paragraph_tree[] = array("child_id" => $item, "id" => $$paragraph_arr);
            }
        } else {
            // sto cancellando un parent o un child
            foreach ($pages_data['paragraph'] as $paragraph) {
                if (in_array($paragraph['child_id'], $child_tot)) {
                    $paragraph_label = 'paragraph_' . $paragraph['child_id'];
                    if (is_array($paragraph['id'])) {
                        foreach ($paragraph['id'] as $item) {
                            $$paragraph_label[] = $item;
                        }
                    } else {
                        $$paragraph_label = null;
                    }
                }
            }

            foreach ($child_tot as $item) {
                $paragraph_arr = 'paragraph_' . $item;
                $paragraph_tree[] = array("child_id" => $item, "id" => $$paragraph_arr);
            }
        }

        $new_pages_data = ['parent' => $parent_arr, 'child' => $child_tree, 'paragraph' => $paragraph_tree];
        $jsonContent = json_encode($new_pages_data);

        $real_file = '../inc/luna_pages/pages_' . $prod_id . '.json';
        $bck_file = '../inc/luna_pages_bck/pages_' . $prod_id . '.json';

        if (file_put_contents($real_file, $jsonContent)) {
            chmod($real_file, 0777);
            unlink($bck_file);
            copy($real_file, $bck_file);
            chmod($bck_file, 0777);
            header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaDeleteSucc");
            exit;
        } else {
            unlink($real_file);
            copy($bck_file,$real_file);
            chmod($real_file,0777);
            header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaDeletesTreeFail");
            exit;
        }
    }else{
        header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaDeletePageFail");
        exit;
    }
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
        $bck_file = '../inc/luna_pages_bck/pages_' . $prod_id . '.json';

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


            if (filter_input(INPUT_POST, 'child_id')) {

                $child_id = filter_input(INPUT_POST, 'child_id');
                $inserted = '';

                foreach ($pages_data['paragraph'] as $item) {

                    if ($item['child_id'] == $child_id) {
                        $item['id'][] = $page_id;
                        $inserted = true;
                    }

                    $par_arr[] = $item;
                }

                if (!$inserted) {
                    $par_arr[] = ['child_id' => $child_id, 'id' => [$page_id]];
                }


                $new_pages_data = ['parent' => $pages_data['parent'], 'child' => $pages_data['child'], 'paragraph' => $par_arr];
            } else if (filter_input(INPUT_POST, 'parent_id')) {

                $parent_id = filter_input(INPUT_POST, 'parent_id');
                $inserted = '';

                foreach ($pages_data['child'] as $item) {

                    if ($item['parent_id'] == $parent_id) {
                        $item['id'][] = $page_id;
                        $inserted = true;
                    }

                    $child_arr[] = $item;
                }

                if (!$inserted) {
                    $child_arr[] = ['parent_id' => $parent_id, 'id' => [$page_id]];
                }


                $new_pages_data = ['parent' => $pages_data['parent'], 'child' => $child_arr, 'paragraph' => $pages_data['paragraph']];
            } else {

                $pages_data['parent'][] = $page_id;
                $new_pages_data = ['parent' => $pages_data['parent'], 'child' => $pages_data['child'], 'paragraph' => $pages_data['paragraph']];
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

            $new_pages_data = ['parent' => [$page_id], 'child' => [], 'paragraph' => []];
            $jsonContent = json_encode($new_pages_data);

            if (file_put_contents($real_file, $jsonContent, FILE_APPEND)) {

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

    $luna->id = $idToMod;
    $luna->title = $title;
    $luna->content = $content;
    $luna->last_editor = $_SESSION['account_id'];
    $luna->table = 'luna_pages_' . $prod_id;

    if ($luna->update(['title', 'content', 'last_editor'], 'id')) {
        header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentEditSucc");
        exit;
    } else {
        header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentEditTreeFail");
        exit;
    }
} else {
    header("Location: ../index.php?err=noPost");
    exit;
}
