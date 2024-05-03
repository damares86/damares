<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__ . "/coreConfig.php";

// check if there's a customer to delete

if (filter_input(INPUT_GET, "idToDel")) {

    // TODO

}

if ($_SERVER["REQUEST_METHOD"] == "POST" && filter_input(INPUT_POST,'page_prod_id')) {

    // Funzione ricorsiva per costruire la struttura gerarchica dell'array
function buildHierarchy($items, $parentId = null) {
    $branch = array();

    foreach ($items as $item) {
        if ($item['livello'] == $parentId) {
            $children = buildHierarchy($items, $item['livello'] + 1);
            if ($children) {
                $item['child'] = $children;
            }
            $branch[] = $item;
        }
    }

    return $branch;
}
if (isset($_POST['orderedItems'])) {
    // Decodifica i dati JSON inviati e ottieni l'array $orderedItems
    $orderedItems = json_decode($_POST['orderedItems'], true);
}
// Chiama la funzione per costruire la struttura gerarchica dell'array
$hierarchy = buildHierarchy($orderedItems);

$pages = "<?php".PHP_EOL.$hierarchy.PHP_EOL."?>";

if (file_put_contents('../inc/luna_pages/prova.php', $pages, FILE_APPEND)) {

    chmod($real_file, 0777);
 
    header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentSucc");
    exit;

} 
// Output dell'array gerarchico
echo "<pre>";
print_r($hierarchy);
echo "</pre>";

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

        $real_file = '../inc/luna_pages/pages_' . $prod_id . '.php';
        $bck_file = '../inc/luna_pages/bck/pages_' . $prod_id . '.php';

        if (file_exists($real_file)) {
            //   - leggo il file
            //   - ricompongo l'array:
            //      - se pagina parent la metto al fondo
            //      - se pagina child o pragrafo, recupero l'id di riferimento e quando lo 
            //            incontro ciclando l'array inserisco la pagina appena aggiunta al posto giusto
            //   - elimino il file di backup
            //   - copio in bck il file esistente
            //   - se la copia va a buon fine, elimino il file originale nella cartella principale
            //   - ricreo il file con il nuovo array
            //   SE FALLISCE QUALCOSA:
            //      - ripristino il file originale dal bck
            //      - cosa ne faccio della pagina?





        } else if (file_exists('../inc/luna_pages/pages_' . $prod_id . '.php')) {
            // stessa cosa di sopra
            // alla fine però creo il file nella cartella principale
            // e se va bene elimino il bck e copio quello principale in bck




        } else {
            // non esiste:
            //   - composizione array
            //   - creo il file nella cartella principale e in quella bck

            $pages = "<?php".PHP_EOL."\$pages = [0 => ".$row['id']."];".PHP_EOL."?>";
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


    // if (filter_input(INPUT_POST, 'child_id')) {
    //     // è un paragrafo
    //     $child_id = filter_input(INPUT_POST, 'child_id');

    //     $luna->title = $title;
    //     $luna->content = $content;
    //     $luna->last_editor = $_SESSION['account_id'];
    //     $luna->table = 'luna_paragraph';

    //     if ($luna->insert(['title', 'content', 'last_editor'])) {
    //         $luna->table = 'luna_paragraph';
    //         $luna->title = $title;
    //         $stmt1 = $luna->showAllWhere('id', ['title']);
    //         $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    //         extract($row1);

    //         // get the paragraphs of the child page
    //         $luna->table = 'luna_child_paragraph';
    //         $luna->child_pages_id = $child_id;

    //         if ($luna->itemExists('child_pages_id')) {

    //             $stmt = $luna->showAllWhere('id', ['child_pages_id']);
    //             $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //             extract($row);

    //             $arr = explode(',', $row['paragraph_id_arr']);
    //             $arr[] = $row1['id'];
    //             $str = implode(',', $arr);

    //             $luna->table = 'luna_child_paragraph';
    //             $luna->id = $row['id'];
    //             $luna->paragraph_id_arr = $str;

    //             if ($luna->update(['paragraph_id_arr'], 'id')) {
    //                 header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentSucc");
    //                 exit;
    //             } else {
    //                 header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentTreeFail");
    //                 exit;
    //             }
    //         } else {
    //             $luna->table = 'luna_child_paragraph';
    //             $luna->child_pages_id = $child_id;
    //             $luna->paragraph_id_arr = $row1['id'];
    //             if ($luna->insert(['child_pages_id', 'paragraph_id_arr'])) {
    //                 header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentSucc");
    //                 exit;
    //             } else {
    //                 header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentTreeFail");
    //                 exit;
    //             }
    //         }
    //     } else {
    //         header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentFail");
    //         exit;
    //     }
    // } else if (filter_input(INPUT_POST, 'parent_id')) {
    //     // è un child
    //     $parent_id = filter_input(INPUT_POST, 'parent_id');

    //     $luna->title = $title;
    //     $luna->content = $content;
    //     $luna->last_editor = $_SESSION['account_id'];
    //     $luna->table = 'luna_child';

    //     if ($luna->insert(['title', 'content', 'last_editor'])) {
    //         $luna->table = 'luna_child';
    //         $luna->title = $title;
    //         $stmt1 = $luna->showAllWhere('id', ['title']);
    //         $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    //         extract($row1);

    //         // get the paragraphs of the child page
    //         $luna->table = 'luna_parent_child';
    //         $luna->parent_pages_id = $parent_id;
    //         if ($luna->itemExists('parent_pages_id')) {
    //             $stmt = $luna->showAllWhere('id', ['parent_pages_id']);
    //             $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //             extract($row);

    //             $arr = explode(',', $row['child_pages_id_arr']);
    //             $arr[] = $row1['id'];
    //             $str = implode(',', $arr);

    //             $luna->table = 'luna_parent_child';
    //             $luna->id = $row['id'];
    //             $luna->child_pages_id_arr = $str;

    //             if ($luna->update(['child_pages_id_arr'], 'id')) {
    //                 header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentSucc");
    //                 exit;
    //             } else {
    //                 header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentTreeFail");
    //                 exit;
    //             }
    //         } else {
    //             $luna->table = 'luna_parent_child';
    //             $luna->parent_pages_id = $parent_id;
    //             $luna->child_pages_id_arr =  $row1['id'];
    //             if ($luna->insert(['parent_pages_id', 'child_pages_id_arr'])) {
    //                 header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentSucc");
    //                 exit;
    //             } else {
    //                 header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentTreeFail");
    //                 exit;
    //             }
    //         }
    //     } else {
    //         header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentFail");
    //         exit;
    //     }
    // } else {
    //     // it's a parent
    //     $luna->title = $title;
    //     $luna->content = $content;
    //     $luna->luna_products_id = $prod_id;
    //     $luna->last_editor = $_SESSION['account_id'];
    //     $luna->table = 'luna_parent';

    //     if ($luna->insert(['title', 'content', 'luna_products_id', 'last_editor'])) {
    //         $luna->table = 'luna_parent';
    //         $luna->title = $title;

    //         $stmt1 = $luna->showAllWhere('id', ['title']);
    //         $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    //         extract($row1);

    //         // get the parent order for the product
    //         $luna->table = 'luna_parent_order';
    //         $luna->luna_products_id = $prod_id;

    //         if ($luna->itemExists('luna_products_id')) {
    //             // there are already parent pages for this product
    //             $stmt = $luna->showAllWhere('id', ['luna_products_id']);
    //             $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //             extract($row);

    //             // add the page to the other parent pages
    //             $arr = explode(',', $row['parent_pages_id_arr']);
    //             $arr[] = $row1['id'];
    //             $str = implode(',', $arr);

    //             $luna->table = 'luna_parent_order';
    //             $luna->id = $row['id'];
    //             $luna->parent_pages_id_arr = $str;

    //             if ($luna->update(['parent_pages_id_arr'], 'id')) {
    //                 header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentSucc");
    //                 exit;
    //             } else {
    //                 header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentTreeFail");
    //                 exit;
    //             }
    //         } else {
    //             // it's the first parent page for the product
    //             $luna->table = 'luna_parent_order';
    //             $luna->luna_products_id = $prod_id;
    //             $luna->parent_pages_id_arr =  $row1['id'];
    //             if ($luna->insert(['parent_pages_id_arr', 'luna_products_id'])) {
    //                 header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentSucc");
    //                 exit;
    //             } else {
    //                 header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentTreeFail");
    //                 exit;
    //             }
    //         }
    //     } else {
    //         header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentFail");
    //         exit;
    //     }
    // }
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
