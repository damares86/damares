<?php

$id = filter_input(INPUT_GET,"idToMod") ;
$cfa->id = $id ;
$cfa->table = 'beneficiario' ;
$stmt1 = $cfa->showAllWhere('id',['id']) ;
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ;
extract($row1) ;

?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Modifica un beneficiario</h3>
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
          Modifica un beneficiario
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
                <h4 class="card-title">Modifica il beneficiario <b><?=$row1['ragione_sociale_beneficiario']?></b></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngBeneficiari.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                           
                                <div class="col-md-3">
                                    <label>Ragione sociale <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <div class="form-check mandatory">
                                            <div class="position-relative">
                                                <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Ragione sociale"
                                                name="ragione_sociale_beneficiario"
                                                value=<?=$row1['ragione_sociale_beneficiario']?>
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label>Indirizzo <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <div class="form-check mandatory">
                                            <div class="position-relative">
                                                <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Indirizzo"
                                                name="via_beneficiario"
                                                value=<?=$row1['via_beneficiario']?>
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label>Città <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <div class="form-check mandatory">
                                            <div class="position-relative">
                                                <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Città"
                                                name="citta_beneficiario"
                                                value=<?=$row1['citta_beneficiario']?>
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label>CAP <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <div class="form-check mandatory">
                                            <div class="position-relative">
                                                <input
                                                type="text"
                                                class="form-control"
                                                placeholder="CAP"
                                                name="cap_beneficiario"
                                                value=<?=$row1['cap_beneficiario']?>
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label>Codice fiscale <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <div class="form-check mandatory">
                                            <div class="position-relative">
                                                <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Codice fiscale"
                                                name="codice_fiscale_beneficiario"
                                                value=<?=$row1['codice_fiscale_beneficiario']?>
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label>Partita IVA <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <div class="form-check mandatory">
                                            <div class="position-relative">
                                                <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Partita IVA"
                                                name="p_iva_beneficiario"
                                                value=<?=$row1['p_iva_beneficiario']?>
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="operation" value="edit">
                                <input type="hidden" name="origin" value="editBeneficiario">
                                <input type="hidden" name="idToMod" value="<?=$row1['id']?>">
                            
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