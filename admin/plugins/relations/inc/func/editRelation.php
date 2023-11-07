<?php

$relation_id= filter_input(INPUT_GET,"idToMod");
$relation->id = $relation_id;
$relation->table="relations";
$stmt1 = $relation->showAllWhere('id',['id']);

$plugin->pluginname = "rating_system" ;
$rating = false;
// $cookie_rating="";
// if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
//     $rating = true ;
//     if(isset($_COOKIE['damares-rate'])){
//       $cookie_rating=json_decode($_COOKIE['damares-rate'],true);
//     }
// }

?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$rel_edit_header?></h3>
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
            <?=$rel_edit_header?>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>
<?php

                  $id=$relation_id;
                  $relId=$relation_id;
                  $name="";
                  $date="";
                  $start_time="";
                  $end_time="";
                  $location="";
                  $speakers_arr=[];
                  $ann_arr=[];
                  $active="";
                  $active_bg="danger";
                  $checked="";
                  $rate_active = "";

                      while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                        extract($row1);

                        $id=$row1['id'];
                        $relId=$row1['id'];
                        $name=$row1['relations_name'];
                        // $date=$row1['date'];
                        $date=date("Y-m-d", strtotime($row1['date']));
                        $start_time=$row1['start_time'];
                        $end_time=$row1['end_time'];
                        $location=$row1['location'];
                        $ann=$row1['announcer_id'];
                        $ann_arr = explode(",",$ann);

                        $active=$row1['active'];

                        if($active==1){
                            $active_bg="success";
                            $checked="checked";
                        }

                        $speakers_str=$row1['speakers_id'];
                        $speakers_arr=explode(",",$speakers_str); 
                      }
                      if($rating){
                      $rate->item_id=$id;
                      $rate->table = "item_rate" ;
                      $stmt4 = $rate->showAllWhere('id',['item_id']);
                      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
                      
                      $rate_bg="danger";
                      $rate_checked="";
                      if($row4){

                          extract($row4);
                          $rate_item_id=$row4['id'];
                          if($row4['rate_active']==1){
                              $rate_bg="success";
                              $rate_checked="checked";
                            }
                        }
                    }
                        ?>

<section class="section">
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                <h4 class="card-title"><?=$rel_edit_title?> <u><?=$name?></u> </h4>
                </div>
                <div class="card-content">
                <div class="card-body">

                      <!--edit active-->
                    <!-- <form class="form form-horizontal" action="core/mngRelations.php" method="POST"  enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row mb-3 text-white border-bottom pb-3">
                                <div class="col-md-3 bg-<?=$active_bg?> py-2">
                                    <label><?=$rel_edit_active?></label>
                                </div>
                                <div class="col-md-2 bg-<?=$active_bg?> py-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input delete" type="checkbox" name="activeRel" id="flexSwitchCheckDefault" <?=$checked?>>
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
                            <input type="hidden" name="origin" value="editRelation">
                            <input type="hidden" name="idToMod" value="<?=$relation_id?>">

                    </form> -->

                    <?php
                    if($rating){
                        $rate->cat_name = "relations" ;
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
                            <input type="hidden" name="operation" value="editRateRelation">
                            <input type="hidden" name="origin" value="editRelation">
                            <input type="hidden" name="idToMod" value="<?=$relation_id?>">
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

                    <!-- edit session -->
                    <form class="form form-horizontal" action="core/mngRelations.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                        <div class="form-body">
                        <div class="row">
                            <input type="hidden" name="idToMod" value="<?=$relation_id?>">
                        <div class="col-md-3">
                            <label><?=$rel_add_name?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$rel_add_name_ph?>"
                                        id="relation-name"
                                        name="name"
                                        data-parsley-required="true"
                                        value="<?=$name?>"

                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label><?=$rel_all_date?> <span class="text-danger">*</span></label>
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
                            <label><?=$rel_add_st?> <span class="text-danger">*</span></label>
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
                            <label><?=$rel_add_et?> <span class="text-danger">*</span></label>
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
                            <label><?=$rel_add_announcer?> <?=$account_add_optional?></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                    <div class="position-relative">
                                    <fieldset class="form-group">
                                        <select
                                        class="choices form-select multiple-remove"
                                        multiple="multiple" 
                                        name="announcer[]"
                                        >
                                        <?php

                                            $session->table="people";
                                            $stmt = $session->showAll('id');
                                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                $session->table = "people_cat_id";
                                                $session->people_id = $row['id'];
                                                $session->cat_id = 3 ;
                                                $stmt1 = $session->showAllWhere('id',['people_id','cat_id']);
                                                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                                if($row1){
                                                    $selected="";
                                                    if(in_array($row['id'],$ann_arr)){
                                                        $selected="selected";
                                                    }
                                        ?>

                                            <option value="<?=$row['id']?>" <?=$selected?>><?=$row['people_name']?></option>

                                        <?php
                                        }
                                    }
                                        ?>
                                        </select>
                                    </div>
                            </div>
                        </div>


                        <div class="col-md-3 mt-5">
                            <label><h4><?=$speakers_all_header?></h4></label>
                        </div>
                        <div class="col-md-9">&nbsp;</div>
                        
                        <?php
                            $relation->table="speakers";
                            $stmt4 = $relation->showAll('id');
                            $speakers=[];
                            $count=0;
                            foreach($stmt4 as $item){
                                    
                                if(in_array($item['id'],$speakers_arr)){
                                    $speakers[]=$item['id'];
                                    $speaker_id=$item['id'];
                                    $relation->relation_id = $relation_id ;
                                    $relation->speaker_id = $speaker_id ;
                                    $stmt2 = $relation->showAllWhereTable('id','relations_speakers_doc',['relation_id','speaker_id']);
                  
                                
                         ?>
 
                        <div class="col-md-6 border-top pt-3">
                            <label><h5><?=$item['speakers_name']?></h5></label>
                        </div>
                        <div class="col-md-6 border-top pt-3">
                            
                            <div class="form-check form-switch">
                                <input class="form-check-input delete" type="checkbox" name="check_<?=$speaker_id?>" id="flexSwitchCheckDefault" checked>
                                <label class="form-check-label text-danger" for="flexSwitchCheckDefault"><?=$rel_edit_delete?> </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?=$file_all_label?></th>
                                        <th><?=$file_all_file?></th>
                                        <th><?=$common_link?></th>
                                        <th><?=$common_actions?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                                    extract($row2);
                                    $relation->id = $row2['speaker_doc_id'];
                                    $stmt3 = $relation->showAllWhereTable('id','speakers_doc',['id']);
                                    $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);


                                    ?>
                                    <tr>
                                    <td><?=$row3['label']?></td>
                                    <td><?=$row3['speakers_doc_name']?></td>
                                    <td><a href="../uploads/<?=$row3['speakers_doc_name']?>" target="_blank"><?=$common_link?></a></td>
                                    <td>
                                        
                                        <a href="#" class="btn icon btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#danger<?=$row3['id']?>"><i class="bi bi-trash"></i>
                                        </a>
                                            <!--Danger theme Modal -->
                                            <div
                                                        class="modal fade text-left"
                                                        id="danger<?=$row3['id']?>"
                                                        tabindex="-1"
                                                        role="dialog"
                                                        aria-labelledby="myModalLabel120"
                                                        aria-hidden="true"
                                                        >
                                                        <div
                                                            class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                            role="document"
                                                        >
                                                            <div class="modal-content">
                                                            <div class="modal-header bg-danger">
                                                                <h5
                                                                class="modal-title white"
                                                                id="myModalLabel120"
                                                                >
                                                                <?=$common_modal_title_sure?>
                                                                </h5>
                                                                <button
                                                                type="button"
                                                                class="close"
                                                                data-bs-dismiss="modal"
                                                                aria-label="Close"
                                                                >
                                                                <i data-feather="x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?=$file_all_modal_body?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button
                                                                type="button"
                                                                class="btn btn-light-secondary"
                                                                data-bs-dismiss="modal"
                                                                >
                                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                                <span class="d-none d-sm-block"
                                                                    ><?=$common_modal_cancel?></span
                                                                >
                                                                </button>
                                                                <span class="d-none d-sm-block"
                                                                    ><a href="core/mngRelations.php?fileIdToDel=<?=$row3['id']?>&relId=<?=$relId?>" class="btn btn-danger ml-1"><?=$common_modal_confirm?></a></span
                                                                >
                                                            </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-3 my-3">
                            <label class="border-bottom"><?=$file_all_add?></label>
                        </div>
                        <div class="col-md-9">&nbsp;</div>
                        <div class="col-2">
                            <label><?=$file_all_label?></label>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$rel_edit_file_ph?>"
                                        name="myfile_label_<?=$speaker_id?>"

                                        />
                                    </div>
                                </div>
                            </div>
                        <div class="col-5">
                            <div class="form-group">
                                    <div class="position-relative">
                                        <input
                                        class="form-control"
                                        type="file"
                                        name="myfile_doc_<?=$speaker_id?>"
                                    />
                                    </div>
                                </div>

                        </div>
                        <?php
                        
                         }
                            }
                        ?>
                        <hr>
                        <div class="col-md-3">
                            <label><?=$rel_edit_add_speaker?> </label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check">
                                    <div class="position-relative">
                                    <fieldset class="form-group">
                                        <select
                                        class="choices form-select multiple-remove"
                                        multiple="multiple" 
                                        name="speakers[]"
                                        >
                                        <?php
                                            $relation->table="speakers";
                                            $stmt = $relation->showAll('id');
                                            
                                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                if(!in_array($row['id'],$speakers)){
                                                $selected="";
                                                if(in_array($row['id'],$speakers_arr)){
                                                    $selected="selected";
                                                }
                                        ?>

                                            <option value="<?=$row['id']?>" <?=$selected?>><?=$row['speakers_name']?></option>

                                        <?php
                                            }
                                        }
                                        ?>
                                        </select>
                                    </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="origin" value="editRelation">
                      
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