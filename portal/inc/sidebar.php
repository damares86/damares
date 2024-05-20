<div id="sidebar" class="active">
        <div class="sidebar-wrapper active">
          <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
              <!-- <div class="logo"> -->
              <div class="logo px-5">
                <a href="index.php">
                  <img src="assets/img/logo/damares_logo.png" alt="Logo" srcset=""/>
                </a>
              </div>            
            </div>
          </div>
          <div class="col-12 col-lg-3">
              <div class="card">
                <div class="card-body py-4 px-4">
                  <div class="d-flex align-items-center">
                  <div class="dropdown">
                      <a href="#" id="topbarUserDropdown" class="user-dropdown d-flex align-items-center dropend dropdown-toggle border-0" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="text">
                          <h6 class="user-dropdown-name"><?= $_SESSION['username'] ?></h6>
                        </div>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                        <li><a class="dropdown-item border-0" href="../admin/core/luna_logout.php"><?= $common_logout ?></a></li>
                      </ul>
                    </div>

                  </div>
                </div>
              </div>
          </div>
          <div class="sidebar-menu">
            <ul class="menu">
                <?php
                  $active = "" ;
                ?>
      
              <?php
                
                $pages_json = file_get_contents('../../admin/inc/luna_pages/pages_'.$row4['id'].'.json');
                $pages_data = json_decode($pages_json,true) ;


                foreach ($pages_data['parent'] as $parent) {

                  $luna->table = 'luna_pages_' . $prod_id;
                  $luna->id = $parent;
                  $parent_stmt = $luna->showAllWhere('id', ['id']);
                  $parent_row = $parent_stmt->fetch(PDO::FETCH_ASSOC);
                  extract($parent_row);
                  
                  $hasSub = "" ;
                  $active = "" ;
                  $link="manual.php?prod=".$prod_id."&page=".$parent_row['id'].""; // manca id della pagina


                if($section->countChild($row['id'])>0 && $countChildPermissions>0 ){
                    $hasSub = "has-sub" ;
                    $link="#";
                  }

                  if($page == $row['link']){
                    $active = "active" ;
                  }

              ?>
              <li class="sidebar-item <?=$active?> <?=$hasSub?>">
                <a href="index.php<?=$link?>" class="sidebar-link">
                  <i class="bi bi-<?=$row['icon']?>"></i>
                  <span>
                    <?php
                      if($lang=="en"){
                        echo $row['label'];
                      }else{
                        $locale_label=strtolower($row['label']);
                        $locale_label = str_replace(" ","_",$locale_label);
                        $locale_label = "label_$locale_label";
                        $section_label = $$locale_label ;
                        echo $section_label ;
                      }
                    ?>
                  </span>
                </a>
                <?php
                  if($hasSub){
                    $where = ['parent_id'] ;
                    $section->parent_id = $row['id'];
                    
                    $child = $section->showAllChild();
                    if($role_id==1 || count($sectionChild)>0)
                    {
                      ?>
                    <ul class="submenu">
                      <?php
                    while ($row1 = $child->fetch(PDO::FETCH_ASSOC)){
                      if($role_id==1 ||  in_array($row1['id'],$sectionChild)){

              

                      $active1 ="" ;

                      extract($row1) ;
                      
                      if($page == $row1['link']){
                        $active1 = "active" ;
                      }
                      
                ?>
                    <li class="submenu-item <?=$active1?>">
                      <a href="index.php?p=<?=$row1['link']?>">
                      <i class="bi bi-<?=$row1['icon']?>"></i>
                      <span>    
                        <?php
                          if($lang=="en"){
                            echo $row1['label'];
                          }else{
                            $locale_label=strtolower($row1['label']);
                            $locale_label = str_replace(" ","_",$locale_label);
                            $locale_label = "label_$locale_label";
                            $section_label = $$locale_label ;
                            echo $section_label ;
                          }
                        ?>
                      </span></a>
                    </li>

                <?php
                    }
                  }
                ?>
                  </ul>
                <?php 
                    }
                  }
                ?>
              </li>
              
              <?php
                }
              ?>
            </ul>
          </div>
        </div>
      </div>
