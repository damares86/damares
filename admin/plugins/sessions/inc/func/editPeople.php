<?php

$session->id = filter_input(INPUT_GET,"idToMod");
$session->table = "people" ;
$stmt1 = $session->showAllWhere('id',['id']);



?>
<div class="page-heading">
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$people_edit_header?></h3>
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
          
          <?=$people_edit_header?> 
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>
<?php
                  $peopleId="";
                  $name="";
                  $email="";
                  $description="";
                  $details=[];
                  $details_opt=[];

                      while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                        extract($row1);
                        
                          $peopleId=$row1['id'];
                          $name=$row1['people_name'];
                          $avatar=$row1['avatar'];
                          $description=$row1['description'];
                          $details=unserialize($row1['details']);
                          $details_opt=unserialize($row1['details_opt']);

      
                                  if(!$avatar){
                                      $avatar = "default.png" ;
                                  }
      
                                }
                          ?>
<section class="section">
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                <h4 class="card-title"><?=$people_edit_header?>: <b><?=$name?></b>  </h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngPeople.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3">
                            <label><?=$common_name?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9 my-3">
                            <div class="form-group has-icon-left">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$people_add_name_ph?>"
                                        id="name"
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
                            <label><?=$account_add_avatar?> <?=$account_add_optional?></label>
                        </div> 
                        <div class="col-md-2 text-center">
                            <div class="avatar avatar-lg me-3">
                                <img src="uploads/avatar/<?=$avatar?>" alt="" srcset="">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                    <div >
                                    <input
                                    class="form-control"
                                    type="file"
                                    id="formFile"
                                    name="avatar"
                                />
                            </div>
                            </div>
                        </div>

                        <div class="col-md-3 mt-3">
                            <label><?=$people_all_role?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9 mt-3">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                <div class="position-relative">
                                    <select class="form-select" name="people_cat" id="basicSelect"
                                        data-parsley-required="true">
                                        <?php
                                            $session->table = "people_cat_id" ;
                                            $session->people_id = $peopleId ;
                                            $stmt2 = $session->showAllWhere('id',['people_id']);
                                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                            extract($row2);

                                            $cat_id = $row2['cat_id'];

                                            $session->table = "people_cat" ;
                                            $stmt = $session->showAll('id');
                                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                extract($row);
                                                $selected="";
                                                if($row['id']==$cat_id){
                                                    $selected="selected";
                                                }
                                        ?>

                                                <option value="<?=$row['id']?>" <?=$selected?>><?=$row['people_cat_name']?></option>
                                        
                                        <?php
                                            }
                                        ?>
                                        
                                        
                                    </select>
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$people_add_desc?>  <?=$account_add_optional?></label>
                        </div>
                        <div class="col-md-9 my-3">
                            <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input
                                        type="textarea"
                                        class="form-control"
                                        placeholder="<?=$speakers_add_desc_ph?>"
                                        id="default"
                                        name="description"
                                        value="<?=$description?>"
                                        />
                                        <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                            </div>
                        </div>
                 

                         <?php

                            require "core/speakersDetails.php";

                            $counter=0;
                            

                            foreach($speakers_details as $item){

                                $label = "account_add_$item";
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
                                            placeholder="<?=$$label?>"
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
                            foreach($speakers_details_opt as $item){

                                $label = "account_add_$item";
                                // if(array_values($details_opt[$counter])){
                                    $array_value = array_values($details_opt[$counter]);
                                    $value = $array_value[0];
                                // }

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
                                        data-parsley-required="true"
                                            value="<?=$value?>"

                                        />

                                    </div>
                                </div>
                            </div>

                            <?php
                                $counter++;

                            }

                            ?>


                      

                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="avatar_orig" value="<?=$avatar?>">
                        <input type="hidden" name="idToMod" value="<?=$peopleId?>">
                        <input type="hidden" name="origin" value="editPeopler">
                      
                        <div class="col-12 d-flex justify-content-end">
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
