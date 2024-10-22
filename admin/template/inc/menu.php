<ul>
    <?php
    $page_order = [];
    $link = "";
    $link_child = "";

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
            $page_name = str_replace('_', ' ', ucfirst($row['page_name']));
            $link = $root . $row['page_name'] . ".php";
            $class = "";
            if ($one && $str != "login") {
                $link = "#$str";
                $class = "class=\"scrolly\"";
            }

        ?>

            <li>
                <a href="<?= $link ?>" <?= $class ?>>
                    <?php
                    if ($name == 'index') {
                        echo "Home";
                    } else if ($name == "Post" || $name == "Blog") {
                        echo "Blog";
                    } else if ($name == 'Contact') {
                        echo $page_contact;
                    } else {
                        echo $name;
                    } ?>
                </a>
            <?php




        }


        

                if ($num > 0) {
                    $stmt1 = $menu->showAllChildInMenu();

                ?>
                    <ul>
                        <?php
                        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                            extract($row1);
                            $str1 = $row1['pagename'];

                            if ($name == "Post" || $name == "Blog") {
                                $str1 = "blog";
                            }
                            $str1 = preg_replace('/\s+/', '_', $str1);
                            $str1 = strtolower($str1);
                            $page_order[] = $str1;
                            $link_child = $root . $str1 . ".php";

                            if ($str1 == "itinerario_educativo") {
                                $link_child = "uploads/download.php?id=4";
                            }
                            if ($str1 == "news") {
                                $link_child = "blog.php?cat=2";
                            }


                            if ($one && $str1 != "login") {
                                $link = "#$str1";
                                $class = "class=\"scrolly\"";
                            }
                        ?>
                            <li style="white-space: nowrap;"><a href="<?= $link_child ?>" style="display: block;" <?= $class ?>><?php
                                                                                                                                if ($row1['pagename'] == 'index') {
                                                                                                                                    echo "Home";
                                                                                                                                } else {
                                                                                                                                    echo $row1['pagename'];
                                                                                                                                } ?></a>
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