<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$cfa_benef_header ?></h3>
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
            <?=$cfa_benef_header ?>
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
            <div class="card">
                <div class="card-header">
                <h4 class="card-title"><?=$cfa_benef_title?></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngBeneficiari.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                    <div class="row">
                       
                        <div class="col-md-3">
                            <label><?=$cfa_ragione_sociale?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$cfa_ragione_sociale?>"
                                        name="ragione_sociale_beneficiario"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$cfa_indirizzo?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$cfa_indirizzo?>"
                                        name="via_beneficiario"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$cfa_citta?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$cfa_citta?>"
                                        name="citta_beneficiario"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$cfa_cap?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$cfa_cap?>"
                                        name="cap_beneficiario"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$cfa_codice_fiscale?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$cfa_codice_fiscale?>"
                                        name="codice_fiscale_beneficiario"
                                        maxlength="16"
                                        data-parsley-maxlength="16"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$cfa_piva?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$cfa_piva?>"
                                        name="p_iva_beneficiario"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>



                        <input type="hidden" name="operation" value="add">
                        <input type="hidden" name="origin" value="addBeneficiario">
                      
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
       
    </div>
</section>