<?php
$newsletter->table = "newsletter_subscribers";
$subscribers = $newsletter->showAll('subscribed_at');

$newsletter->table = "newsletter_settings";
$newsletter->name = "confirmation";
$stmt = $newsletter->showAllWhere('id', ['name']);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$confirmation = $row['value'] == 1 ? true : false;

?>


<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$allsub_header?></h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?= $common_dashboard ?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <?=$allsub_header?>
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
    <div class="card-header"><?=$allsub_title?> &nbsp; &nbsp; &nbsp;
      <a href="index.php?p=addSubscriber" class="btn icon icon-left btn-success shadow"><i data-feather="plus-circle"></i> <?=$allsub_add?></a>
    </div>
    <div class="card-body">

      <table class="table" id="table">
        <thead>
          <tr>
            <th><?=$common_name?></th>
            <th><?= $common_email ?></th>
            <th><?=$allsub_subscribed_at?></th>
            <?php
            if ($confirmation) {
            ?>
              <th><?=$allsub_confirmed?></th>
            <?php
            }
            ?>
            <th><?= $common_actions ?></th>
          </tr>
        </thead>
        <tbody>

          <?php
          while ($row = $subscribers->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $class = $row['confirmed'] == 0 && $confirmation ? 'class="bg-danger text-white"' : '';

          ?>
            <tr <?= $class ?>>
              <td><?= $row['name'] ?></td>
              <td><?= $row['email'] ?></td>
              <td><?= $row['subscribed_at'] ?></td>
              <?php
              if ($confirmation) {
              ?>
                <td>
                  <?php
                  $confirmed = $row['confirmed'] == 0 ? '<i class="bi-x"></i>' : '<i class="bi-check2-circle text-success"></i>';
                  echo $confirmed;
                  ?>
                </td>
              <?php
              }
              ?>
              <td>
                <?php
                if ($row['confirmed'] == 0 && $confirmation) {
                ?>
                  <a href="core/mngSubscriber.php?confirm=yes&id=<?= $row['id'] ?>" class="btn icon btn-success shadow edit-link" data-base-url="core/mngSubscriber.php?confirm=yes&id=<?= $row['id'] ?>">
                    <i class="bi bi-check-circle"></i>
                  </a>

                  &nbsp; &nbsp;
                <?php
                }
                ?>
                <a href="index.php?p=editSubscriber&idToMod=<?= $row['id'] ?>" class="btn icon btn-warning shadow edit-link" data-base-url="index.php?p=editSubscriber&idToMod=<?= $row['id'] ?>">
                  <i class="bi bi-pencil-square"></i>
                </a>

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
                      <div class="modal-body text-dark">
                        <?=$allsub_modal_body?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                          <i class="bx bx-x d-block d-sm-none"></i>
                          <span class="d-none d-sm-block"><?= $common_modal_cancel ?></span>
                        </button>
                        <span class="d-none d-sm-block"><a href="core/mngSubscriber.php?idToDel=<?= $row['id'] ?>" class="btn btn-danger ml-1">
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