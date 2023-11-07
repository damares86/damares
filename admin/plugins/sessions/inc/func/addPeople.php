<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$people_add_header?></h3>
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
            <?=$people_add_header?>
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
                <h4 class="card-title"><?=$people_add_title?></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngPeople.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3">
                            <label><?=$common_name?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group has-icon-left">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$people_add_name_ph?>"
                                        id="first-name"
                                        name="name"
                                        data-parsley-required="true"

                                        />
                                        <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$people_all_avatar?> <?=$account_add_optional?></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                    <div class="position-relative">
                                    <input
                                    class="form-control"
                                    type="file"
                                    id="formFile"
                                    name="avatar"
                                />
                            </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$people_all_role?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                <div class="position-relative">
                                    <select class="form-select" name="people_cat" id="basicSelect"
                                        data-parsley-required="true">
                                        <?php
                                            $session->table = "people_cat" ;
                                            $stmt = $session->showAll('id');
                                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                extract($row);
                                        ?>

                                                <option value="<?=$row['id']?>"><?=$row['people_cat_name']?></option>
                                        
                                        <?php
                                            }
                                        ?>
                                        
                                        
                                    </select>
                                </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <label><?=$people_add_desc?> <?=$account_add_optional?></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group has-icon-left">
                                <div class="position-relative">
                                    <input
                                    type="textarea"
                                    class="form-control"
                                    placeholder="<?=$people_add_desc_ph?>"
                                    id="default"
                                    name="description"

                                    />
                                    <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                      

                        <?php

                        require "core/peopleDetails.php";
                        foreach($people_details as $item){

                            $label = "account_add_$item";

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
                                        placeholder="<?=$$label?>"
                                        name="<?=$item?>"
                                        data-parsley-required="true"

                                        />

                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php

                        }

                        foreach($people_details_opt as $item){

                            $label = "account_add_$item";

                        ?>
                        <div class="col-md-3">
                            <label><?=$$label?> <?=$account_add_optional?></label>
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
                                    placeholder="<?=$$label?>"
                                    name="<?=$item?>"

                                    />

                                </div>
                            </div>
                        </div>

                        <?php

                        }

                        ?>

                        
                        <input type="hidden" name="operation" value="add">
                        <input type="hidden" name="origin" value="addPeople">
                      
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