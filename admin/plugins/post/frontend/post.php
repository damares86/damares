<?php


?>
<?php
function getCurrentUrl()
{
    // Determina se la connessione è sicura (HTTPS)
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    // Ottieni il nome dell'host (es. www.example.com)
    $host = $_SERVER['HTTP_HOST'];

    // Ottieni la richiesta completa (es. /cartella/pagina.php?param1=valore1&param2=valore2)
    $requestUri = $_SERVER['REQUEST_URI'];

    // Combina tutti i pezzi per ottenere l'URL completo
    $currentUrl = $protocol . $host . $requestUri;

    return $currentUrl;
}

$url = getCurrentUrl();

require "admin/template/inc/header.php";

?>
<section class="blog py-5 bg-light">
    <div class="container">
        <div class="row gx-5">
            <div class="col-12 col-lg-8 blog_body">
                <?php

                $catArr = explode(",", $post_title_row['category_id']);

                $time = $post_title_row['created'];
                $newTime = date("d/m/Y", strtotime($time));


                if (isset($_SESSION['loggedin'])) {

                ?>
                    <div class="text-right">

                        <a href="admin/index.php?p=editPost&idToMod=<?= $post_title_row['id'] ?>" class="btn btn-primary btn-sm"><b><?= $post_edit ?></b></a>
                    </div>
                <?php
                }

                $catPage = "";
                if (filter_input(INPUT_GET, 'cat')) {
                    $catOrigin = filter_input(INPUT_GET, 'cat');
                    $catPage = "?cat=$catOrigin";
                }

                ?>
                <a href="blog.php<?= $catPage ?>"><- <?= $post_back ?></a>
                        <br><br>
                        <h1><?= $post_title_row['title'] ?></h1>
                        <div class="small text-muted mb-3">
                            <?= $newTime ?> -
                            <?php
                            $account->id = $post_title_row['author'];
                            $author_stmt = $account->showAllWhere('id', ['id']);
                            $author_row = $author_stmt->fetch(PDO::FETCH_ASSOC);
                            extract($author_row);
                            ?>
                            <b><?= $author_row['username'] ?></b><br>
                            <?php
                            foreach ($catArr as $arr) {
                                $post->table = 'post_categories';
                                $post->id = $arr;
                                $stmt_cat = $post->showAllWhere('id', ['id']);
                                $row_cat = $stmt_cat->fetch(PDO::FETCH_ASSOC);
                                extract($row_cat);
                            ?>
                                <a class="badge bg-secondary text-decoration-none link-light" href="blog.php?cat=<?= $row_cat['id'] ?>"><?= $row_cat['category_name'] ?></a>
                            <?php
                            }

                            ?>

                            </p>
                            <div class="blog_content">
                                <?php
                                if ($post_title_row['main_img'] != NULL) {
                                ?>
                                    <div class="row mb-3">
                                        <div class="col px-5">
                                            <img src="uploads/img/<?= $post_title_row['main_img'] ?>" class="post_img justify-content-center mx-auto"><br>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <?= $post_title_row['content'] ?>
                                <br><br>
                                <?php
                                $gallery = $post_title_row['gall'];
                                if ($gallery != "none") {
                                ?> <!-- Script -->
                                    <script type='text/javascript'>
                                        $(document).ready(function() {

                                            // Intialize gallery
                                            var gallery = $('.gallery a').simpleLightbox();

                                        });
                                    </script>
                                    <div class="gallery">
                                        <div class="row p-2">
                                            <?php

                                            // Image extensions
                                            $image_extensions = array("png", "jpg", "jpeg", "JPG");

                                            $dir = "uploads/gallery/g_" . $post_title_row['gall'] . "/";

                                            if (is_dir($dir)) {

                                                if ($dh = opendir($dir)) {
                                                    $count = 1;

                                                    // Read files
                                                    while (($file = readdir($dh)) !== false) {

                                                        if ($file != '' && $file != '.' && $file != '..') {

                                                            // Thumbnail image path
                                                            $thumbnail_path = $dir . $file;

                                                            // Image path
                                                            $image_path = $dir . $file;

                                                            $thumbnail_ext = pathinfo($thumbnail_path, PATHINFO_EXTENSION);
                                                            $image_ext = pathinfo($image_path, PATHINFO_EXTENSION);

                                                            // Check its not folder and it is image file
                                                            if (
                                                                !is_dir($image_path) &&
                                                                in_array($thumbnail_ext, $image_extensions) &&
                                                                in_array($image_ext, $image_extensions)
                                                            ) {
                                            ?>

                                                                <!-- Image -->
                                                                <div class="col-md-4 col-lg-3">
                                                                    <a href="<?php echo $image_path; ?>">
                                                                        <img src="<?php echo $thumbnail_path; ?>" alt="" title="" class="gallery">
                                                                    </a>
                                                                </div>
                                                                <!-- --- -->
                                                                <?php

                                                                // Break
                                                                if ($count % 4 == 0) {
                                                                ?>
                                                                    <div class="clear"></div>
                                            <?php
                                                                }
                                                                $count++;
                                                            }
                                                        }
                                                    }
                                                    closedir($dh);
                                                }
                                            }
                                            ?>
                                        </div>





                                    </div>
                                <?php
                                }
                                ?>

                                <!-- <div class="border p-3">
                                    <?= $post_share ?>: &nbsp;

                                    <a href="https://twitter.com/share?url=<?= $url ?>" target="_blank" onclick="window.open(this.href,'window','width=640,height=480,resizable,scrollbars') ;return false;">
                                        <i class="fab fa-twitter"></i></a>

                                    &nbsp; &nbsp; <a href="https://www.facebook.com/sharer.php?u=<?= $url ?>" target="_blank" onclick="window.open(this.href,'window','width=640,height=480,resizable,scrollbars') ;return false;">
                                        <i class="fab fa-facebook"></i></a>

                                    &nbsp; &nbsp;
                                    <script src="https://platform.linkedin.com/in.js" type="text/javascript">
                                        lang: en_US
                                    </script>
                                    <script type="IN/Share" data-url="<?= $url ?>"></script>

                                    <br>
                                </div> -->
                            </div>

                        </div>

            </div>
            <?php

            require "sidebar.php";

            ?>

            <div class="clearfix"></div>
        </div>
</section>

<?php
require "admin/template/inc/footer.php";

?>