<ul>
    <?php
    $page_order = [];
    $link = "";
    $link_child = "";

    $plugin->pluginname = "post";

    $post_check = false ;

    if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {

        $post_check = true ;

        $post->table = 'post_categories';
        $cat_stmt = $post->showAll('id');
        $cat_pages = [] ;
        while($cat_row = $cat_stmt->fetch(PDO::FETCH_ASSOC)){
            extract($cat_row);
            if($cat_row['assign_page'] != NULL){
                $cat_pages[] = array($cat_row['assign_page'] => $cat_row['id']) ;
            }
        }

    }



    if ($page_class == "login" && $one) {

    ?>

        <li><a href="index.php#index" <?= $class ?>><- <?= $login_back_home ?> </a></li>

        <?php
    } else {

        $pages_json = file_get_contents('admin/inc/menu/menu.json');
        $pages_data = json_decode($pages_json, true);


        // Iteriamo sui parent
        foreach ($pages_data['inmenu'] as $parent) {
            $mc->table = 'mc_pages';
            $mc->id = $parent['id'];

            $stmt = $mc->showAllWhere('id', ['id']);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            $page_order[] = $row['id'] ;
            $page_name = str_replace('_', ' ', ucfirst($row['page_name']));
            $link = $row['page_name'] . ".php";
            if($post_check){
                $found_value = NULL ;
                foreach ($cat_pages as $page) {
                    if (array_key_exists($row['id'], $page)) {
                        $found_value = $page[$row['id']];
                        break; // Esci dal ciclo una volta trovato
                    }
                }
                if($found_value){
                    $link = 'blog.php?cat='.$found_value ;
                }
            }
            $class = "";
            if ($one && $row['page_name']!= "login") {
                $link = "#".$row['id'];
                $class = "class=\"scrolly\"";
            }

        ?>

            <li>
                <a href="<?= $link ?>" <?= $class ?>>
                    <?php
                    if ($page_name == 'Index') {
                        echo "Home";
                    } else if ($page_name == "Post" || $name == "Blog") {
                        echo "Blog";
                    } else if ($name == 'Contact') {
                        echo $cont_form_page;
                    } else {
                        echo $page_name;
                    } ?>
                </a>
                <?php
                if (array_key_exists('child',$parent)) {
                ?>
                    <ul>
                        <?php
                        foreach ($parent['child'] as $child) {
                            $mc->table = 'mc_pages';
                            $mc->id = $child;

                            $stmt1 = $mc->showAllWhere('id', ['id']);
                            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                            extract($row1);
                            $page_order[] = $row1['id'] ;
                            $child_name = str_replace('_', ' ', ucfirst($row1['page_name']));
                            $link_child = $row1['page_name'] . ".php";
                            if($post_check){
                                $found_value = NULL ;
                                foreach ($cat_pages as $page) {
                                    if (array_key_exists($row1['id'], $page)) {
                                        $found_value = $page[$row1['id']];
                                        break; // Esci dal ciclo una volta trovato
                                    }
                                }
                                if($found_value){
                                    $link_child = 'blog.php?cat='.$found_value ;
                                }
                            }
                            if ($one && $row1['page_name']!= "login") {
                                $link_child = "#".$row1['id'];
                                $class = "class=\"scrolly\"";
                            }
                        ?>
                            <li style="white-space: nowrap;"><a href="<?= $link_child ?>" style="display: block;" <?= $class ?>>
                                    <?php
                                    if ($row1['page_name'] == 'index') {
                                        echo "Home";
                                    } else {
                                        echo $child_name;
                                    } ?>
                                </a>
                            </li>

                        <?php
                        }
                        ?>
                    </ul>
                <?php
                }
                ?>
            </li>
        <?php
        }
        ?>
</ul>
<?php
    }
?>