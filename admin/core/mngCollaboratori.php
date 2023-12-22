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

    $cfa->id = filter_input(INPUT_GET,"idToDel");
    $cfa->table = 'collaboratori' ;
    
    if($cfa->delete('id'))
    {
        header("Location: ../index.php?p=allCollaboratori&msg=collabDel");
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allCollaboratori&err=collabNotDel");
        exit;
    }

}

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
    $cfa->provvigioni_dare = filter_input(INPUT_POST,'provvigioni_dare') ;
    $cfa->provvigioni_avere = filter_input(INPUT_POST,'provvigioni_avere') ;

    // details

    $cfa->table = 'collaboratori' ;

    if($cfa->update(['nome','cognome','sede_legale','sede_operativa','telefono','cellulare','email','pec','codice_fiscale','p_iva','ritenuta_acconto','iban','banca','provvigioni_dare','provvigioni_avere'],'id'))
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
    $cfa->provvigioni_dare = filter_input(INPUT_POST,'provvigioni_dare') ;
    $cfa->provvigioni_avere = filter_input(INPUT_POST,'provvigioni_avere') ;

    // details

    $cfa->table = 'collaboratori' ;

    if($cfa->insert(['nome','cognome','sede_legale','sede_operativa','telefono','cellulare','email','pec','codice_fiscale','p_iva','ritenuta_acconto','iban','banca','provvigioni_dare','provvigioni_avere']))
    {
        header("Location: ../index.php?p=allCollaboratori&msg=collabAddSucc");
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