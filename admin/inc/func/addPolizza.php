<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Aggiungi una polizza</h3>
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
            Aggiungi una polizza
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
                <h4 class="card-title">Aggiungi una nuova polizza</h4>
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
                                        <select class="choices form-select" data-parsley-required="true">
                                        <?php
                                            while($item = $collab->fetch(PDO::FETCH_ASSOC))
                                            {
                                        ?>
                                            <option name="id_collaboratore[]" value="<?=$item['id']?>"><?=$item['cognome']?> <?=$item['nome']?></option>
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
                                        <select class="choices form-select" data-parsley-required="true">
                                        <?php
                                            while($item = $company->fetch(PDO::FETCH_ASSOC))
                                            {
                                        ?>
                                            <option name="id_compagnia[]" value="<?=$item['id']?>"><?=$item['nome']?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>

                    <div class="row border-top mt-3 pt-3">

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
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row border-top mt-3 pt-3">

                        <p>
                            <a class="btn btn-primary mb-2" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Toggle first element</a>
                            <a class="btn btn-primary mb-2" data-bs-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Toggle first element</a>
                            <button class="btn btn-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Toggle second element</button>
                            <button class="btn btn-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">Toggle both elements</button>
                        </p>
                        <div class="row" id="multiCollapseExample1">
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
                                            <select class="choices form-select" data-parsley-required="true">
                                            <?php
                                                while($item = $contr->fetch(PDO::FETCH_ASSOC))
                                                {
                                            ?>
                                                <option name="id_contraente[]" value="<?=$item['id']?>"><?=$item['cognome']?> <?=$item['nome']?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>

                        <div class="row" id="multiCollapseExample2">
                            <div class="col">
                                <div class="collapse multi-collapse" >
                                    <div class="card card-body">
                                        Some placeholder content for the first collapse component of this multi-collapse example. This panel is hidden by default but revealed when the user activates the relevant trigger.
                                    </div>
                                </div>
                            </div>
                        </div>

                       
<!-- 
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
                                        <select class="choices form-select" data-parsley-required="true">
                                        <?php
                                            while($item = $benef->fetch(PDO::FETCH_ASSOC))
                                            {
                                        ?>
                                            <option name="id_beneficiario[]" value="<?=$item['id']?>"><?=$item['ragione_sociale']?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div> -->
                    
                    <div class="row border-top mt-3 pt-3">













                    </div>








                    <div class="row border-top mt-3 pt-3">

                        <h4 class="card-title">Dati finanziari</h4>

                        <div class="col-md-3">
                            <label>Netto <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Netto"
                                        name="netto"
                                        data-parsley-required="true"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Imponibile <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Imponibile"
                                        name="imponibile"
                                        data-parsley-required="true"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Lordo <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Lordo"
                                        name="lordo"
                                        data-parsley-required="true"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>                        

                        <div class="col-md-3">
                            <label>Spese <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Spese"
                                        name="spese"
                                        data-parsley-required="true"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <label>Provvigioni <span class="text-danger">*</span></label>
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

                       
                        <input type="hidden" name="operation" value="add">
                        <input type="hidden" name="origin" value="addPolizze">
                      
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