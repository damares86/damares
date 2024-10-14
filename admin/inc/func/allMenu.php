<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Menu management</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?= $common_dashboard ?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Menu management
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
    <!-- <div class="card-header">Menu management&nbsp; &nbsp; &nbsp;
    </div> -->
    <div class="card-body">

      <div class='wrapper'>
        <div id="alert-placeholder"></div>
        <div id='parent-block' class='container-pages p-3'>

          <?php

          // get menu order
          $pages_json = file_get_contents('inc/menu/menu.json');
          $pages_data = json_decode($pages_json, true);

          foreach ($pages_data['inmenu'] as $inmenu) {

            $mc->table = $inmenu['table'];
            $mc->id = $inmenu['id'];

            $stmt = $mc->showAllWhere('id', ['id']);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            $parent_div_arr[] = $row['id'];
            
          }





          ?>

















        </div>
      </div>

    </div>
  </div>
</section>