<?php

session_start();

spl_autoload_register('autoloader');

function autoloader($class)
{
  include("../class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

include "../inc/class_initialize.php";

$setting->name = "debug";
$dbg = $setting->showAllWhere('id', ['name']);
$row_debug = $dbg->fetch(PDO::FETCH_ASSOC);
extract($row_debug);

if ($row_debug['value'] == 1) {
  require '../vendor/autoload.php';    // If installed via composer
  $debug = new \bdk\Debug(array(
    'collect' => true,
    'output' => true,
  ));
}

$setting->name = "lang";
$stmt = $setting->showByName();
$lang = $stmt['value'];

foreach (glob("../locale/$lang/*.php") as $row) {
  require "$row";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $common_dashboard ?> - damares</title>

  <!--
    ##############    Damares    ###############
    #                                          #
    #    A backend project by DM WebLab        #
    #   Website: https://www.dmweblab.com      #
    #   GitHub: https://github.com/damares86   #
    #                                          #
    ############################################
    -->

  <link rel="stylesheet" href="../assets/css/main/app.css" />
  <link rel="stylesheet" href="../assets/css/main/app-dark.css" />
  <link rel="shortcut icon" href="../assets/images/logo/favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="../assets/images/logo/favicon.ico" type="image/png" />
  <link rel="stylesheet" href="../assets/extensions/choices.js/public/assets/styles/choices.css" />
  <link rel="stylesheet" href="../assets/css/pages/buttons.dataTables.min.css">

  <link rel="stylesheet" href="../assets/css/shared/iconly.css" />
  <link rel="stylesheet" href="../assets/css/pages/summernote.css">
  <link rel="stylesheet" href="../assets/extensions/summernote/summernote-lite.css">

  <?php

  foreach (glob("../assets/css/*.css") as $row) {
  ?>
    <link rel="stylesheet" href="<?= $row ?>" />
  <?php
  }
  ?>
  <script src="../assets/extensions/jquery/jquery.min.js"></script>

</head>

<body>

  <div class="content-wrapper container">

    <div class="page-content">
      <?php
      $users = $account->showAll('id');
      ?>

      <div class="page-title">
        <div class="row">
          <div class="col-12 col-md-6 order-md-1 order-last">
            <h3><?= $account_all_header ?></h3>
          </div>
          <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="index.php"><?= $common_dashboard ?></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  <?= $account_all_header ?>
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
          <div class="card-header"><?= $account_all_title ?> &nbsp; &nbsp; &nbsp;
            <a href="../index.php?p=addAccount" class="btn icon icon-left btn-success shadow"><i data-feather="plus-circle"></i> <?= $account_all_add ?></a>
          </div>
          <div class="card-body">

            <table class="table" id="table">
              <thead>
                <tr>
                  <th><?= $common_username ?></th>
                  <th><?= $common_email ?></th>
                  <th><?= $common_role ?></th>
                  <th><?= $common_lastLogin ?></th>
                  <th><?= $common_actions ?></th>
                </tr>
              </thead>
              <tbody>

                <?php
                while ($row = $users->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                  if ($row['id'] > 2 || $_SESSION['role_id'] == 1) {
                ?>
                    <tr>
                      <td><?= $row['username'] ?></td>
                      <td><?= $row['email'] ?></td>
                      <td>
                        <?php
                        $accountroles->account_id = $row['id'];
                        $roleId = $accountroles->showAccountRolesId();
                        $role->id = $roleId;
                        $rolename = $role->showRolenameById();
                        echo $rolename;
                        ?>
                      </td>
                      <td><?= $row['last_login'] ?></td>
                      <td>
                        <a href="../index.php?p=editAccount&idToMod=<?= $row['id'] ?>" class="btn icon btn-warning edit-link" data-base-url="../index.php?p=editAccount&idToMod=<?= $row['id'] ?>">
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
                              <div class="modal-body">
                                <?= $account_all_modal_body ?>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                  <i class="bx bx-x d-block d-sm-none"></i>
                                  <span class="d-none d-sm-block"><?= $common_modal_cancel ?></span>
                                </button>
                                <span class="d-none d-sm-block"><a href="core/mngAccounts.php?idToDel=<?= $row['id'] ?>" class="btn btn-danger ml-1">
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
                }

                ?>



              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
  </div>

  <footer>
    <div class="container">
      <div class="footer clearfix mb-0 text-muted">

        <div class="float-end">
          <p>
            <!-- <img src="assets/images/logo/damares_rid.png" alt="Logo" /> &nbsp; <strong>damares v.<?= $damares_version ?></strong> - developed by -->
            <a href="http://www.dmweblab.com" target="_blank">
              <img src="assets/images/logo/dmweblab_logo.png" alt="Logo" />
            </a>
          </p>
        </div>
      </div>
    </div>
  </footer>

  </div>
  </div>
  <script src="../assets/js/bootstrap.js"></script>
  <script src="../assets/js/app.js"></script>

  <script src="../assets/js/pages/horizontal-layout.js"></script>


  <script src="../assets/js/pages/dashboard.js"></script>
  <script src="../assets/js/pages/datatables.min.js"></script>

  <script>
  <?php
  $lc_lang = strtolower($lang);
  if ($lang == 'en') {
    $uc_lang = 'GB';
  } else {
    $uc_lang = strtoupper($lang);
  }

  $local_url = '';
  $local_file = 'assets/js/pages/datatable_localization/' . $lc_lang . '-' . $uc_lang . '.json';

  if (file_exists($local_file)) {
    $local_url = $local_file;
  } else {
    $local_url = '//cdn.datatables.net/plug-ins/2.0.1/i18n/' . $lc_lang . '-' . $uc_lang . '.json';
  }
  ?>

  let pageName = "<?= $page ?>"; // Nome della pagina
  let updatingURL = false; // Variabile per evitare la sovrascrittura dell'URL
  let urlPage = getURLParameter('tablePage');

  function getURLParameter(name) {
    return new URLSearchParams(window.location.search).get(name);
  }

  function updateURLParameter(param, value) {
    if (!updatingURL) {
      let url = new URL(window.location);
      url.searchParams.set(param, value);
      history.replaceState(null, '', url);
    }
  }

  
    let table = $("#table").DataTable({
      // localization
      language: {
        url: "<?= $local_url ?>",
      },
      drawCallback: function(settings) {
        let currentPage = table.page();
        updateLinks(currentPage);
        updateURLParameter('tablePage', currentPage + 1); // Aggiungere 1 perché l'URL usa l'indice 1-based
      },
      initComplete: function() {
        if (urlPage !== null) {
          let pageIndex = parseInt(urlPage) - 1; // DataTables usa zero-index per le pagine
          table.page(pageIndex).draw(false);
        }
      }
  });

  // Recuperare la pagina dall'URL e impostarla
  console.log('Pagina dall\'URL: ' + urlPage);
  if (urlPage !== null) {
    let pageIndex = parseInt(urlPage) - 1; // DataTables usa zero-index per le pagine
    console.log('Impostazione pagina a: ' + pageIndex);
    table.page(pageIndex).draw(false);
  }

  function updateLinks(pageNumber) {
    let links = document.querySelectorAll('.edit-link');
    links.forEach(link => {
      let baseUrl = link.getAttribute('data-base-url');
      link.href = `${baseUrl}&tablePage=${pageNumber + 1}`;
      // console.log('Aggiornato link: ' + link.href);
    });
  }

  // Aggiungi un listener per l'evento 'page' della DataTable
  table.on('page.dt', function() {
    let currentPage = table.page();
    console.log('Pagina corrente durante evento page: ' + currentPage);
    updateLinks(currentPage);
    updateURLParameter('tablePage', currentPage + 1); // Aggiungere 1 perché l'URL usa l'indice 1-based
  });

</script>


  <script src="../assets/js/pages/dataTables.buttons.min.js"></script>


</body>

</html>


</body>