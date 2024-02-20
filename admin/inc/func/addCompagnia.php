<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$cfa_compagnia_header?></h3>
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
            <?=$cfa_compagnia_header?>
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
                <h4 class="card-title"><?=$cfa_compagnia_title?></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngCompagnie.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
   
                    <div class="row ">

                        <h4 class="card-title mb-3"><?=$cfa_anagrafica?></h4>

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
                                                name="nome"
                                                data-parsley-required="true"

                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div> 

                        <div class="col-md-3">
                            <label><?=$cfa_sede_legale?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$cfa_sede_legale?>"
                                        name="sede_legale"
                                        data-parsley-required="true"
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
                                        name="p_iva"
                                        data-parsley-required="true"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row border-top mt-3 pt-3">

                        <h4 class="card-title"><?=$cfa_dati_finanziari?></h4>
                        
                        <div class="col-md-3">
                            <label><?=$cfa_provv?> (%) <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$cfa_provv?>"
                                        name="provv"
                                        data-parsley-required="true"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Ritenuta d'acconto (%)</label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="0"
                                        name="ritenuta_acconto"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Provvigioni calcolate su</label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group px-4">
                                <div class="form-check">
                                    <div class="position-relative">
                                        <input class="form-check-input" type="radio" name="provv_calcolate_su"  value="0" checked>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Imponibile
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="provv_calcolate_su"  value="1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                                Netto
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="provv_calcolate_su"  value="2">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                                Lordo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php

                        require "core/collaboratoreDetails.php";
                        foreach($collaboratore_details as $item){

                            $label = "account_add_$item";
                            $item_label=ucfirst($item);

                        ?>
                        <div class="col-md-3">
                            <label><?=$item_label?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <?php                                                              
                                                $type="text";
                                                if($item=="birth"){
                                                    $type="date";
                                                }
                                            ?>
                                            <input
                                            type="<?=$type?>"
                                            class="form-control"
                                            placeholder="<?=$item_label?>"
                                            name="<?=$item?>"
                                            data-parsley-required="true"

                                            />
                                            <?php
                                            
                                            ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php

                        }

                        foreach($collaboratore_details_opt as $item){

                            $label = "account_add_$item";
                            $item_label=ucfirst($item);

                        ?>
                        <div class="col-md-3">
                            <label><?=$item?> <?=$account_add_optional?></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="position-relative">
                                    <?php
                                        $type="text";
                                        if($item=="birth"){
                                            $type="date";
                                        }
                                    ?>
                                    <input
                                    type="<?=$type?>"
                                    class="form-control"
                                    placeholder="<?=$item_label?>"
                                    name="<?=$item?>"

                                    />

                                </div>
                            </div>
                        </div>

                        <?php

                        }

                        ?>

                       
                        <input type="hidden" name="operation" value="add">
                        <input type="hidden" name="origin" value="addCompagnia">
                      
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