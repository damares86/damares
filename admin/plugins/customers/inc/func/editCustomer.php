<?php

$customer->id = filter_input(INPUT_GET,"idToMod");
$stmt1 = $customer->showAllWhere('id',['id']);

$id="";
$name="";
$surname="";
$details="";
$details_opt="";

    while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
    extract($row1);
    
        $id=$row1['id'];
        $name=$row1['name'];
        $surname=$row1['surname'];
        $details=unserialize($row1['details']);
        $details_opt=unserialize($row1['details_opt']);
    }


?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$customer_edit_header?></h3>
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
            <?=$customer_edit_header?>
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
                <h4 class="card-title"><?=$customer_edit_title?></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngCustomers.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3">
                            <label><?=$common_name?><span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group has-icon-left">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$customer_add_name_ph?>"
                                        id="first-name"
                                        name="name"
                                        data-parsley-required="true"
                                        value="<?=$name?>"
                                        />
                                        <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$common_surname?><span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group has-icon-left">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$customer_add_surname_ph?>"
                                        id="surname"
                                        name="surname"
                                        data-parsley-required="true"
                                        value="<?=$surname?>"
                                        />
                                        <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php

                        require "core/customersDetails.php";

                        $counter=0;
                        foreach($customers_details as $item){

                            $label = "customer_add_$item";
                            $item_label=ucfirst($item);
                            $array_value = array_values($details[$counter]);
                            $value = $array_value[0];

                        ?>
                        <div class="col-md-3">
                            <label><?=$$label?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <?php
                                            $type="text";
                                            if($item=="birth"){
                                                $type="date";
                                            }
                                        ?>
                                        <input
                                        type="<?=$type?>"
                                        class="form-control"
                                        placeholder="<?=$item_label?>"
                                        name="<?=$item?>"
                                        data-parsley-required="true"
                                        value="<?=$value?>"

                                        />

                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                            $counter++;

                        }

                        $counter=0;
                        foreach($customers_details_opt as $item){

                            $label = "customer_add_$item";
                            $item_label=ucfirst($item);
                            // if(array_values($details_opt[$counter])){
                                $array_value = array_values($details_opt[$counter]);
                                $value = $array_value[0];
                            // }
                        ?>
                        <div class="col-md-3">
                            <label><?=$$label?> <?=$customer_add_optional?></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="position-relative">
                                    <?php
                                        $type="text";
                                        if($item=="birth"){
                                            $type="date";
                                        }
                                    ?>
                                    <input
                                    type="<?=$type?>"
                                    class="form-control"
                                    placeholder="<?=$item_label?>"
                                    name="<?=$item?>"
                                    value="<?=$value?>"

                                    />

                                </div>
                            </div>
                        </div>

                        <?php
                                $counter++;

                        }

                        ?>

                        
                        <input type="hidden" name="idToMod" value="<?=$id?>">
                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="origin" value="editCustomer">
                      
                        <div class="col-12 d-flex justify-content-end">
                            <button
                            type="submit"
                            class="btn btn-primary me-1 mb-1 shadow"
                            >
                            <?=$common_submit?>
                            </button>
                            <button
                            type="reset"
                            class="btn btn-light-secondary me-1 mb-1 shadow"
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
            <div class="card shadow">
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