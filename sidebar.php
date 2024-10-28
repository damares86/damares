<div id="sidebar">
            <div id="sidebar_menu">
                <h2><strong><?= $blog_cat ?></strong></h2>
                <ul>
                    <?php
                    $post->table = "post_categories";
                    $all_cat = $post->showAll('id');
                    while ($row_all_cat = $all_cat->fetch(PDO::FETCH_ASSOC)) {

                        extract($row_all_cat);
                    ?>
                        <li><a href="blog.php?cat=<?= $row_all_cat['id'] ?>"><?= $row_all_cat['category_name'] ?></a></li>
                    <?php

                    }
                    ?>
                </ul>
            </div>
        </div>