<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Calcola un ordine</h3>
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
          Calcola un ordine
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
                <h4 class="card-title">Ordine</h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngOrdini.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">

                            <div class="col-md-2">
                                <label>Scegliere il mese<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <div class="form-check mandatory">
                                        <div class="position-relative">
                                        <fieldset class="form-group">
                                            <select class="form-select" name="mese">                                
                                                <option value="01">Gennaio</option>
                                                <option value="02">Febbraio</option>
                                                <option value="03">Marzo</option>
                                                <option value="04">Aprile</option>
                                                <option value="05">Maggio</option>
                                                <option value="06">Giugno</option>
                                                <option value="07">Luglio</option>
                                                <option value="08">Agosto</option>
                                                <option value="09">Settembre</option>
                                                <option value="10">Ottobre</option>
                                                <option value="11">Novembre</option>
                                                <option value="12">Dicembre</option>
                                            </select>
                                        </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                     
                        <input type="hidden" name="operation" value="add">
                        <input type="hidden" name="origin" value="addOrdini">

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