<?php

$id = filter_input(INPUT_GET,"idToMod") ;
$cfa->id = $id ;
$cfa->table = 'collaboratori' ;
$stmt1 = $cfa->showAllWhere('id',['id']) ;
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ;
extract($row1) ;

?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Modifica un collaboratore</h3>
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
          Modifica un collaboratore
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
                <h4 class="card-title">Modifica il collaboratore <b><?=$row1['cognome']?> <?=$row1['nome']?></b></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngCollaboratori.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3">
                                    <label> Nome <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group has-icon-left">
                                        <div class="form-check mandatory">
                                            <div class="position-relative">
                                                <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Nome"
                                                id="first-name-icon"
                                                name="nome"
                                                data-parsley-required="true"
                                                value="<?=$row1['nome']?>"
                                                />
                                                <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3">
                                    <label> Cognome <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group has-icon-left">
                                        <div class="form-check mandatory">
                                            <div class="position-relative">
                                                <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Cognome"
                                                id="first-name-icon"
                                                name="cognome"
                                                data-parsley-required="true"
                                                value="<?=$row1['cognome']?>"
                                                />
                                                <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>    
                        </div>
                    </div>

                    <div class="row border-top mt-3 pt-3">

                        <h4 class="card-title">Anagrafica</h4>

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
                                        id="first-name-icon"
                                        name="sede_legale"
                                        data-parsley-required="true"
                                        value="<?=$row1['sede_legale']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Sede operativa <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Sede operativa"
                                        id="first-name-icon"
                                        name="sede_operativa"
                                        data-parsley-required="true"
                                        value="<?=$row1['sede_operativa']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-md-3">
                            <label>Telefono <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Telefono"
                                        id="first-name-icon"
                                        name="telefono"
                                        data-parsley-required="true"
                                        value="<?=$row1['telefono']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Cellulare <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Cellulare"
                                        id="first-name-icon"
                                        name="cellulare"
                                        data-parsley-required="true"
                                        value="<?=$row1['cellulare']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?= $common_email ?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="email"
                                        class="form-control"
                                        placeholder="Email"
                                        id="first-name-icon"
                                        name="email"
                                        data-parsley-required="true"
                                        value="<?=$row1['email']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>                        

                        <div class="col-md-3">
                            <label>PEC <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="email"
                                        class="form-control"
                                        placeholder="PEC"
                                        id="first-name-icon"
                                        name="pec"
                                        data-parsley-required="true"
                                        value="<?=$row1['pec']?>"
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
                                        id="first-name-icon"
                                        name="codice_fiscale"
                                        data-parsley-required="true"
                                        value="<?=$row1['codice_fiscale']?>"
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
                                        id="first-name-icon"
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
                            <label>Ritenuta d'acconto (%) <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="0.0"
                                        id="first-name-icon"
                                        name="ritenuta_acconto"
                                        data-parsley-required="true"
                                        value="<?=$row1['ritenuta_acconto']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>IBAN <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="IBAN"
                                        id="first-name-icon"
                                        name="iban"
                                        data-parsley-required="true"
                                        value="<?=$row1['iban']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Banca <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Banca"
                                        id="first-name-icon"
                                        name="banca"
                                        data-parsley-required="true"
                                        value="<?=$row1['banca']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-3">
                            <label>Iscrizioni RUI <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Iscrizioni RUI"
                                        id="first-name-icon"
                                        name="iscrizione_rui"
                                        value="<?=$row1['iscrizione_rui']?>"
                                        data-parsley-required="true"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Consulenza (%) <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="0"
                                        id="first-name-icon"
                                        name="consulenza_collab"
                                        value="<?=$row1['consulenza_collab']?>"
                                        data-parsley-required="true"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>                  
                        
                        <div class="col-md-3">
                            <label>Premio (%) <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="0"
                                        name="premio_collab"
                                        value="<?=$premio_collab?>"
                                        data-parsley-required="true"
                                        />
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

                       
                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="origin" value="editCollaboratore">
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