    <div id="export_box"  class="row border-top border-bottom pt-3 pb-3">
      <div class="col-7 p3">
        <!-- export search box -->
        <div class="row">
          <h3><?=$exp_title_search?></h3>
            <form class="form form-horizontal" action="" method="POST"  enctype="multipart/form-data" data-parsley-validate>
              <div class="form-body">
                  <div class="row">
                    <?php
                        $fields_name = $exp_class.'_form_fields' ;
                        require 'core/exportSettings.php';

                        $type="text" ;
                        
                        foreach($$fields_name as $field)
                        {
                          if($field == $exp_date_field)
                          {
                            $type="date";
                          }

                          $field_title = ucfirst($field) ;
                          $field_title = str_replace("_"," ", $field_title) ;
                    ?>
                        <div class="col-md-3">
                            <label><?=$field_title?><span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="<?=$type?>"
                                        class="form-control"
                                        id="first-name-icon"
                                        name="<?=$field?>"
                                        data-parsley-required="true"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div> 
                    <?php
                        }
                    ?>
      
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
          </div>
      </div>
      <div class="col-5 p-3 margin">
        <h3><?=$exp_title_show?></h3>
        <form class="form form-horizontal" action="" method="POST">
            <button
            type="submit"
            class="btn btn-primary me-1 mb-1"
            name="showall"
            >
            <?=$exp_btn_show ?>
            </button>
          </form>
        <h3 class="mt-3"><?=$exp_title_export?></h3>
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
              $$exp_var = $$exp_class->showAllWhere('id',$searchKeys);
            }
            else if(!$_POST || isset($_POST['showall']))
            {
              // if is set showall or is not set anything, search all
              $$exp_var = $$exp_class->showAll('id');
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
            <?=$exp_btn_export?>
            </button>
          </form>
      </div>
    </div>
    
   
         
    <!-- end export search box -->