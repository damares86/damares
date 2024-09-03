<?php
$mc->table = 'mc_default_pages';
$pages = $mc->showAll('id');
?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Default pages</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?= $common_dashboard ?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
          Default pages
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
    <div class="card-header">All default pages &nbsp; &nbsp; &nbsp;
    </div>
    <div class="card-body">

      <table class="table" id="table">
        <thead>
          <tr>
            <th>Page name</th>
            <th>Page link</th>
            <th><?= $common_actions ?></th>
          </tr>
        </thead>
        <tbody>

          <?php
          while ($row = $pages->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            
          ?>
              <tr>
                <td><?= $row['page_name'] ?></td>
                <td>
                <?php
                    $str=$row['page_name'];
                    $str = preg_replace('/\s+/', '_', $str);

                    $str = strtolower($str);
                ?>
                <a href="../<?=$str?>.php">View</a>
                 
                </td>  
             
                <td>
                  <a href="index.php?p=editDefaultPage&idToMod=<?= $row['id'] ?>" class="btn icon btn-warning shadow edit-link" data-base-url="index.php?p=editAccount&idToMod=<?= $row['id'] ?>">
                    <i class="bi bi-pencil-square"></i>
                  </a>

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