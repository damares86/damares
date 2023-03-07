<?php

$plugin->pluginname = "role_redirect" ;
$redir = $plugin->itemExists('pluginname');

?>
<div class="page-heading">
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$role_add_header?></h3>
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
            <?=$role_add_header?>
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
                <h4 class="card-title"><?=$role_add_title?></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngRoles.php" method="POST" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3">
                            <label><?=$common_rolename?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group has-icon-left">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Role name"
                                        id="first-name-icon"
                                        name="rolename"
                                        data-parsley-required="true"

                                        />
                                        <div class="form-control-icon">
                                        <i class="bi bi-key"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label><?=$common_section_auth?> <span class="text-danger">*</span></label>
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
                                ?>

                                    <option value="<?=$row['id']?>"><?=$row['label']?></option>

                                <?php

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
               
                        <input type="hidden" name="operation" value="add">
                        <input type="hidden" name="origin" value="addRole">
                      
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