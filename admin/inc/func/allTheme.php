<script type="text/javascript" src="script/coloris.min.js"></script>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?= $alltheme_header ?></h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?= $common_dashboard ?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <?= $alltheme_header ?>
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

      <form class="form form-horizontal mb-3" action="core/mngTheme.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
        <div class="form-body">
          <div class="row">

            <div class="col-md-3 pb-3">
              <label><?= $alltheme_theme ?></label>
            </div>
            <div class="col-md-9 pb-3">
              <div class="form-group has-icon-left">
                <div class="position-relative">
                  <fieldset class="form-group">
                    <select class="form-select w-50" id="theme" name="theme">
                      <?php
                      $theme_selected = '';
                      foreach (glob("../assets/themes/*") as $dir) {
                        if (is_dir($dir)) {
                          $folder = pathinfo($dir, PATHINFO_FILENAME);
                          $selected = "";

                          $mc->table = 'mc_settings';
                          $mc->name = 'mc_theme';
                          $stmt = $mc->showAllWhere('id', ['name']);
                          $row = $stmt->fetch(PDO::FETCH_ASSOC);
                          extract($row);
                          $theme_selected = $row['value'];
                          if ($folder == $theme_selected) {
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

            <div class="col-12 mb-3">
              <?php
              $css_file = '../assets/themes/' . $theme_selected . '/css/custom.css';

              $css_file_data = file_get_contents($css_file);
              ?>
              <label for="code" class="mb-3"><?=$alltheme_css?>:</label>
              <textarea id="code" name="code"><?php echo htmlentities($css_file_data) ?></textarea>

              <script>
                var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                  lineNumbers: true, // Mostra i numeri di riga
                  mode: "css", // Imposta la modalità su CSS
                  theme: "dracula", // Usa un tema (opzionale)
                  matchBrackets: true // Evidenzia le parentesi corrispondenti
                });


                // Forza il refresh per evitare problemi di visualizzazione
                setTimeout(function() {
                  editor.refresh();
                }, 100); // Forza il ridimensionamento dopo un piccolo ritardo
              </script>

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
    </div>

  </div>
</section>