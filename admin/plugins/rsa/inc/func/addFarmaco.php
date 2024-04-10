<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Aggiungi un farmaco</h3>
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
          Aggiungi un farmaco
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                <h4 class="card-title">Farmaco</h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngFarmaci.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Principio attivo <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-check mandatory">
                                            <div class="position-relative">
                                                <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Nome del principio attivo"
                                                name="principio"
                                                data-parsley-required="true"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-md-3">&nbsp;</div>

                                <div class="col-md-3">
                                    <label>Compresse per scatola <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="form-check mandatory">
                                            <div class="position-relative">
                                                <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Numero compresse"
                                                name="cpr_box"
                                                data-parsley-required="true"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-6">&nbsp;</div>


                        </div>
                     
                        <input type="hidden" name="operation" value="add">
                        <input type="hidden" name="origin" value="addFarmaco">
                      
                        <div class="col-12 d-flex justify-content-end">
                            <button
                            type="submit"
                            class="btn btn-primary me-1 mb-1 shadow"
                            >
                            <?=$common_submit?>
                            </button>
                            <button
                            type="reset"
                            class="btn btn-light-secondary me-1 mb-1 shadow"
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
       
    </div>
</section>