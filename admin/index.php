<?php

declare(strict_types=1);

require_once __DIR__ . '/inc/header.php';

$setting->name = 'layout';
$stmt = $setting->showAllWhere('id', ['name']);
$row = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
$layout = (string) ($row['value'] ?? 'v');
?>
<body>
  <style>
    /* Nascondi la tabella inizialmente */
    #table_wrapper {
      display: none;
    }
  </style>
  <!-- Overlay con lo spinner -->
  <div id="preloader">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden"><?= htmlspecialchars((string) ($common_loading ?? 'Loading'), ENT_QUOTES, 'UTF-8') ?>...</span>
    </div>
  </div>
  <script>
    // Nascondi l'overlay e mostra il contenuto una volta che la pagina è completamente caricata
    window.addEventListener('load', function() {
      var preloader = document.getElementById('preloader');
      var app = document.getElementById('app');
      if (preloader) preloader.style.display = 'none';
      if (app) app.style.display = 'block';
    });
  </script>
  <div id="app">
    <script src="assets/js/initTheme.js"></script>

    <?php
    $classHoriz = '';
    if ($layout === 'h') {
        $classHoriz = ' class="layout-horizontal"';
    } elseif ($layout === 'v') {
        require_once __DIR__ . '/inc/sidebar.php';
    }
    ?>

    <div id="main" <?= $classHoriz ?>>
      <?php
      if ($layout === 'h') {
          require_once __DIR__ . '/inc/topbar.php';
          ?>
          <div class="content-wrapper container">
          <?php
      }
      ?>

        <?php if (($page ?? 'index') === 'index'): ?>
          <div class="page-heading">
            <h3 class="d-inline">Damares <?= htmlspecialchars((string) ($common_dashboard ?? 'Dashboard'), ENT_QUOTES, 'UTF-8') ?></h3>
          </div>
        <?php endif; ?>

        <div class="page-content">
          <?php
          require_once __DIR__ . '/inc/alert.php';

          if (($page ?? 'index') !== 'index') {
              $pageClean = preg_replace('/[^a-zA-Z0-9_-]/', '', (string) $page);
              $pageFile = __DIR__ . "/inc/func/{$pageClean}.php";
              if (is_file($pageFile)) {
                  require $pageFile;
              } else {
                  echo '<div class="alert alert-danger">Page not found.</div>';
              }
          } else {
              ?>
              <section class="row">
                <?php
                $homeBlocks = $home->showAll('id');
                if ($homeBlocks instanceof PDOStatement) {
                    while ($block = $homeBlocks->fetch(PDO::FETCH_ASSOC)) {
                        $contentFile = basename((string) ($block['content'] ?? ''));
                        $fullContentPath = __DIR__ . "/inc/home/{$contentFile}";
                        $size = (int) ($block['size'] ?? 12);
                        ?>
                        <div class="col-12 col-lg-<?= $size ?>">
                          <div class="card shadow">
                            <?php
                            if (is_file($fullContentPath)) {
                                require $fullContentPath;
                            }
                            ?>
                          </div>
                        </div>
                        <?php
                    }
                }
                ?>
              </section>
              <?php
          }
          ?>
        </div>
      <?php if ($layout === 'h'): ?>
        </div>
      <?php endif; ?>
    </div>

    <?php
    require_once __DIR__ . '/inc/footer.php';
    ?>
  </div>
</body>
</html>