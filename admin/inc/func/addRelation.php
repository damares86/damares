<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$rel_add_header ?></h3>
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
            <?=$rel_add_header ?>
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
                <h4 class="card-title"><?=$rel_add_title?></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngRelations.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">

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
                                        <input type="date" name="date">
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
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">&nbsp;</div>

                        <div class="col-md-3">
                            <label><?=$rel_add_location?> <span class="text-danger">*</span></label>
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
                                        ?>

                                                <option value="<?=$row['id']?>"><?=$row['location_name']?></option>
                                        
                                        <?php
                                            }
                                        ?>
                                        
                                        
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$speakers_all_header?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
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
                                        ?>

                                            <option value="<?=$row['id']?>"><?=$row['speakers_name']?></option>

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
                                        ?>

                                            <option value="<?=$row['id']?>"><?=$row['people_name']?></option>

                                        <?php
                                                }
                                        }
                                        ?>
                                        </select>
                                    </div>
                            </div>
                        </div>

                        <input type="hidden" name="operation" value="add">
                        <input type="hidden" name="origin" value="addRelation">
                      
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