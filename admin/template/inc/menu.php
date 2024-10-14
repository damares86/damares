<ul>
    <?php
    $page_order=[];
    $link="";
    $link_child="";

    if($page_class=="login"&&$one){
        
?>

<li><a href="index.php#index" <?=$class?> ><- <?=$login_back_home?> </a></li>


    <?php
    }else{

    $stmt=$menu->showAllParent();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $class="";
        $name=$row['pagename'];
        $name=ucfirst($name);
        $str=$row['pagename'];
        $str = preg_replace('/\s+/', '_', $str);
        $str = strtolower($str);
        $page_order[]=$str;
        $link=$root.$str.".php";
        
        if($str=="attivita"){
            $link="blog.php?cat=3";
        }

        $class="";
        if($one&&$str!="login"){
            $link="#$str";
            $class="class=\"scrolly\"";
        }
        ?>
        <li><a href="<?=$link?>" <?=$class?> ><?php
        if($name=='index'){
            echo "Home";
        } else if($name=="Post"||$name=="Blog"){
            echo "Blog";
        }else if($name=='Contact'){
            echo "Contatti";
        }else{
        echo $name;
        }?></a>
        <?php
                
                $menu->childof=$name;
                $num=$menu->countChildInMenu();
                
                if($num>0){
                $stmt1=$menu->showAllChildInMenu();         
        
                ?>
                <ul>
                <?php
                  while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                        extract($row1);
                        $str1=$row1['pagename'];
                        
                        if($name=="Post"||$name=="Blog"){
                            $str1="blog";
                        }
                        $str1 = preg_replace('/\s+/', '_', $str1);
                        $str1 = strtolower($str1);
                        $page_order[]=$str1;
                        $link_child=$root.$str1.".php";
                        
                        if($str1=="itinerario_educativo"){
                            $link_child="uploads/download.php?id=4";
                        }
                        if($str1=="news"){
                            $link_child="blog.php?cat=2";
                        }


                        if($one&&$str1!="login"){
                            $link="#$str1";
                            $class="class=\"scrolly\"";
                        }
                        ?>
                            <li style="white-space: nowrap;"><a href="<?=$link_child?>" style="display: block;"  <?=$class?> ><?php
                                if($row1['pagename']=='index'){
                                    echo "Home";
                                } else {
                                echo $row1['pagename'];
                                }?></a>
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
    }
    ?>

</ul>