<div id="content" class="container">
    <?php
    $counter=$page_counter;

    if (isset($_SESSION['loggedin'])) {
    ?>
        <div class="text-right">

            <a href="admin/index.php?p=editPage&idToMod=<?= $page_id ?>&count=<?= $counter ?>" class="btn btn-primary btn-sm"><b><?=$fe_edit ?></b></a>
        </div>
    <?php
    }
    if ($one) {
        $page_id = $page_req;
    }
    $json_file = 'admin/inc/pages/'.$page_id.'.json';
    $data = file_get_contents($json_file);
    $json_arr = json_decode($data, true);
    
    for($i=1;$i<=$counter;$i++){

    ?>




        <div class="block block<?= $i ?> <?= $page_layout ?> <?= $page_class ?>" style="background-color:<?= $json_arr[$i]['block' . $i . '_bg'] ?> !important; color:<?= $json_arr[$i]['block' . $i . '_text'] ?> !important;">

            <?php

            if ($json_arr[$i]['block' . $i . '_type'] == "text") {


                echo $json_arr[$i]['block' . $i . ''];
            } else if ($json_arr[$i]['block' . $i . '_type'] == "img") {
                $pict = $json_arr[$i]['block' . $i . '_pict'];
            ?>

                <img src="uploads/img/<?= $pict ?>">
                <?php
            } else if ($json_arr[$i]['block' . $i . '_type'] == "quote") {
                $mc->table = 'mc_quotes';
                if ($mc->countAll() > 0) {
                    $mc->table = 'mc_quotes';
                    $quote_stmt = $mc->showAll('id') ;
                    
                ?>
                    <div class="slideshow-container">
                        <?php
                while($quote_row = $quote_stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($quote_row);
                        ?>
                            <div class="mySlides">
                                <q><?=$quote_row['quote'] ?></q>
                                <p class="author"><?= $quote_row['author'] ?></p>
                            </div>
                        <?php
                        }
                        ?>

                        <a class="prev" onclick="plusSlides(-1)">❮</a>
                        <a class="next" onclick="plusSlides(1)">❯</a>

                    </div>

                    <div class="dot-container">
                        <span class="dot" onclick="currentSlide(1)"></span>
                        <span class="dot" onclick="currentSlide(2)"></span>
                        <span class="dot" onclick="currentSlide(3)"></span>
                    </div>
                <?php
                } else {
                ?>

                    <p><?= $quote_noquote ?></p>

                <?php
                }
            } else if ($json_arr[$i]['block' . $i . '_type'] == "info") {
                $info = $json_arr[$i]['block' . $i . '_info'];
                ?>
                <div class="row">
                    <div class="col-3">
                        <img src="uploads/img/<?= $info ?>">
                    </div>
                    <div class="col-9">
                        <?php
                        echo $json_arr[$i]['block' . $i . '_desc'];
                        ?>
                    </div>
                </div>
                <?php
            } else if ($json_arr[$i]['block' . $i . '_type'] == "post") {

                $post->table = 'post' ;
                if($json_arr[$i]['block'.$i.'_cat']!= 'none'){
                    $post->category_id = $json_arr[$i]['block'.$i.'_cat'] ;
                    $stmt1 = $post->showAllWhere('id',['category_id'],3);
                }else{
                    $stmt1 = $post->showAllLimitDesc('id',3);
                }

                while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {

                    extract($row);
                ?>
                    <div class="row m-1">
                        <?php
                            if($row['main_img'] != NULL){
                        ?>
                                <div class="col-12 col-md-5 img_blog">
                                    <img src="uploads/img/<?= $main_img ?>">
                                </div>
                        <?php
                            }
                        ?>
                        <div class="col-12 col-md-7">
                            <b><?= $title ?></b><br>
                            <a href="post.php?id=<?= $id ?>&title=<?= $post_title ?>"><?= $blog_continue ?> -></a>
                        </div>
                    </div>


                <?php
                }
            } else if ($json_arr[$i]['block' . $i . '_type'] == "gallery"){
                $mc->table = 'mc_galleries' ;
                $mc->id = $json_arr[$i]['block_' . $i ];

                $stmt_gallery = $mc->showAllWhere('id',['id']);
                $row_gallery = $stmt_gallery->fetch(PDO::FETCH_ASSOC);
                extract($row_gallery);

                $title_gallery = ucfirst( $row_gallery['gallery_name']);

                ?>
                <script>
                    $('#myCarousel<?php echo $i ?>').carousel({
                        interval: 2000,
                        cycle: true
                    })
                </script>

                <div id="titleCarousel<?= $i ?>">
                        <h2>
                            <?=$title_gallery?>
                        </h2>
                    </div>
                <div id="myCarousel<?= $i ?>" class="carousel slide gallery" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php

                        $dirCarousel = "uploads/gallery/g_".$json_arr[$i]['block_' . $i];

                        $idx = 0;
                        foreach (glob($dirCarousel . "*") as $file) {

                            $active = "";
                            if ($idx == 0) {
                                $active = "class=\"active\"";
                            }

                        ?>
                            <li data-target="#myCarousel<?= $i ?>" data-slide-to="<?= $i ?>" <?= $class ?>></li>
                        <?php

                            $idx++;
                        }
                        ?>
                    </ol>
                    <div class="carousel-inner">

                        <?php
                        $idx = 0;
                        foreach (glob($dirCarousel . "/*") as $file) {
                            $img = pathinfo($file, PATHINFO_FILENAME);
                            $ext = pathinfo($file, PATHINFO_EXTENSION);
                            $imgName = $img . "." . $ext;

                            $active = "";
                            if ($idx == 0) {
                                $active = "active";
                            }

                            $numberArr = array('first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'tenth');

                            $number = $numberArr[$i];

                        ?>
                            <div class="carousel-item <?= $active ?>">
                                <a href="<?= $dirCarousel ?>/<?= $file ?>">
                                    <img class="gallery <?= $number ?>-slide" src="<?= $dirCarousel ?>/<?= $imgName ?>" alt="<?= $number ?> slide">
                                </a>
                            </div>
                        <?php
                            $idx++;
                        }
                        ?>

                    </div>
                    <a class="carousel-control-prev" href="#myCarousel<?= $i ?>" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#myCarousel<?= $i ?>" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <?= $row_stretch_end ?>
            <?php
            }

            ?>
        </div>
    <?php
    }

    ?>
    <div class="clearfix"></div>