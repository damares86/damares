<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Aggiungi un paziente</h3>
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
          Aggiungi un paziente
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
                <h4 class="card-title">Paziente</h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngPazienti.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Cognome <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-check mandatory">
                                            <div class="position-relative">
                                                <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Cognome del paziente"
                                                name="cognome"
                                                data-parsley-required="true"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">&nbsp;</div>

                                <div class="col-md-3">
                                    <label>Nome <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-check mandatory">
                                            <div class="position-relative">
                                                <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Nome del paziente"
                                                name="nome"
                                                data-parsley-required="true"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">&nbsp;</div>
                                <hr class="my-3">
                                <h5 class="my-3 mb-5">Farmaci</h5>

                                <div class="row" id="dynamic_field">
                                    <div class="row" id="row1">     
                                        <div class="col-md-2">
                                            <label>Principio attivo <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-check mandatory">
                                                    <div class="position-relative">
                                                    <fieldset class="form-group">
                                                        <select
                                                        class="form-select"
                                                        name="farmaco"
                                                        >
                                                        <?php
                                                            $rsa->table = "farmaci" ;
                                                            $stmt = $rsa->showAll('id');
                                                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                        ?>

                                                            <option value="<?=$row['id']?>"><?=$row['principio']?></option>

                                                        <?php
                                                        }
                                                        ?>
                                                        </select>
                                                    </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">N° cpr die</div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <div class="form-check mandatory">
                                                    <div class="position-relative">
                                                        <input
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="0"
                                                        name="cpr"
                                                        data-parsley-required="true"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            Scatole
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <div class="form-check mandatory">
                                                    <div class="position-relative">
                                                        <input
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="0"
                                                        name="magazzino"
                                                        data-parsley-required="true"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            &nbsp;
                                        </div>

                                        <span class="mb-3"></span>
                                    </div>
                                </div>

                         <!-- <button type="button" name="add" id="add" class="btn btn-success w-25">Aggiungi farmaco</button> -->


                        </div>
                     
                        <input type="hidden" name="operation" value="add">
                        <input type="hidden" name="origin" value="addPaziente">

                        <input type="hidden" name="counter" value="1" id="counter">
                      
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
                    </form>
                </div>
                </div>
                </div>
                                            </div>
        </div>
       
</section>