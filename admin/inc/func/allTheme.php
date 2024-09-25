<script type="text/javascript" src="script/coloris.min.js"></script>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Colori e tema</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?= $common_dashboard ?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Colori e tema
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>

<section class="section">
  <div class="card shadow">
    <!-- <div class="card-header">Scegli il tema &nbsp; &nbsp; &nbsp;
    </div> -->
    <div class="card-body">

      <div id="colorpicker"></div>

      <form class="form form-horizontal " action="core/mngTheme.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
        <div class="form-body">
          <div class="row">

            <div class="col-md-3 pb-3">
              <label>Tema</label>
            </div>
            <div class="col-md-9 pb-3">
              <div class="form-group has-icon-left">
                <div class="position-relative">
                  <fieldset class="form-group">
                    <select class="form-select w-50" id="theme" name="theme">
                      <?php
                      foreach (glob("../assets/themes/*") as $dir) {
                        if (is_dir($dir)) {
                          $folder = pathinfo($dir, PATHINFO_FILENAME);
                          $selected = "";

                          $setting->name = 'mc_theme';
                          $stmt = $setting->showAllWhere('id', ['name']);
                          $row = $stmt->fetch(PDO::FETCH_ASSOC);
                          extract($row);

                          if ($folder == $row['value']) {
                            $selected = "selected";
                          }
                          echo "<option value='{$folder}' $selected >{$folder}</option>";
                        }
                      }
                      ?>
                    </select>
                  </fieldset>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <label>Aggiungi colore </label>
            </div>
            <div class="col-md-9">
              <div class="form-group has-icon-left">
                <div class="form-check mandatory square">
                  <input type="text" class="form-control coloris instance1" id="color" name="color" value="#008db1" data-parsley-required="true" data-coloris>
                </div>
              </div>
            </div>

            <input type="hidden" name="origin" value="allTheme">
            <input type="hidden" name="operation" value="editTheme">

            <div class="col-12 mt-3 d-flex justify-content-end">
              <button type="submit" class="btn btn-primary me-1 mb-1 shadow">
                <?= $common_submit ?>
              </button>
              <button type="reset" class="btn btn-light-secondary me-1 mb-1 shadow">
                <?= $common_reset ?>
              </button>
            </div>
          </div>
        </div>
      </form>


      <div class="col-12  border-top py-3">
        <label>Colori esistenti</label>
        <div class="row">
          <?php
          $mc->table = 'mc_color';
          $stmt1 = $mc->showAll('id');

          while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
          ?>
            <div class="col-6 col-lg-3 col-md-6">
              <div class="card" style="background-color: <?= $row1['color'] ?>;">
                <div class="card-body px-4 py-4-5">
                  <div class="row">
                    <div class="col-md-3 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center ">
                      <a href="#" data-bs-toggle="modal" data-bs-target="#danger<?= $row1['id'] ?>">
                        <div class="stats-icon red mb-2 border shadow">
                          <i class="bi-trash"></i>
                        </div>
                      </a>
                      <!--Danger theme Modal -->
                      <div class="modal fade text-left" id="danger<?= $row1['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
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
                              Se clicchi conferma questo colore verrà eliminato definitivamente
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block"><?= $common_modal_cancel ?></span>
                              </button>
                              <span class="d-none d-sm-block"><a href="core/mngTheme.php?idToDel=<?= $row1['id'] ?>" class="btn btn-danger ml-1">
                                  <?= $common_modal_confirm ?>
                                </a></span>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php

          }


          ?>
        </div>
      </div>

    </div>
  </div>
</section>