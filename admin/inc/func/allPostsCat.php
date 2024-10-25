<?php
$post->table = 'post_categories';
$stmt = $post->showAll('id');

$minicms = false ;
$plugin->pluginname = "mini_cms";

if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {
  $minicms = true ;
}

?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$allpostcat_header?></h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?= $common_dashboard ?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <?=$allpostcat_header?>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>


<!-- Basic Tables start -->
<section class="section">
  <div class="card shadow">
    <div class="card-header"><?=$allpostcat_header?> &nbsp; &nbsp; &nbsp;
      <a href="index.php?p=addPostCat" class="btn icon icon-left btn-success shadow"><i data-feather="plus-circle"></i> <?=$allpostcat_add?></a>
    </div>
    <div class="card-body">
      <table class="table" id="table">
        <thead>
          <tr>
            <th><?=$allpostcat_name?></th>
            <th><?=$allpostcat_number?></th>
            <?php
            if($minicms){
            ?>
              <th><?=$allpostcat_assign?></th>
            <?php
            }
            ?>
            <th><?= $common_actions ?></th>
          </tr>
        </thead>
        <tbody>

          <?php
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $post->table = 'post';
            $stmt1 = $post->showAll('id');

            $num = 0;

            while ($row1  = $stmt1->fetch(PDO::FETCH_ASSOC)) {
              extract($row);

              $catArr = explode(',', $row1['category_id']);
              if (in_array($row['id'], $catArr)) {
                $num++;
              }
            }
          ?>
            <tr <?= $class ?>>
              <td><?= $row['category_name'] ?></td>
              <td><?= $num ?></td>
            <?php
            if($minicms){
            ?>
              <td>
                <?php
                  if($row['assign_page'] == NULL){
                    echo "nessuna" ;
                  }else{
                    $mc->table = 'mc_pages' ;
                    $mc->id = $row['assign_page'] ;
                    $stmt2 = $mc->showAllWhere('id',['id']) ;
                    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                    extract($row2);
                    $page_name = str_replace('_',' ',$row2['page_name']);
                    $page_name = ucfirst($page_name)
                ?>
                  <?=$page_name?>
                <?php
                  }
                ?>
              </td>
            <?php
            }
            ?>
              <td>
                <a href="index.php?p=editPostCat&idToMod=<?= $row['id'] ?>" class="btn icon btn-warning shadow edit-link" data-base-url="index.php?p=editPostCat&idToMod=<?= $row['id'] ?>"><i class="bi bi-pencil-square"></i></a>
                &nbsp; &nbsp;
                <a href="#" class="btn icon btn-danger shadow" data-bs-toggle="modal" data-bs-target="#danger<?= $row['id'] ?>"><i class="bi bi-trash"></i>
                </a>
                <!--Danger theme Modal -->
                <div class="modal fade text-left" id="danger<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                      <div class="modal-header bg-danger">
                        <h5 class="modal-title white" id="myModalLabel120">
                          <?= $common_modal_title_sure ?>
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                          <i data-feather="x"></i>
                        </button>
                      </div>
                      <div class="modal-body">
                        <?= $allpostcat_modal_body ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                          <i class="bx bx-x d-block d-sm-none"></i>
                          <span class="d-none d-sm-block"><?= $common_modal_cancel ?></span>
                        </button>
                        <span class="d-none d-sm-block"><a href="core/mngPostCat.php?idToDel=<?= $row['id'] ?>" class="btn btn-danger ml-1">
                            <?= $common_modal_confirm ?>
                          </a></span>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>




          <?php
          }
          ?>



        </tbody>
      </table>
    </div>
  </div>
</section>