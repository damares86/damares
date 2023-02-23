<?php
require "inc/funcHeader.php";

$users = $account->showAll('id','accounts');

?>



<!-- Basic Tables start -->
<section class="section">
  <div class="card">
    <div class="card-header">All the accounts registered &nbsp; &nbsp; &nbsp; 
                    <a href="index.php?p=addUser" class="btn icon icon-left btn-success"
                        ><i data-feather="plus-circle"></i> Add new account</a
                      ></div>
    <div class="card-body">
      <table class="table" id="table1">
        <thead>
          <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Last login</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          
        <?php
        while($row = $users->fetch(PDO::FETCH_ASSOC)){
          extract($row);
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
              <a href="index.php?p=editUser&idToMod=<?=$row['id']?>" class="btn icon btn-warning"
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
                                    If you click "Ok", you will completely delete this account.
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
                                        ><a href="core/mngAccounts.php?idToDel=<?=$row['id']?>" class="btn btn-danger ml-1">Ok</a></span
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
  </div>
</section>
