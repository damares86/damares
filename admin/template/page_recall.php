
                
                <?php
               
               $stmt=$page->showByName();
               $type="custom";
               $count=$page->counter;
                ?>
                <div id="content">
                <?php
                if (isset($_SESSION['loggedin'])) {
            
                    ?>
                <div class="text-right">
                    
                    <a href="admin/index.php?man=page&op=edit&idToMod=<?=$page->id?>&type=<?=$type?>&count=<?=$count?>" class="btn btn-primary btn-sm"><b><?=$regpage_site_edit?></b></a>
                </div>
                    <?php
                }
                $json=$page_class;
                if($one) {
                    $json=$page_req;

                }              
                $json_file = 'admin/inc/pages/'.$json.'.json';
                $data = file_get_contents($json_file);
                $json_arr = json_decode($data, true);
                
                $counter=$page->counter;
                
                for($i=1;$i<=$counter;$i++){
                    
                    ?>




<div class="block block<?=$i?> <?=$page->layout?> <?=$page_class?>" style="background-color:<?=$json_arr[$i]['block'.$i.'_bg']?> !important; color:<?=$json_arr[$i]['block'.$i.'_text']?> !important;">
    
    <?php
    
                             if($json_arr[$i]['block'.$i.'_type']=="t"){
                     
                          
                                echo $json_arr[$i]['block'.$i.''];



                             }else if($json_arr[$i]['block'.$i.'_type']=="p"){
                                $pict=$json_arr[$i]['block'.$i.'_pict'];
                                ?>

                                <img src="uploads/img/<?=$pict?>">
                                <?php
                             }else if($json_arr[$i]['block'.$i.'_type']=="q"){
                                if(is_file("admin/inc/quotes.json")){
                                    $json_file = 'admin/inc/quotes.json';
                                    $data = file_get_contents($json_file);
                                    $quotes = json_decode($data, true);
                                    $countQuotes=count($quotes);
                                    ?>
                                    <div class="slideshow-container">
                                        <?php

                                    for($idx=0;$idx<$countQuotes;$idx++){
                                        ?>
                                        <div class="mySlides">
                                        <q><?=$quotes[$idx]['quote']?></q>
                                        <p class="author"><?=$quotes[$idx]['author']?></p>
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
                                }else{
                                    ?>

                                    <p><?=$quote_noquote?></p>

                                    <?php
                                }
                             }else if($json_arr[$i]['block'.$i.'_type']=="i"){
                                $info=$json_arr[$i]['block'.$i.'_info'];
                                ?>
                                <div class="row">
                                    <div class="col-3">
                                        <img src="uploads/img/<?=$info?>">
                                    </div>
                                    <div class="col-9">
                                        <?php
                                            echo $json_arr[$i]['block'.$i.'_desc'];
                                        ?>
                                    </div>
                                </div>
                                <?php
                             }else if($json_arr[$i]['block'.$i.'_type']=="b"){

                                $stmt1=$post->showLastPosts();
            
                                while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
        
                                    extract($row);
                                    ?>
                                    <div class="row m-1">
                                        <div class="col-12 col-md-5 img_blog">
                                            <img src="uploads/img/<?=$main_img?>">
                                        </div>
                                        <div class="col-12 col-md-7">
                                        <b><?=$title?></b><br>
                                        <a href="post.php?id=<?=$id?>&title=<?=$post_title?>"><?=$blog_continue?> -></a>
                                        </div>
                                    </div>
                            
                                    
                                    <?php
                                }
                         }else{
                            $folder_name=$json_arr[$i]['block'.$i.'_type'];
                            $gallery_name=str_replace("_"," ",$folder_name);
                            $gallery_name=ucfirst($gallery_name);
                            ?>
                            <script>
                            $('#myCarousel<?php echo $i?>').carousel({
                                interval: 2000,
                                cycle: true
                            })
                        </script>

                        <div id="titleCarousel<?=$i?>">
                            <h2>
                                <?=$gallery_name?> 
                            </h2>
                        </div>
                        <div id="myCarousel<?=$i?>" class="carousel slide gallery" data-ride="carousel">
                            <ol class="carousel-indicators">
                            <?php

                            $dirCarousel="misc/gallery/img/$folder_name/";

                            $idx=0;
                            foreach (glob($dirCarousel."*") as $file) {
                                
                                $active="";
                                if($idx==0){
                                $active="class=\"active\"";
                                }
                            
                            ?>
                            <li data-target="#myCarousel<?=$i?>" data-slide-to="<?=$i?>" <?=$class?>></li>
                            <?php

                                $idx++;
                            }
                            ?>
                            </ol>
                            <div class="carousel-inner">

                            <?php
                            $idx=0;
                            foreach (glob($dirCarousel."*") as $file) {
                                $img=pathinfo($file, PATHINFO_FILENAME);
                                $ext=pathinfo($file, PATHINFO_EXTENSION);
                                $imgName=$img.".".$ext;

                                $active="";
                                if($idx==0){
                                $active="active";
                                }

                                $numberArr=array('first','second','third','fourth','fifth','sixth','seventh','eighth','ninth','tenth');

                                $number=$numberArr[$i];

                                ?>
                            <div class="carousel-item <?=$active?>">
                                <a href="<?=$dirCarousel?>/<?=$imgName?>">
                                    <img class="<?=$number?>-slide" src="<?=$dirCarousel?>/<?=$imgName?>" alt="<?=$number?> slide" class="gallery">
                                </a>
                            </div>
                            <?php
                            $idx++;
                            }
                            ?>
                            
                            </div>
                            <a class="carousel-control-prev" href="#myCarousel<?=$i?>" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#myCarousel<?=$i?>" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>

                        <?php
                         }
                         ?>
                </div>
                <?php    
                }
             
              ?>
                    <div class="clearfix"></div>