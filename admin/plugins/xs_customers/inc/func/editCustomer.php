<?php

$customer->id = filter_input(INPUT_GET,"idToMod");
$stmt1 = $customer->showAllWhere('id',['id']);

$id="";
$name="";
$surname="";
$details="";
$details_opt="";

    while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC))
    {
        extract($row1);

        $customers_details=unserialize($row1['details']);
        $customers_details_opt=unserialize($row1['details_opt']);
    
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
                                        value="<?=$row1['name']?>"
                                        />
                                        <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$common_username?><span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group has-icon-left">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$common_username?>"
                                        name="username"
                                        data-parsley-required="true"
                                        value="<?=$row1['username']?>"                                        
                                        />
                                        <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$customer_add_company?><span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Company"
                                        name="company"
                                        data-parsley-required="true"
                                        value="<?=$row1['company']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$common_email?><span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="email"
                                        class="form-control"
                                        placeholder="Email"
                                        name="email"
                                        data-parsley-required="true"
                                        value="<?=$row1['email']?>"

                                        />
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
                            $array_value = array_values($customers_details[$counter]);
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
                                $array_value = array_values($customers_details_opt[$counter]);
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

                        <h5 class="border-top mb-3 pt-3 mt-2"><?=$customer_prod_permission?></h5>

                        <?php
                            $xsproduct->table = 'product' ;
                            $stmt = $xsproduct->showAll('id') ; 
                            
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                            {
                                extract($row);
                                
                                $xsproduct->table = 'product_permissions' ;
                                $xsproduct->customers_id = $row1['id'] ;
                                $product_id = $row['id'] ;
                                $xsproduct->product_id = $product_id ;

                                $stmt2 = $xsproduct->showAllWhere('id',['customers_id','product_id']) ;
                                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC) ;
                                // if($row2['product_files_cat_id'])
                                // {
                                //     $permissions=unserialize($row2['product_files_cat_id']);
                                // }
                                $checked_prod = '' ;
                                $bg_class = 'danger' ;

                                if($stmt2->rowCount()>0)
                                {
                                    $checked_prod = 'checked' ;
                                    $bg_class = 'success' ;
                                }

                        ?>
                            <div class="col-12 rounded p-3 my-1 bg-<?=$bg_class?> text-white">
                                <div class="row">
                                    <!-- switch permission -->
                                    <div class="col-md-4">
                                        <h6 class="text-white"><?=$row['product_name']?></h6>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check form-switch quiz">
                                            <input class="form-check-input delete" type="checkbox" name="prod_<?=$row['id']?>" id="flexSwitchCheckDefault" <?=$checked_prod?>>
                                            <label class="form-check-label" for="flexSwitchCheckDefault"><?=$customer_prod_auth?> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-5">&nbsp;</div>

                                    <!-- select cat files -->
                                <?php
                                    $xsproduct->table = 'product_files_cat' ;
                                    $stmt3 = $xsproduct->showAll('id');
                                    while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC))
                                    {
                                        extract($row3) ;
                                        $product_files_cat_id = $row3['id'] ;
                                        $cat_name = ucfirst($row3['cat_name']);
                                ?>
                                    <div class="col-md-6 p-2">
                                        <div class="row bg-light rounded text-dark m-2">
                                            <div class="col-12">
                                                <p><strong><?=$cat_name?></strong></p>
                                                <div class="form-group">
                                                        <div class="form-check">
                                                            <div class="checkbox mx-5">
                                                                <?php
                                                                    
                                                                    $xsproduct->table = 'product_files' ;
                                                                    $xsproduct->product_id = $product_id ;
                                                                    $xsproduct->product_files_cat_id = $product_files_cat_id ;
                                                                    $stmt4 = $xsproduct->showAllWhere('id',['product_id','product_files_cat_id']) ;
                                                                    
                                                                    while($row4 = $stmt4->fetch(PDO::FETCH_ASSOC))
                                                                    {

                                                                        extract($row4);
                                                                        $checked="";
                                                                        $product_files_id = $row4['id'] ;

                                                                        $perm_str = $row4['permissions'] ;
                                                                        $perm_arr = explode(',',$perm_str) ;

                                                                        if(is_array($perm_arr))
                                                                        {
                                                                            if(in_array($row1['id'],$perm_arr))
                                                                            {
                                                                                $checked = "checked" ;
                                                                            }
                                                                        }

                                                         
                                                                ?>
                                                                <input type="checkbox" name="files_<?=$product_id?>_<?=$product_files_cat_id?>[]" value="<?=$product_files_id?>" class="form-check-input" <?=$checked?>>
                                                                <label for="checkbox1"><?=$row4['product_files_label']?></label>
                                                                <br>

                                                                <?php
                                                                    }

                                                                ?>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        
                                <?php
                                    }
                                ?>

                                </div>
                            </div>
                        <?php

                            }

                        ?>
                        
                        
                        <input type="hidden" name="idToMod" value="<?=$row1['id']?>">
                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="origin" value="editCustomer">
                      
                        <div class="col-12 mt-2 d-flex justify-content-end">
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

<section class="section">
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="card-title"><?=$customer_edit_password?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngCustomers.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label><?=$common_password?> <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group has-icon-left">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input
                                                    type="password"
                                                    class="form-control"
                                                    placeholder="Password"
                                                    name="password"
                                                    data-parsley-required="true"
                                                    />
                                                    <div class="form-control-icon">
                                                    <i class="bi bi-lock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="operation" value="password">
                                    <input type="hidden" name="idToMod" value="<?=$row1['id']?>">
                                    <input type="hidden" name="origin" value="editCustomer">
                                    <?php
                                    }
                                    ?>
                            
                                    <div class="col-12 d-flex justify-content-end">
                                        <button
                                            type="submit"
                                            class="btn btn-primary me-1 mb-1 shadow"
                                            >
                                            <?=$common_submit?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>