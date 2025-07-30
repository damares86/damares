<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?= $addcat_header ?></h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav
        aria-label="breadcrumb"
        class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?= $common_dashboard ?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <?= $addcat_header ?>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>

<section class="section">
  <div class="row">
    <div class="col-md-8 col-12">
      <div class="card shadow">
        <div class="card-header">
          <h4 class="card-title"><?= $addcat_title ?></h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form form-horizontal" action="core/mngPostCat.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
              <div class="form-body">
                <div class="row">
                  <div class="col-md-3">
                    <label><?= $addcat_name ?> <span class="text-danger">*</span></label>
                  </div>
                  <div class="col-md-9">
                    <div class="form-group">
                      <div class="form-check mandatory">
                        <div class="position-relative">
                          <input
                            type="text"
                            class="form-control"
                            placeholder="<?= $addcat_name ?>"
                            name="category_name"
                            data-parsley-required="true" />

                        </div>
                      </div>
                    </div>
                  </div>

                  <?php
                  $plugin->pluginname = "mini_cms";

                  if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {
                  ?>
                    <div class="col-md-3 my-3">
                      <label><?= $addcat_assign ?>: <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9 my-3">
                      <div class="form-group">
                        <div class="form-check mandatory">
                          <div class="position-relative">
                            <fieldset class="form-group">
                              <select class="form-select w-75" name="assign_page">
                                <option value="none"><?= $addcat_none ?></option>
                                <?php
                                $mc->table = 'mc_pages';
                                $stmt = $mc->showAll('page_name');
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                  extract($row);

                                  $str = $row['page_name'];
                                  $str = str_replace('_', ' ', $str);
                                  $str = ucfirst($str);

                                ?>
                                  <option value="<?= $row['id'] ?>"><?= $str ?></option>
                                <?php
                                }
                                ?>

                              </select>

                            </fieldset>

                          </div>
                        </div>
                      </div>
                    </div>
                  <?php
                  }
                  ?>

                  <input type="hidden" name="operation" value="add">
                  <input type="hidden" name="origin" value="addPostCat">

                  <div class="col-12 d-flex justify-content-end">
                    <button
                      type="submit"
                      class="btn btn-primary me-1 mb-1 shadow">
                      <?= $common_submit ?>
                    </button>
                    <button
                      type="reset"
                      class="btn btn-light-secondary me-1 mb-1 shadow">
                      <?= $common_reset ?>
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-12">
      <div class="card shadow">
        <h4 class="card-title px-4 pt-3"><?= $common_info ?></h4>
        <div class="card-content px-5 pb-4">
          <ul>
            <li><a href="https://www.dmweblab.com/portal/manual.php?prod=3&page=5" target="_blank"><?= $common_see_guide ?></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>