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
                if ($parent['child']) {
                ?>
                    <ul>
                        <?php
                        foreach ($parent['child'] as $child) {
                            $mc->table = 'mc_pages';
                            $mc->id = $parent['id'];

                            $stmt1 = $mc->showAllWhere('id', ['id']);
                            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                            extract($row1);
                            $page_name = str_replace('_', ' ', ucfirst($row1['page_name']));
                            $link_child = $root . $row1['page_name'] . ".php";
                        ?>
                            <li style="white-space: nowrap;"><a href="<?= $link_child ?>" style="display: block;" <?= $class ?>>
                                    <?php
                                    if ($row1['pagename'] == 'index') {
                                        echo "Home";
                                    } else {
                                        echo $row1['page_name'];
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