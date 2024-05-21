<div id="sidebar" class="active">
  <div class="sidebar-wrapper active">
    <div class="sidebar-header position-relative">
      <div class="d-flex justify-content-between align-items-center">
        <!-- <div class="logo"> -->
        <div class="logo px-5">
          <a href="index.php">
            <img src="assets/img/logo/damares_logo.png" alt="Logo" srcset="" />
          </a>
        </div>
      </div>
    </div>
    <?php
    if ($check_user) {
    ?>
      <div class="col-12 col-lg-3">
        <div class="card">
          <div class="card-body py-4 px-4">
            <div class="d-flex align-items-center">
              <div class="dropdown">
                <a href="#" id="topbarUserDropdown" class="user-dropdown d-flex align-items-center dropend dropdown-toggle border-0" data-bs-toggle="dropdown" aria-expanded="false">
                  <div class="text">
                    <h6 class="user-dropdown-name"><?= $_SESSION['luna_username'] ?></h6>
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
    <?php
    }
    ?>
    <div class="sidebar-menu">
      <ul class="menu">
        <?php
        $active = "";
        ?>

        <?php

        $pages_json = file_get_contents('../admin/inc/luna_pages/pages_' . $row4['id'] . '.json');
        $pages_data = json_decode($pages_json, true);


        foreach ($pages_data['parent'] as $parent) {
          $luna->table = 'luna_pages_' . $prod_id;
          $luna->id = $parent;
          $parent_stmt = $luna->showAllWhere('id', ['id']);
          $parent_row = $parent_stmt->fetch(PDO::FETCH_ASSOC);
          extract($parent_row);

          $title = $parent_row['title'];

          $hasSub = "";
          $active = "";
          $link = "?prod=" . $prod_id . "&page=" . $parent_row['id'] . ""; // manca id della pagina

          foreach ($pages_data['child'] as $child) {

            if ($child['parent_id'] == $parent_row['id']) {
              if (is_array($child['id'])) {
                $hasSub = "has-sub";
                $link='#';
              }
            }
          }

          if ($page_id == $parent_row['id']) {
            $active = "active";
          }

        ?>
          <li class="sidebar-item <?= $active ?> <?= $hasSub ?>">
            <a href="manual.php<?= $link ?>" class="sidebar-link">
              <span>
                <?php
                echo $title;
                ?>
              </span>
            </a>
            <?php
            if ($hasSub) {
             
            ?>
                <ul class="submenu">
                  <?php
          foreach ($pages_data['child'] as $child) {

            if ($child['parent_id'] == $parent_row['id']) {
              
              foreach($child['id'] as $item){
              
                $luna->table = 'luna_pages_' . $prod_id;
                $luna->id = $item;
                $child_stmt = $luna->showAllWhere('id', ['id']);
                $child_row = $child_stmt->fetch(PDO::FETCH_ASSOC);
                extract($child_row);

                $title_child = $child_row['title'];
                $active1 = "";

                $link_sub = "?prod=" . $prod_id . "&page=" . $child_row['id'] . ""; 
                if($page_id == $child_row['id']){
                  $active1 = "active";
                }
      
            ?>

                      <li class="submenu-item <?= $active1 ?>">
                        <a href="manual.php<?= $link_sub ?>">
                          <span>
                            <?=$title_child?>
                          </span></a>
                      </li>

            <?php
              }
              
            }
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
    </div>
  </div>
</div>