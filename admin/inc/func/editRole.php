<?php

$role->id = filter_input(INPUT_GET,"idToMod");
$stmt1 = $role->showAllWhere('id',['id']);

$plugin->pluginname = "role_redirect" ;
$redir = false;
if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
    $redir = true ;
}
?>
<div class="page-heading">
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$role_edit_header?></h3>
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
          <?=$role_edit_header?>
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
                    <?php

                    $roleid="";
                    $rolename="";
                    $redirect="";
                    while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                        $roleid=$row1['id'];
                        $rolename=$row1['rolename'];
                        $redirect=$row1['redirect'];
                    ?>
                <h4 class="card-title"><?=$role_edit_title ?> <b><?=$rolename?></b></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <?php

                       
                            
                            $rolessection->role_id = $row1['id'];
                            $stmt2 = $rolessection->showAllWhere('id',['role_id']);

                            $sections=[];
                            foreach($stmt2 as $item){
                               $sections[]=$item['section_id'];
                            }

                        }
                    ?>
                    <form class="form form-horizontal" action="core/mngRoles.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3">
                            <label><?=$common_rolename ?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group has-icon-left">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Rolename"
                                        id="rolename"
                                        name="rolename"
                                        data-parsley-required="true"
                                        value="<?=$rolename?>"

                                        />
                                        <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label><?=$common_section_auth?>  <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                         <div class="form-group">
                                <select
                                class="choices form-select multiple-remove"
                                multiple="multiple" name="section[]"
                                >
                                <?php
                                    $stmt = $section->showAllTable('id','sectionParent');
                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        extract($row);
                                        $selected = "" ;

                                        // hide sections for non root users
                                        $exclude_sections = [4,5];
                                        if($_SESSION['role_id']!=1 && in_array($row['id'], $exclude_sections)){
                                            continue;
                                        }

                                        if(in_array($row['id'],$sections)){
                                            $selected = "selected";
                                        }
                                ?>

                                    <option value="<?=$row['id']?>" <?=$selected?>><?=$row['label']?></option>

                                <?php
                                        $selected = "" ;

                                }
                                ?>

                                </select>
                            </div>
                        </div>
                   
                        <?php
                    if($redir){
                    ?>
                        <div class="col-md-3">
                            <label><?=$common_redirect?> </label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group has-icon-left">
                                <div class="position-relative">
                                    <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Url"
                                    id="first-name-icon"
                                    name="redirect"
                                    value="<?=$redirect?>"
                                    />
                                    <div class="form-control-icon">
                                    <i class="bi bi-link-45deg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                        
                            
                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="idToMod" value="<?=$roleid?>">
                        <input type="hidden" name="origin" value="editRole">
                      
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
