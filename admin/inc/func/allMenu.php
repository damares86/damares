<?php

$pages = $mc->showFieldsUnion('id','mc_default_pages','mc_pages',['id','page_name']);


while($row = $pages->fetch(PDO::FETCH_ASSOC)){
  extract($row);
  ?>
  <pre>
  <?php
  print_r($row);
  ?>
  </pre>
  <?php
}

exit;
?>

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

      Work in progress

    </div>
  </div>
</section>