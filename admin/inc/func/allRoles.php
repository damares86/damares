<?php
require "inc/funcHeader.php";

$allroles = $role->showAll('id');

?>



<!-- Basic Tables start -->
<section class="section">
  <div class="card">
    <div class="card-header">All the roles &nbsp; &nbsp; &nbsp; 
                    <a href="index.php?p=addRole" class="btn icon icon-left btn-success"
                        ><i data-feather="plus-circle"></i> Add new role</a
                      ></div>
    <div class="card-body">
      <table class="table" id="table1">
        <thead>
          <tr>
            <th>Rolename</th>
            <th>Redirect</th>
            <th>Number of users</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          
        <?php
        while($row = $allroles->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          if($row['id']>1){
        ?>
          <tr>
            <td><?=$row['rolename']?></td>
            <td><?=$row['redirect']?></td>
            <td>
              <?php
                $accountroles->role_id = $row['id'];
                $roleNum = $accountroles->countRoleAccounts();
                echo $roleNum;
              ?>
            </td>
            <td>
              <a href="index.php?p=editRole&idToMod=<?=$row['id']?>" class="btn icon btn-warning"
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
                                      Are you sure?
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
                                    If you click "Ok", you will completely delete this role.
                                  </div>
                                  <div class="modal-footer">
                                    <button
                                      type="button"
                                      class="btn btn-light-secondary"
                                      data-bs-dismiss="modal"
                                    >
                                      <i class="bx bx-x d-block d-sm-none"></i>
                                      <span class="d-none d-sm-block"
                                        >Cancel</span
                                      >
                                    </button>
                                      <span class="d-none d-sm-block"
                                        ><a href="core/mngRoles.php?idToDel=<?=$row['id']?>" class="btn btn-danger ml-1">Ok</a></span
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
