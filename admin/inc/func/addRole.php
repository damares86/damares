<?php

$plugin->pluginname = "role_redirect";
$redir = false;
if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {
    $redir = true;
}

?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $role_add_header ?></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php"><?= $common_dashboard ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= $role_add_header ?>
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
                        <h4 class="card-title"><?= $role_add_title ?></h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="core/mngRoles.php" method="POST" data-parsley-validate>
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label><?= $common_rolename ?> <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group has-icon-left">
                                                <div class="form-check mandatory">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Role name" id="first-name-icon" name="rolename" data-parsley-required="true" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-key"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label><?= $common_section_auth ?> <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-12 rounded bg-light px-5 py-2 my-1">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <h5><?=$role_header_parent?></h5>
                                                </div>
                                                <div class="col-md-7">
                                                    <h5><?=$role_header_child?></h5>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $section->table = 'sectionParent' ;
                                        $stmt = $section->showAll('id');

                                        $role_id = $_SESSION['role_id'];
                                        $rolessection->role_id = $role_id;
                                        $permission = $rolessection->showAllPermission('id', ['role_id']);
                                        
                                        $sectionOk = [];

                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                                        {
                                            extract($row);

                                            // hide sections for non root users

                                            foreach ($permission as $item) 
                                            {
                                                if ($item['role_id'] == $role_id) {
                                                    $sectionOk[] = $item['section_id'];
                                                }
                                            }

                                            // if($role_id==1 || ($role_id==2 && $row['id']!=4) || in_array($row['id'],$sectionOk)){
                                            if ($role_id == 1 ||  in_array($row['id'], $sectionOk)) {
                                        

                                        ?>
                                                <div class="col-md-12 rounded bg-light px-5 py-2 my-1">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-check">
                                                                    <div class="checkbox">
                                                                        <input type="checkbox" name="section[]" class="form-check-input" value="<?= $row['id'] ?>" data-parsley-required data-parsley-mincheck="1">
                                                                        <label><?= $row['label'] ?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <?php
                                                                $section->table = 'sectionChild';
                                                                $section->parent_id = $row['id'] ;
                                                                $stmt1 = $section->showAllWhere('id',['parent_id']);
                                                                while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                                                    extract($row1);
                        
                                                                    // hide sections for non root users
                                                                    $role_id = $_SESSION['role_id'];
                                                                    $rolessection->role_id = $role_id;
                                                                    $rolessection->table = 'rolesSectionChild' ;
                                                                    $permissionChild = $rolessection->showAllPermission('id', ['role_id']);
                        
                                                                    $sectionChildOk = [];
                                                                    foreach ($permissionChild as $item) 
                                                                    {
                                                                        if ($item['role_id'] == $role_id) {
                                                                            $sectionChildOk[] = $item['section_id'];
                                                                        }
                                                                    }
                        
                                                                    if ($role_id == 1 ||  in_array($row1['id'], $sectionChildOk)) {
                        
                                                                ?>
                                                                <div class="form-check">
                                                                    <div class="checkbox">
                                                                        <input type="checkbox" name="sectionChild[]" class="form-check-input" value="<?= $row1['id'] ?>">
                                                                        <label><?= $row1['label'] ?></label>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                        <?php
                                            }
                                        }
                                        
                                        if ($redir) {
                                        ?>
                                            <div class="col-md-3">
                                                <label><?= $common_redirect ?> </label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group has-icon-left">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Url" id="first-name-icon" name="redirect" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-link-45deg"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <input type="hidden" name="operation" value="add">
                                        <input type="hidden" name="origin" value="addRole">

                                        <div class="col-12 mt-3 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">
                                                <?= $common_submit ?>
                                            </button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                                <?= $common_reset ?>
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
                        <h4 class="card-title"><?= $common_info ?></h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>