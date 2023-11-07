<?php

require "core/rateItems.php";

foreach($rateItems as $item){

    $rate->table = "rate_cat";
    $rate->cat_name = $item ;

    if(!$rate->itemExists('cat_name')){
        $rate->insert(['cat_name']);
    }

}

$rate->table="rate_cat" ;
$stmt = $rate->showAll('id');

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    
    extract($row);

    if(!in_array($row['cat_name'],$rateItems)){
        $rate->cat_name=$row['cat_name'];
        $rate->delete('cat_name');

        $rate->table = "item_rate";
        $rate->rate_cat_id=$row['id'];
        if($rate->itemExists('rate_cat_id')){
            $rate->delete('rate_cat_id');
        }

    }
    

    
}
?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$rate_cat_header?></h3>
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
            <?=$rate_cat_header?>
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
            <div class="card">
                <div class="card-header">
                <h4 class="card-title"><?=$rate_cat_title?></u> </h4>
                </div>
                <div class="card-content">
                <div class="card-body">

                    <!-- edit session -->
                    <form class="form form-horizontal" action="core/mngRate.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                        <div class="form-body">
                        <div class="row">
                            <?php
    $id="";
    $cat_name="";
    $active="";
    $rate->table="rate_cat" ;
    $stmt1 = $rate->showAll('cat_name');
    
    while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
        extract($row1);
        $active_bg="danger";
        $checked="";

        $id=$row1['id'];
        $cat_name=$row1['cat_name'];
       
        $label = "rate_$cat_name";
        $label_cat_name = $$label ;

        $active=$row1['active'];
        
        if($active==1){
            $active_bg="success";
            $checked="checked";
        }
        ?>

        <div class="row mb-3 text-white">
            <div class="col-md-3 bg-<?=$active_bg?> py-2">
                <label><?=$label_cat_name?></label>
            </div>
            <div class="col-md-2 bg-<?=$active_bg?> py-2 text-right">
                <div class="form-check form-switch">

                    <input class="form-check-input delete" type="checkbox" name="cat[]" value="<?=$id?>" id="flexSwitchCheckDefault" <?=$checked?>>
                </div>
            </div>
                           
        </div>    

        <?php
        }
        ?>

                        
                        <input type="hidden" name="operation" value="editActive">
                        <input type="hidden" name="origin" value="editRate">
                      
                        <div class="col-12 d-flex justify-content-start mt-3">
                            <button
                            type="submit"
                            class="btn btn-primary me-1 mb-1"
                            >
                            <?=$common_update?>
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