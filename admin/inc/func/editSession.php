<?php

$session_id= filter_input(INPUT_GET,"idToMod");
$session->id = $session_id;
$session->table="sessions";
$stmt1 = $session->showAllWhere('id',['id']);

$plugin->pluginname = "rating_system" ;
$rating = false;
$cookie_rating="";
if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
    $rating = true ;
    if(isset($_COOKIE['damares-rate'])){
      $cookie_rating=json_decode($_COOKIE['damares-rate'],true);
    }
}


?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$sess_edit_header?></h3>
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
            <?=$sess_edit_header?>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>
<?php

                  $id=$session_id;
                  $sessId=$session_id;
                  $name="";
                  $date="";
                  $date_db="";
                  $start_time="";
                  $end_time="";
                  $location="";
                  $active="";
                  $active_bg="danger";
                  $checked="";
                  $rate_active = "";
                  $relations=[];
                  $people_arr=[];
                  $chair_arr=[];
                  $expert_arr=[];

                      while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                        extract($row1);

                        $id=$row1['id'];
                        $sessId=$row1['id'];
                        $name=$row1['sessions_name'];
                        $date_db = $row1['date'] ;
                        $date=date("Y-m-d", strtotime($row1['date']));
                        $start_time=$row1['start_time'];
                        $end_time=$row1['end_time'];
                        $location=$row1['location_id'];
                        $active=$row1['active'];
                        if($row1['relations_id']){
                            $relation_str=$row1['relations_id'];
                            $relations=explode(',',$relation_str);
                        }
                        
                        if($active==1){
                            $active_bg="success";
                            $checked="checked";
                        }

                        $people_str=$row1['people_id'];
                        $people_arr[] = unserialize($people_str);
                        if(isset($people_arr[0][0]['chair'])){
                            $chair_arr[]=$people_arr[0][0]['chair'];
                        }
                        if(isset($people_arr[0][1]['expert'])){
                            $expert_arr[]=$people_arr[0][1]['expert'];
                        }
                        
                    }

                      $rate->item_id=$id;
                      $rate->table = "item_rate" ;
                      $stmt4 = $rate->showAllWhere('id',['item_id']);
                      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
   
                      extract($row4);
                      $rate_bg="danger";
                      $rate_checked="";
                      $rate_item_id=$row4['id'];
                      if($row4['rate_active']==1){
                        $rate_bg="success";
                        $rate_checked="checked";
                      }

                        ?>

<section class="section">
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                <h4 class="card-title"><?=$sess_edit_title?> <u><?=$name?></u> </h4>
                </div>
                <div class="card-content">
                <div class="card-body">

                <?php
                    if($rating){
                        $rate->cat_name = "sessions" ;
                        $rate->table = "rate_cat";
                        
                        $stmt4 = $rate->showAllWhere('id',['cat_name']);
                        $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
                        if(is_array($row4)){
                        ?>
                    <form class="form form-horizontal" action="core/mngRate.php" method="POST"  enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row mb-3 text-white border-bottom pb-3">
                                <div class="col-md-3 bg-<?=$rate_bg?> py-2">
                                    <label>Rating system</label>
                                </div>
                                <div class="col-md-2 bg-<?=$rate_bg?> py-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input delete" type="checkbox" name="activeRate" id="flexSwitchCheckDefault" <?=$rate_checked?>>
                                    </div>
                                </div>
                            <input type="hidden" name="operation" value="editRateSession">
                            <input type="hidden" name="origin" value="editSession">
                            <input type="hidden" name="idToMod" value="<?=$sessId?>">
                            <?php
                                if($row4){
                            ?>
                            <input type="hidden" name="rate_item_id" value="<?=$rate_item_id?>">
                            <?php
                                }
                            ?>
                                <div class="col-md-2 p-1 d-flex justify-content-end">
                                    <button
                                    type="submit"
                                    class="btn btn-primary me-1 mb-1"
                                    >
                                    <?=$common_update?>
                                    </button>
                                </div>                        
                            </div>

                    </form>
                    <?php
                        }
                    }
                        ?>

                

                      <!-- edit active-->
                      
                    <form class="form form-horizontal" action="core/mngSessions.php" method="POST"  enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row mb-3 text-white border-bottom pb-3">
                                <div class="col-md-3 bg-<?=$active_bg?> py-2">
                                    <label>Domande</label>
                                </div>
                                <div class="col-md-2 bg-<?=$active_bg?> py-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input delete" type="checkbox" name="activeSess" id="flexSwitchCheckDefault" <?=$checked?>>
                                    </div>
                                </div>
                                <div class="col-md-2 p-1 d-flex justify-content-end">
                                    <button
                                    type="submit"
                                    class="btn btn-primary me-1 mb-1"
                                    >
                                    <?=$common_update?>
                                    </button>
                                </div>                        
                            </div>
                            <input type="hidden" name="operation" value="editActive">
                            <input type="hidden" name="origin" value="editSession">
                            <input type="hidden" name="idToMod" value="<?=$session_id?>">

                    </form>

                    <!-- <form class="form form-horizontal" action="core/mngRate.php" method="POST"  enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row mb-3 text-white border-bottom pb-3">
                                <div class="col-md-3 bg-<?=$rate_bg?> py-2">
                                    <label>Rating system</label>
                                </div>
                                <div class="col-md-2 bg-<?=$rate_bg?> py-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input delete" type="checkbox" name="activeRate" id="flexSwitchCheckDefault" <?=$rate_checked?>>
                                    </div>
                                </div>
                                <div class="col-md-2 p-1 d-flex justify-content-end">
                                    <button
                                    type="submit"
                                    class="btn btn-primary me-1 mb-1"
                                    >
                                    <?=$common_update?>
                                    </button>
                                </div>                        
                            </div>
                            <input type="hidden" name="operation" value="editRateSession">
                            <input type="hidden" name="origin" value="editSession">
                            <input type="hidden" name="idToMod" value="<?=$session_id?>">
                            <input type="hidden" name="rate_item_id" value="<?=$rate_item_id?>">

                    </form> -->


                    <!-- edit session -->
                    <form class="form form-horizontal" action="core/mngSessions.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">

                        <div class="col-md-3">
                            <label><?=$sess_add_name?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$sess_add_name_ph?>"
                                        id="session-name"
                                        name="name"
                                        data-parsley-required="true"
                                        value="<?=$name?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$sess_all_date?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input type="date" name="date" value="<?=$date?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$sess_add_st?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="time"
                                        class="form-control"                                        
                                        name="st"
                                        data-parsley-required="true"
                                        value="<?=$start_time?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">&nbsp;</div>

                        <div class="col-md-3">
                            <label><?=$sess_add_et?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="time"
                                        class="form-control"                                        
                                        name="et"
                                        data-parsley-required="true"
                                        value="<?=$end_time?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">&nbsp;</div>

                        <div class="col-md-3">
                            <label><?=$sess_add_location?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                    <select class="form-select" name="location" id="basicSelect"
                                        data-parsley-required="true">
                                        <?php
                                            
                                            $session->table = "location" ;
                                            $stmt = $session->showAll('id');
                                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                extract($row);
                                                $selected="";
                                                if($row['id']==$location){
                                                    $selected="selected";
                                                }
                                        ?>

                                                <option value="<?=$row['id']?>" <?=$selected?>><?=$row['location_name']?></option>
                                        
                                        <?php
                                            }
                                        ?>
                                        
                                        
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$sess_add_chair?> <?=$account_add_optional?></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <fieldset class="form-group">

                                        <select
                                        class="choices form-select multiple-remove"
                                        multiple="multiple" 
                                        name="chair[]"
                                        >
                                        <?php
                                            $session->table="people_cat_id";
                                            $session->cat_id = 1 ;
                                            $stmt1 = $session->showAllWhere('id',['cat_id']);

                                            while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                                                extract($row1);
                                                $session->table = "people";
                                                $session->id = $row1['people_id'];
                                                $stmt2=$session->showAllWhere('id',['id']);
                                                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                                extract($row2);
                                                if(is_array($row2)){
                                                    $selected="";
                                                    if($chair_arr){

                                                        if(in_array($row2['id'],$chair_arr[0])){
                                                            $selected="selected";
                                                        }
                                                    }
                                                }
                                        ?>

                                            <option value="<?=$row2['id']?>" <?=$selected?>><?=$row2['people_name']?></option>

                                        <?php
                                            }
                                        ?>
                                        </select>
                                    </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="col-md-3">
                            <label><?=$sess_add_expert?> <?=$account_add_optional?></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                    <fieldset class="form-group">
                                        <select
                                        class="choices form-select multiple-remove"
                                        multiple="multiple" 
                                        name="expert[]"
                                        >
                                        <?php
                                            $session->table="people_cat_id";
                                            $session->cat_id = 2 ;
                                            $stmt1 = $session->showAllWhere('id',['cat_id']);

                                            while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                                                extract($row1);
                                                $session->table = "people";
                                                $session->id = $row1['people_id'];
                                                $stmt2=$session->showAllWhere('id',['id']);
                                                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                                extract($row2);                                     
                                                $selected="";
                                                if(in_array($row2['id'],$expert_arr[0])){
                                                    $selected="selected";
                                                }
                                        ?>

                                            <option value="<?=$row2['id']?>" <?=$selected?>><?=$row2['people_name']?></option>

                                        <?php
                                            }
                                        ?>
                                        </select>
                                    </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5><?=$sess_edit_rel_title?></h5>

                        <?php
                            if($relations){
                                $session->table="relations";
                                $stmt4 = $session->showAll('start_time');

                                $relations_arr=[];

                                foreach($stmt4 as $item){
                                    
                                    if(in_array($item['id'],$relations)){
                                        $relations_arr[]=$item['id'];
                                        $relId=$item['id'];

                                        $start=date("H:i", strtotime($item['start_time']));
                                        $end=date("H:i", strtotime($item['end_time']));
                                
                         ?>
                    <div class="row py-3 my-3 border-top">
                        <div class="col-md-5">
                            <label><b><?=$item['relations_name']?></b></label>
                        </div>
                        <div class="col-md-4"><?=$start?>-<?=$end?></div>
                        <div class="col-md-3">
                            
                            <div class="form-check form-switch">
                                <input class="form-check-input delete" type="checkbox" name="check_<?=$relId?>" id="flexSwitchCheckDefault" checked>
                                <label class="form-check-label text-danger" for="flexSwitchCheckDefault"><?=$rel_edit_delete?> </label>
                            </div>
                        </div>
                    </div>
                        <?php
                            }
                        }
                    }
                        ?>  

                        <div class="col-md-3 pt-3 border-top">
                            <label><?=$sess_edit_rel_add?></label>
                        </div>
                        <div class="col-md-9 pt-3 border-top">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                    <fieldset class="form-group">
                                        <select
                                        class="choices form-select multiple-remove"
                                        multiple="multiple" 
                                        name="relations[]"
                                        >
                                        <?php
                                            $session->table="relations";
                                            $session->date = $date_db ;
                                            $stmt1 = $session->showAllWhere('id',['date']);

                                            while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                                                extract($row1);
                                                if($relations){
                                                    if(in_array($row1['id'],$relations)){
                                                        continue;
                                                    }
                                                }
                                        ?>

                                            <option value="<?=$row1['id']?>"><?=$row1['relations_name']?></option>

                                        <?php
                                            }
                                        ?>
                                        </select>
                                    </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <input type="hidden" name="idToMod" value="<?=$session_id?>">
                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="origin" value="editSession">
                      
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