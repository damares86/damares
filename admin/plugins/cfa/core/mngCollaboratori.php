<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__."/coreConfig.php";

// check if there's an account to delete

if(filter_input(INPUT_GET,"idToDel"))
{

    $cfa->id_collaboratore = filter_input(INPUT_GET,"idToDel");
    $cfa->table = 'polizze' ;
    $stmt = $cfa->showAllWhere('id',['id_collaboratore']) ;
    $count = $stmt->rowCount();
            
    if( $count > 0 )
    {
        header("Location: ../index.php?p=allCollaboratori&err=collaboratorePolizzaExists");
        exit;
    }      


    $cfa->id = filter_input(INPUT_GET,"idToDel");
    $cfa->table = 'collaboratori' ;
    
    if($cfa->delete('id'))
    {
        header("Location: ../index.php?p=allCollaboratori&msg=collabDel");
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allCollaboratori&err=collabNoDel");
        exit;
    }

}

// query filter

$query = filter_input(INPUT_POST,"query") ;
$origin = filter_input(INPUT_POST,"origin") ;

if($query == 'mese')
{
    
    $month = filter_input(INPUT_POST,'mese') ;
    $year = filter_input(INPUT_POST,'anno') ; 
    
    header("Location: ../index.php?p=$origin&mese=$month&anno_mese=$year");
    exit;
    
}
else if($query == 'trimestre')
{
    $year = filter_input(INPUT_POST,'anno') ;
    $trim = filter_input(INPUT_POST,'trimestre') ;

    header("Location: ../index.php?p=$origin&trim=$trim&anno_trim=$year");
    exit;
}
else if($query == 'anno')
{

    $year = filter_input(INPUT_POST,'anno') ;

    header("Location: ../index.php?p=$origin&anno=$year");
    exit;
}


// operations            

$operation = filter_input(INPUT_POST,"operation") ;

if(filter_input(INPUT_POST,"idToMod"))
{
    
    $cfa->id = filter_input(INPUT_POST,"idToMod");

    $cfa->nome = filter_input(INPUT_POST,'nome') ;
    $cfa->cognome = filter_input(INPUT_POST,'cognome') ;
    $cfa->sede_legale = filter_input(INPUT_POST,'sede_legale') ;
    $cfa->sede_operativa = filter_input(INPUT_POST,'sede_operativa') ;
    $cfa->telefono = filter_input(INPUT_POST,'telefono') ;
    $cfa->cellulare = filter_input(INPUT_POST,'cellulare') ;
    $cfa->email = filter_input(INPUT_POST,'email') ;
    $cfa->pec = filter_input(INPUT_POST,'pec') ;
    $cfa->codice_fiscale = filter_input(INPUT_POST,'codice_fiscale') ;
    $cfa->p_iva = filter_input(INPUT_POST,'p_iva') ;
    $cfa->ritenuta_acconto = filter_input(INPUT_POST,'ritenuta_acconto') ;
    $cfa->iban = filter_input(INPUT_POST,'iban') ;
    $cfa->banca = filter_input(INPUT_POST,'banca') ;
    $cfa->iscrizione_rui = filter_input(INPUT_POST,'iscrizione_rui') ; 
    $cfa->consulenza_collab = filter_input(INPUT_POST,'consulenza_collab') ;
    $cfa->premio_collab = filter_input(INPUT_POST,'premio_collab') ;

    // details

    $cfa->table = 'collaboratori' ;

    if($cfa->update(['nome','cognome','sede_legale','sede_operativa','telefono','cellulare','email','pec','codice_fiscale','p_iva','ritenuta_acconto','iban','banca','iscrizione_rui','consulenza_collab','premio_collab'],'id'))
    {
        header("Location: ../index.php?p=allCollaboratori&msg=collabEdit");
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allCollaboratori&err=collabNoEdit");
        exit;
    }

}
else if($operation == "add")
{

    $cfa->nome = filter_input(INPUT_POST,'nome') ;
    $cfa->cognome = filter_input(INPUT_POST,'cognome') ;
    $cfa->sede_legale = filter_input(INPUT_POST,'sede_legale') ;
    $cfa->sede_operativa = filter_input(INPUT_POST,'sede_operativa') ;
    $cfa->telefono = filter_input(INPUT_POST,'telefono') ;
    $cfa->cellulare = filter_input(INPUT_POST,'cellulare') ;
    $cfa->email = filter_input(INPUT_POST,'email') ;
    $cfa->pec = filter_input(INPUT_POST,'pec') ;
    $cfa->codice_fiscale = filter_input(INPUT_POST,'codice_fiscale') ;
    $cfa->p_iva = filter_input(INPUT_POST,'p_iva') ;
    $cfa->ritenuta_acconto = filter_input(INPUT_POST,'ritenuta_acconto') ;
    $cfa->iban = filter_input(INPUT_POST,'iban') ;
    $cfa->banca = filter_input(INPUT_POST,'banca') ;
    $cfa->iscrizione_rui = filter_input(INPUT_POST,'iscrizione_rui') ;
    $cfa->consulenza_collab = filter_input(INPUT_POST,'consulenza_collab') ;
    $cfa->premio_collab = filter_input(INPUT_POST,'premio_collab') ;

    // details

    $cfa->table = 'collaboratori' ;

    if($cfa->insert(['nome','cognome','sede_legale','sede_operativa','telefono','cellulare','email','pec','codice_fiscale','p_iva','ritenuta_acconto','iban','banca','iscrizione_rui','consulenza_collab','premio_collab']))
    {

        $pag_err = '' ;

        $cfa->table = 'collaboratori' ;
        $cfa->p_iva = filter_input(INPUT_POST,'p_iva') ;
        $stmt = $cfa->showAllWhere('id',['p_iva']) ;
        $row = $stmt->fetch(PDO::FETCH_ASSOC) ;
        extract($row) ;

        $cfa->id_collaboratore= $row['id'] ;
        $cfa->da_pagare = 0 ;
        $cfa->table = 'pag_collaboratore' ;
        if(!$cfa->insert(['id_collaboratore','da_pagare']))
        {
            $pag_err = '&err=noPagIns' ;
        }

        header("Location: ../index.php?p=allCollaboratori&msg=collabAddSucc$pag_err");
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allCollaboratori&err=collabAddFail");
        exit;
    }


}
else
{
    header("Location: ../index.php?p=allCollaboratori&err=noPost");
    exit;
}