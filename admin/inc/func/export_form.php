    <!-- export search box -->
    <div id="export_box" class="row">
        <form class="form form-horizontal" action="" method="POST"  enctype="multipart/form-data" data-parsley-validate>
          <div class="form-body">
              <div class="row">

                <div class="col-md-3">
                    <label><?=$common_username ?> <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <div class="form-group has-icon-left">
                        <div class="form-check mandatory">
                            <div class="position-relative">
                                <input
                                type="text"
                                class="form-control"
                                placeholder="Name"
                                id="first-name-icon"
                                name="username"
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
                    <label><?=$common_email ?> <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <div class="form-group has-icon-left">
                        <div class="form-check mandatory">
                            <div class="position-relative">
                                <input
                                type="text"
                                class="form-control"
                                placeholder="Email"
                                id="first-name-icon"
                                name="email"
                                data-parsley-required="true"
                                />
                                <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 

              </div>
            </div>
            <div class="col-12 d-flex justify-content-end">
                <button
                type="submit"
                class="btn btn-primary me-1 mb-1"
                name="search"
                >
                <?=$common_submit?>
                </button>
            </div>
          </form>
          <form class="form form-horizontal" action="" method="POST">
            <button
            type="submit"
            class="btn btn-primary me-1 mb-1"
            name="showall"
            >
            Show all
            </button>
          </form>

          <form class="form form-horizontal" action="core/mngExport.php" method="POST">
          <?php
            $searchKeys = [] ;

            if(isset($_POST['search']))
            {


              foreach($_POST as $key=>$value)
              {
                if($key != 'search')
                {

                  // get all post key and set the class properties
                  $searchKeys[] = $key ;
                  $account->$key = $value ;
                  ?>
                  <input type="hidden" name="<?=$key?>" value="<?=$value?>">
                  <?php
                }
              }
              
              // query based on post data search
              $users = $account->showAllWhere('id',$searchKeys);
            }
            else if(!$_POST || isset($_POST['showall']))
            {
              // if is set showall or is not set anything, search all
              $users = $account->showAll('id');
            }

            if($export)
            {
              ?>

              <style>
                .dataTables_filter {
                  display: none;
                } 
                #export_box{
                  display:block;
                }
              </style>

              <?php
            }

            ?>
            
            <input type="hidden" name="export" value="export">
            <input type="hidden" name="filename" value="<?=$exp_filename?>">
            <input type="hidden" name="class" value="<?=$exp_class?>">
            <input type="hidden" name="table" value="<?=$exp_table?>">
            <input type="hidden" name="origin" value="<?= $exp_origin ?>">
            <button
            type="submit"
            class="btn btn-success me-1 mb-1"
            name="submit_export"
            >
            Export in XLSX
            </button>
          </form>

      </div>
    <!-- end export search box -->