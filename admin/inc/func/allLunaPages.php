<?php

$luna->table = 'luna_parent' ;
$stmt = $luna->showAll('id');

?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Pages Management</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav
        aria-label="breadcrumb"
        class="breadcrumb-header float-start float-lg-end"
      >
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?=$common_dashboard?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
          Pages Management
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
    <div class="card-header">Manage pages &nbsp; &nbsp; &nbsp; 
                    <a href="index.php?p=addLunaPage" class="btn icon icon-left btn-success shadow"
                        ><i data-feather="plus-circle"></i> Add a new parent page</a
                      ></div>
    <div class="card-body">
     ciao
    </div>
  </div>
</section>
