<?php

$id = filter_input(INPUT_GET,"idToMod") ;
$rsa->id = $id ;
$rsa->table = 'pazienti' ;
$stmt1 = $rsa->showAllWhere('id',['id']) ;
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ;
extract($row1) ;

?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Modifica un paziente</h3>
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
          Modifica un paziente
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
                <h4 class="card-title">Modifica il paziente <b><?=$row1['cognome']?> <?=$row1['nome']?></b></h4>
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
                                                value="<?=$row1['cognome']?>"
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
                                                value="<?=$row1['nome']?>"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">&nbsp;</div>
                                <hr class="my-3">
                                <h5 class="my-3 mb-5">Farmaci</h5>

                                <div class="row">
                                    <?php

                                    $rsa->table = 'pazientiFarmaci' ;
                                    $rsa->id_pazienti = $row1['id'] ;

                                    $stmt2 = $rsa->showAllWhere('id',['id_pazienti']) ;

                                    if($stmt2->rowCount()>0)
                                    {
                                        $i = 0 ;
                                        while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC) )
                                        {
                                            $i++ ;
                                            extract($row2) ;

        
                                        ?>
                                        <div class="row">     
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
                                                            name="farmaco_<?=$i?>"
                                                            >
                                                            <?php
                                                                $id_farmaci = $row2['id_farmaci'] ;
                                                                $rsa->table = "farmaci" ;
                                                                $stmt = $rsa->showAll('id');
                                                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                                    $selected = "";
                                                                    if($row['id'] == $id_farmaci )
                                                                    {
                                                                        $selected = 'selected' ;
                                                                    }
                                                            ?>

                                                                <option value="<?=$row['id']?>" <?=$selected?>><?=$row['principio']?></option>

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
                                                            name="cpr_<?=$i?>"
                                                            data-parsley-required="true"
                                                            value="<?=$row2['cpr']?>"
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
                                                            name="magazzino_<?=$i?>"
                                                            data-parsley-required="true"
                                                            value="<?=$row2['magazzino']?>"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check form-switch px-5">
                                                    <input class="form-check-input delete" type="checkbox" name="del_<?=$i?>" id="flexSwitchCheckDefault" >
                                                    <label class="form-check-label text-danger" for="flexSwitchCheckDefault">Elimina </label>
                                                </div>
                                            </div>

                                            <span class="mb-3"></span>
                                        </div>

                                        <?php
                                        }
                                    }
                                    else
                                    {
                                    ?>
                                        <p>Nessun farmaco presente</p>
                                    <?php
                                    }

                                        ?>

                                </div>
                    


                        <input type="hidden" name="operation" value="edit">
                        <input type="hidden" name="counter" value="<?=$i?>">
                        <input type="hidden" name="origin" value="editPaziente">
                        <input type="hidden" name="idToMod" value="<?=$row1['id']?>">
                      
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

                    <hr class="my-3">

                    <h5 class="my-3 mb-5">Aggiungi farmaco</h5>
                    <form class="form form-horizontal" action="core/mngPazienti.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                        <div class="form-body">

                            <div class="row">     
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
                                                    $stmt = $rsa->showAll('principio');
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
                                <div class="col-md-1">
                                    &nbsp;
                                    <!-- <button type="button" name="remove" id="1" class="btn btn-danger btn_remove p-2 text-center">X</button> -->
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

                            <input type="hidden" name="operation" value="addFarmaco">
                            <input type="hidden" name="origin" value="editPaziente">
                            <input type="hidden" name="idToMod" value="<?=$row1['id']?>">
                        
                        </div>
                    </form>

                </div>
                </div>
            </div>
        </div>
       
    </div>
</section>