<?php

$role->id = filter_input(INPUT_GET,"idToMod");
$stmt1 = $role->showAllWhere('id',['id']);



?>
<div class="page-heading">
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Edit Role</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav
        aria-label="breadcrumb"
        class="breadcrumb-header float-start float-lg-end"
      >
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Edit Role
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
                <h4 class="card-title">Edit the information for <b><?=$rolename?></b></h4>
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
                            <label>Rolename <span class="text-danger">*</span></label>
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
                            <label>Section authorized  <span class="text-danger">*</span></label>
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
                   

                        
                            
                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="idToMod" value="<?=$roleid?>">
                        <input type="hidden" name="origin" value="editRole">
                      
                        <div class="col-12 d-flex justify-content-end">
                            <button
                            type="submit"
                            class="btn btn-primary me-1 mb-1"
                            >
                            Submit
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
                    <h4 class="card-title">Info</h4>
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
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit the password for this account</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngAccounts.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Password <span class="text-danger">*</span></label>
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
                                    <input type="hidden" name="idToMod" value="<?=$id?>">
                                    <input type="hidden" name="origin" value="editAccount">
                            
                                    <div class="col-12 d-flex justify-content-end">
                                        <button
                                            type="submit"
                                            class="btn btn-primary me-1 mb-1"
                                            >
                                            Submit
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