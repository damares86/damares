<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$account_all_header?></h3>
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
            <?=$account_all_header?>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>


<!-- Basic Tables start -->
<section class="section">
  <div class="card">
    <div class="card-header"><?=$account_all_title ?> &nbsp; &nbsp; &nbsp; 
        <a href="index.php?p=addAccount" class="btn icon icon-left btn-success"
            ><i data-feather="plus-circle"></i> <?=$account_all_add?></a>
    </div>
    <div class="card-body">
      
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
            <input type="hidden" name="export" value="">
            <input type="hidden" name="filename" value="account_export_">
            <input type="hidden" name="fields" value="account">
            <input type="hidden" name="table" value="accounts">
            <input type="hidden" name="origin" value="allAccounts">
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

      <table class="table" id="table1">
        <thead>
          <tr>
            <th><?=$common_username?></th>
            <th><?=$common_email?></th>
            <th><?=$common_role?></th>
            <th><?=$common_lastLogin?></th>
            <th><?=$common_actions?></th>
          </tr>
        </thead>
        <tbody>
          
        <?php
        while($row = $users->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          if($row['id']>2){
        ?>
          <tr>
            <td><?=$row['username']?></td>
            <td><?=$row['email']?></td>
            <td>
              <?php
                $accountroles->account_id = $row['id'];
                $roleId = $accountroles->showAccountRolesId();
                $role->id = $roleId ;
                $rolename = $role->showRolenameById();
                echo $rolename;
              ?>
            </td>
            <td><?=$row['last_login']?></td>
            <td>
              <a href="index.php?p=editAccount&idToMod=<?=$row['id']?>" class="btn icon btn-warning"
                ><i class="bi bi-pencil-square"></i
              ></a>
              &nbsp; &nbsp;
              <a href="#" class="btn icon btn-danger"
                data-bs-toggle="modal"
                data-bs-target="#danger<?=$row['id']?>"><i class="bi bi-trash"></i>
              </a>
                  <!--Danger theme Modal -->
                  <div
                              class="modal fade text-left"
                              id="danger<?=$row['id']?>"
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
                                    <?=$account_all_modal_body?>
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
                                        ><a href="core/mngAccounts.php?idToDel=<?=$row['id']?>" class="btn btn-danger ml-1">
                                          <?=$common_modal_confirm?>
                                        </a></span
                                      >
                                  </div>
                                </div>
                              </div>
                            </div>
            </td>
          </tr>
                          

                        

        <?php
        }
      }

        ?>



        </tbody>
      </table>
    </div>
  </div>
</section>
