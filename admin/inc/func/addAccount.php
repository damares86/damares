<?php
require "inc/funcHeader.php";

?>

<section class="section">
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                <h4 class="card-title">Complete the information for the new account</h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngAccounts.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3">
                            <label>Username <span class="text-danger">*</span></label>
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
                            <label>Email <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group has-icon-left">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="email"
                                        class="form-control"
                                        placeholder="Email"
                                        id="first-name-icon"
                                        name="email"
                                        data-parsley-required="true"
                                        />
                                        <div class="form-control-icon">
                                        <i class="bi bi-envelope"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

                        <div class="col-md-3">
                            <label>Role <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                    <fieldset class="form-group">
                                        <select
                                        class="form-select"
                                        id="role"
                                        name="role"
                                        >
                                        <?php
                                            $stmt = $role->showAll('id');
                                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                if($row['id']>1){
                                        ?>

                                            <option value="<?=$row['id']?>"><?=$row['rolename']?></option>

                                        <?php
                                            }
                                        }
                                        ?>
                                        </select>
                                    </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Avatar (optional)</label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                    <div class="position-relative">
                                    <input
                                    class="form-control"
                                    type="file"
                                    id="formFile"
                                    name="avatar"
                                />
                            </div>
                            </div>
                        </div>
                        <input type="hidden" name="operation" value="add">
                        <input type="hidden" name="origin" value="addAccount">
                      
                        <div class="col-12 d-flex justify-content-end">
                            <button
                            type="submit"
                            class="btn btn-primary me-1 mb-1"
                            >
                            Submit
                            </button>
                            <button
                            type="reset"
                            class="btn btn-light-secondary me-1 mb-1"
                            >
                            Reset
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