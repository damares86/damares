<?php

$id = filter_input(INPUT_GET,"idToMod") ;
$cfa->id = $id ;
$cfa->table = 'compagnie' ;
$stmt1 = $cfa->showAllWhere('id',['id']) ;
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ;
extract($row1) ;

?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Modifica una compagnia</h3>
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
          Modifica una compagnia
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
                <h4 class="card-title">Modifica la compagnia <b><?=$row1['nome']?></b></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngCompagnie.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
   
                    <div class="row ">

                        <h4 class="card-title mb-3">Anagrafica</h4>

                        <div class="col-md-3">
                                    <label> Ragione sociale <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <div class="form-check mandatory">
                                            <div class="position-relative">
                                                <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Ragione sociale"
                                                name="nome"
                                                data-parsley-required="true"
                                                value="<?=$row1['nome']?>"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div> 

                        <div class="col-md-3">
                            <label>Sede legale <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Sede legale"
                                        name="sede_legale"
                                        data-parsley-required="true"
                                        value="<?=$row1['sede_legale']?>"
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
                                        value="<?=$row1['p_iva']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row border-top mt-3 pt-3">

                        <h4 class="card-title">Dati finanziari</h4>
                        <div class="col-md-3">
                            <label>Provvigioni (%) <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Provvigioni"
                                        name="provv"
                                        data-parsley-required="true"
                                        value="<?=$row1['provv']?>"
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
                                        value="<?=$row1['ritenuta_acconto']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php

                        $checked0 = "" ;
                        $checked1 = "" ;
                        $checked2 = "" ;

                        if( $row1['provv_calcolate_su'] == 0 )
                        {
                            $checked0 = 'checked' ;
                        }
                        else if( $row1['provv_calcolate_su'] == 1 )
                        {
                            $checked1 = 'checked' ;
                        }
                        else if( $row1['provv_calcolate_su'] == 2 )
                        {
                            $checked2 = 'checked' ;
                        }

                        ?>
                        <div class="col-md-3">
                            <label>Provvigioni calcolate su</label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group px-4">
                                <div class="form-check">
                                    <div class="position-relative">
                                        <input class="form-check-input" type="radio" name="provv_calcolate_su"  value="0" <?=$checked0?>>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Imponibile
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="provv_calcolate_su"  value="1" <?=$checked1?>>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                                Netto
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="provv_calcolate_su"  value="2" <?=$checked2?>>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                                Lordo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="idToMod" value="<?=$id?>">
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