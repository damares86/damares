<?php

$id = filter_input(INPUT_GET,"idToMod") ;
$cfa->id = $id ;
$cfa->table = 'polizze' ;
$stmt1 = $cfa->showAllWhere('id',['id']) ;
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ;
extract($row1) ;

?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Modifica una polizza</h3>
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
          Modifica una polizza
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>

<script src="script/parsley_validate_switch.js"></script>

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                <h4 class="card-title">Modifica polizza numero: <?=$row1['numero']?></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngPolizze.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
   
                    <div class="row ">

                        <div class="col-md-3">
                            <label>Collaboratore <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                    <?php
                                        $cfa->table = 'collaboratori' ;
                                        $collab = $cfa->showAll('id');          
                                        ?>
                                        <select class="choices form-select" name="id_collaboratore[]" data-parsley-required="true">
                                            <?php
                                            while($item = $collab->fetch(PDO::FETCH_ASSOC))
                                            {
                                                $sel_collab = '' ;                                                           
                                                if($item['id'] == $row1['id_collaboratore'])
                                                {
                                                    $sel_collab = 'selected' ;
                                                }
                                        ?>
                                            <option value="<?=$item['id']?>" <?=$sel_collab?>> <?=$item['cognome']?> <?=$item['nome']?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Compagnia <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                    <?php
                                        $cfa->table = 'compagnie' ;
                                        $company = $cfa->showAll('id');                                                 
                                        
                                        ?>
                                        <select class="choices form-select"  name="id_compagnia[]" data-parsley-required="true">
                                            <?php
                                            while($item = $company->fetch(PDO::FETCH_ASSOC))
                                            {
                                                $sel_company = '' ;                                               
                                                if( $item['id'] == $row1['id_compagnia'] )
                                                {
                                                    $sel_company = 'selected' ;
                                                }
                                        ?>
                                            <option value="<?=$item['id']?>" <?=$sel_company?>><?=$item['nome']?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="col-md-3">
                            <label><?=$cfa_netto?></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$cfa_netto?>"
                                        name="netto"
                                        value="<?=$row1['netto']?>"
                                        data-parsley-required="true"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Diritti</label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Diritti"
                                        name="diritti"
                                        value="<?=$row1['diritti']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$cfa_imponibile?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$cfa_imponibile?>"
                                        name="imponibile"
                                        value="<?=$row1['imponibile']?>"
                                        data-parsley-required="true"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$cfa_lordo?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$cfa_lordo?>"
                                        name="lordo"
                                        value="<?=$row1['lordo']?>"
                                        data-parsley-required="true"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>                        

                        <div class="col-md-3">
                            <label><?=$cfa_spese?></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Spese"
                                        name="spese"
                                        value="<?=$row1['spese']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Imposte <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Imposte"
                                        name="imposte"
                                        value="<?=$row1['imposte']?>"
                                        data-parsley-required="true"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row border-top mt-3 pt-3">

                        <h4 class="card-title mb-3">Dati polizza</h4>
                        <div class="col-md-3">
                            <label>Numero polizza <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Numero"
                                        name="numero"
                                        data-parsley-required="true"
                                        value="<?=$row1['numero']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Tipologia <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Tipologia"
                                        name="tipologia"
                                        data-parsley-required="true"
                                        value="<?=$row1['tipologia']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Descrizione <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <textarea class="form-control" name="descrizione" rows="3" data-parsley-required="true"><?=$row1['descrizione']?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Importo gara </label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Importo gara"
                                        name="importo_gara"
                                        value="<?=$row1['importo_gara']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    
                    <div class="row border-top mt-3 pt-3">
                    <h4 class="card-title mb-3">Contraente</h4>

                    <style>
                    .box{display:none};
                    </style>

                    <?php
                    $exists_contr='checked';
                    $new_contr='';
                    ?>
                    <script>
                        $(document).ready(function(){
                            $('input[name="contraente"]').click(function(){
                                var inputValue = $(this).attr("value");
                                var targetBox = $("." + inputValue);
                                $('.box').not(targetBox).hide();
                                $(targetBox).show();
                            });
                        });
                    </script>
                    <style>
                    .box.exists_contr{display:block}
                    </style> 
                    <div class="row mb-3">
                        <div class="col-2">
                            <label class="d-inline"><input type="radio" id="contr_exists" name="contraente" value="exists_contr" <?=$exists_contr?>> Cerca contraente</label>
                        </div>
                        <div class="col-2">
                            <label class="d-inline"><input type="radio" id="contr_new" name="contraente" value="new_contr" <?=$new_contr?>> Aggiungi contraente</label>
                        </div>
                    </div>

                    <div class="exists_contr box">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Contraente <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="form-check mandatory">
                                        <div class="position-relative">
                                        <?php
                                            $cfa->table = 'contraente' ;
                                            $contr = $cfa->showAll('id');  
                                            ?>
                                            <select class="choices form-select" name="id_contraente[]" data-parsley-required="true">
                                                <?php
                                                while($item = $contr->fetch(PDO::FETCH_ASSOC))
                                                {
                                                    $sel_contraente = '' ; 
                                                    if( $item['id'] == $row1['id_contraente'] )
                                                    {
                                                        $sel_contraente = 'selected'  ;
                                                    }
                                            ?>
                                                <option value="<?=$item['id']?>" <?=$sel_contraente?>><?=$item['cognome_contraente']?> <?=$item['nome_contraente']?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="new_contr box">
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
                                            name="ragione_sociale_contraente"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>Nome <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="form-check mandatory">
                                        <div class="position-relative">
                                            <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Nome"
                                            name="nome_contraente"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>Cognome <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="form-check mandatory">
                                        <div class="position-relative">
                                            <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Cognome"
                                            name="cognome_contraente"
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
                                            name="via_contraente"
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
                                            name="citta_contraente"
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
                                            name="cap_contraente"
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
                                            name="codice_fiscale_contraente"
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
                                            name="p_iva_contraente"
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
                                            placeholder="telefono"
                                            name="telefono_contraente"
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
                                            name="cellulare_contraente"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>Email <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="form-check mandatory">
                                        <div class="position-relative">
                                            <input
                                            type="email"
                                            class="form-control"
                                            placeholder="Email"
                                            name="email_contraente"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                       
                    <div class="row border-top mt-3 pt-3">

                    <h4 class="card-title mb-3">Beneficiario</h4>

                        <style>
                        .box_benef{display:none};
                        </style>

                        <?php
                        $exists_benef='checked';
                        $new_benef='';
                        ?>
                        <script>
                            $(document).ready(function(){
                                $('input[name="beneficiario"]').click(function(){
                                    var inputValue = $(this).attr("value");
                                    var targetBox = $("." + inputValue);
                                    $('.box_benef').not(targetBox).hide();
                                    $(targetBox).show();
                                });

                            });
                        </script>
                        <style>
                        .box_benef.exists_benef{display:block}
                        </style>
                        <div class="row mb-3">
                            <div class="col-2">
                                <label class="d-inline"><input type="radio" name="beneficiario" value="exists_benef" <?=$exists_benef?>> Cerca beneficiario</label>
                            </div>
                            <div class="col-2">
                                <label class="d-inline"><input type="radio" name="beneficiario" value="new_benef" <?=$new_benef?>> Aggiungi beneficiario</label>
                            </div>
                        </div>

                        <div class="exists_benef box_benef">
                            <div class="row">
                            <div class="col-md-3">
                                <label>Beneficiario <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="form-check mandatory">
                                        <div class="position-relative">
                                        <?php
                                            $cfa->table = 'beneficiario' ;
                                            $benef = $cfa->showAll('id');                  
                                            ?>
                                            <select class="choices form-select"  name="id_beneficiario[]" data-parsley-required="true">
                                                <?php
                                                while($item = $benef->fetch(PDO::FETCH_ASSOC))
                                                {
                                                    $sel_beneficiario = '' ;                                               
                                                    if( $item['id'] == $row1['id_beneficiario'] )
                                                    {
                                                        $sel_beneficiario =  'selected' ;
                                                    }
                                            ?>
                                                <option value="<?=$item['id']?>" <?=$sel_beneficiario?>><?=$item['ragione_sociale_beneficiario']?></option>
                                            <?php

                                                }
                                            ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            </div>
                        </div>
                        <div class="new_benef box_benef">
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
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                       
                    </div>

                    <div class="row border-top mt-3 pt-3">

                        <h4 class="card-title mb-3">Dati economici</h4>
                        
                        <div class="col-md-3">
                            <label>Massimale <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Massimale"
                                        name="massimale"
                                        data-parsley-required="true"
                                        value="<?=$row1['massimale']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Data d'inizio <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="date"
                                        class="startDate input form-control"
                                        id="startDate"
                                        name="st"
                                        data-parsley-required="true"
                                        value="<?=$row1['st']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            $('.startDate').change(function(){
                            var startDate = $('.startDate').val();

                            if(startDate != ''){
                                var d = new Date(Date.parse(startDate));      
                                var dmy = [d.getDate(),d.getMonth() + 1,d.getFullYear()];
                                
                                // Format date
                                for (var n = 0; n < 2; n++){
                                if (dmy[n].toString().length < 2){
                                    dmy[n] = "0" + dmy[n];
                                }
                                }
                                
                                $('.endDate').attr('min',(dmy[2] + "-" + dmy[1] + "-" + dmy[0]));
                                
                                if($('.dateRange select').val() == 'Between' && $('.endDate').val() != ''){
                                $('.endDate').parsley().validate();
                                }
                            }
                            });
                        </script>

                        <div class="col-md-3">
                            <label>Data di fine <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="date"
                                        class="endDate form-control"
                                        name="et"
                                        data-parsley-required="true"
                                        data-parsley-gt="#st"
                                        value="<?=$row1['et']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-3">
                            <label>Data di incasso <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="date"
                                        class="endDate form-control"
                                        name="incasso_data"
                                        data-parsley-required="true"
                                        value="<?=$row1['incasso_data']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                                                
                        <div class="col-md-3">
                            <label>Modalità d'incasso <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Modalità d'incasso"
                                        name="incasso_mod"
                                        data-parsley-required="true"
                                        value="<?=$row1['incasso_mod']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <label>Consulenza <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Consulenza"
                                        name="consulenza"
                                        data-parsley-required="true"
                                        value="<?=$row1['consulenza']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label>Pagato da compagnia</label>
                        </div>
                        <div class="col-md-9 mt-2">
                            <div class="form-group">
                                <div class="form-check">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Pagato"
                                        name="pagato_da_compagnia"
                                        value="<?=$row1['pagato_da_compagnia']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label>Compagnia pagata</label>
                        </div>
                        <div class="col-md-9 mt-2">
                            <div class="form-group">
                                <div class="form-check form-switch px-5">
                                    <input type="hidden" name="old_compagnia_pagato" value="<?=$row1['compagnia_pagato']?>">
                                    <?php
                                        $checked = '' ;
                                        if( $row1['compagnia_pagato'] == 1 )
                                        {
                                            $checked = 'checked' ;
                                        }
                                    ?>
                                    <input class="form-check-input delete" type="checkbox" name="compagnia_pagato" id="flexSwitchCheckDefault" <?=$checked?>>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label>Pagato da collaboratore</label>
                        </div>
                        <div class="col-md-9 mt-2">
                            <div class="form-group">
                                <div class="form-check">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Pagato"
                                        name="pagato_da_collaboratore"
                                        value="<?=$row1['pagato_da_collaboratore']?>"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>                      

                        <div class="col-md-3 mt-2">
                            <label>Collaboratore pagato</label>
                        </div>
                        <div class="col-md-9 mt-2">
                            <div class="form-group">
                                <div class="form-check form-switch px-5">
                                <input type="hidden" name="old_collaboratore_pagato" value="<?=$row1['collaboratore_pagato']?>">

                                    <?php
                                        $checked = '' ;
                                        if( $row1['collaboratore_pagato'] == 1 )
                                        {
                                            $checked = 'checked' ;
                                        }
                                    ?>
                                    <input class="form-check-input delete" type="checkbox" name="collaboratore_pagato" id="flexSwitchCheckDefault" <?=$checked?>>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label><b>Premio totale</b></label>
                        </div>
                        <div class="col-md-9 px-3 mt-2">
                            <div class="form-group">
                                <?php
                                    $premio = $row1['imponibile'] + $row1['diritti'] + $row1['spese'] + $row1['imposte'] ;
                                ?>
                                <p><b><?=$premio?> €</b></p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Copia direzione<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check form-switch px-5">
                                    <?php
                                        $checked = '' ;
                                        if( $row1['copia_direzione'] == 1 )
                                        {
                                            $checked = 'checked' ;
                                        }
                                    ?>
                                    <input class="form-check-input delete" type="checkbox" name="copia_direzione" id="flexSwitchCheckDefault" <?=$checked?>>
                                </div>
                            </div>
                        </div>
                       
                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="origin" value="editPolizza">
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