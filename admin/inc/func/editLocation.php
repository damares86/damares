<?php

    $locationId = filter_input(INPUT_GET,"idToMod");
    $session->id = $locationId ;
    $session->table = "location";
    $stmt = $session->showAllWhere('id',['id']);

?>


<div class="page-heading">
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$loc_edit_header?></h3>
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
            <?=$loc_edit_header?>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>

<?php
    $locationName = "" ;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $locationName = $row['location_name'];
    }
?>

<section class="section">
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                <h4 class="card-title"><?=$loc_edit_title?>: <b><?=$locationName?></b></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngLocations.php" method="POST" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3">
                            <label><?=$loc_edit_name?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group has-icon-left">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Location"
                                        id="first-name-icon"
                                        name="name"
                                        data-parsley-required="true"
                                        value="<?=$locationName?>"

                                        />
                                        <div class="form-control-icon">
                                        <i class="bi bi-building"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
               
                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="idToMod" value="<?=$locationId?>">
                        <input type="hidden" name="origin" value="editLocation">
                      
                        <div class="col-12 d-flex justify-content-end">
                            <button
                            type="submit"
                            class="btn btn-primary me-1 mb-1"
                            >
                            <?=$common_submit?>
                            </button>
                            <button
                            type="reset"
                            class="btn btn-light-secondary me-1 mb-1"
                            >
                            <?=$common_reset?>
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
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?=$common_info?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>