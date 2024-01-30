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

    $cfa->id_beneficiario = filter_input(INPUT_GET,"idToDel");
    $cfa->table = 'polizze' ;
    $stmt = $cfa->showAllWhere('id',['id_beneficiario']) ;
    $count = $stmt->rowCount();
            
    if( $count > 0 )
    {
        header("Location: ../index.php?p=allBeneficiari&err=beneficiarioPolizzaExists");
        exit;
    }      


    $cfa->id = filter_input(INPUT_GET,"idToDel");
    $cfa->table = 'beneficiario' ;
    
    if($cfa->delete('id'))
    {
        header("Location: ../index.php?p=allBeneficiari&msg=benefDel");
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allBeneficiari&err=benefNoDel");
        exit;
    }

}

$operation = filter_input(INPUT_POST,"operation") ;


if(filter_input(INPUT_POST,"idToMod"))
{
    
    $idToMod = filter_input(INPUT_POST,"idToMod");
    $cfa->id = $idToMod ;

    // inserimento nuovo beneficiario
    $cfa->ragione_sociale_beneficiario = filter_input(INPUT_POST,'ragione_sociale_beneficiario');
    $cfa->via_beneficiario = filter_input(INPUT_POST,'via_beneficiario');
    $cfa->citta_beneficiario = filter_input(INPUT_POST,'citta_beneficiario');
    $cfa->cap_beneficiario = filter_input(INPUT_POST,'cap_beneficiario');
    $cfa->codice_fiscale_beneficiario = filter_input(INPUT_POST,'codice_fiscale_beneficiario');
    $cfa->p_iva_beneficiario = filter_input(INPUT_POST,'p_iva_beneficiario');
    
    $cfa->table = 'beneficiario' ;
    $err_contraente = '' ;
    if( $cfa->update(['ragione_sociale_beneficiario','via_beneficiario','citta_beneficiario','cap_beneficiario','codice_fiscale_beneficiario','p_iva_beneficiario'],'id') )
    {
        header("Location: ../index.php?p=allBeneficiari&msg=benefEdit");
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allBeneficiari&err=benefNoEdit");
        exit;
    }

}
else if($operation == "add")
{

         // inserimento nuovo beneficiario
         $cfa->ragione_sociale_beneficiario = filter_input(INPUT_POST,'ragione_sociale_beneficiario');
         $cfa->via_beneficiario = filter_input(INPUT_POST,'via_beneficiario');
         $cfa->citta_beneficiario = filter_input(INPUT_POST,'citta_beneficiario');
         $cfa->cap_beneficiario = filter_input(INPUT_POST,'cap_beneficiario');
         $cfa->codice_fiscale_beneficiario = filter_input(INPUT_POST,'codice_fiscale_beneficiario');
         $cfa->p_iva_beneficiario = filter_input(INPUT_POST,'p_iva_beneficiario');
         
         $cfa->table = 'beneficiario' ;
         $err_contraente = '' ;
         if( $cfa->insert(['ragione_sociale_beneficiario','via_beneficiario','citta_beneficiario','cap_beneficiario','codice_fiscale_beneficiario','p_iva_beneficiario']) )
         {
            header("Location: ../index.php?p=allBeneficiari&msg=benefAddSucc");
            exit;
         }
         else
         {
            header("Location: ../index.php?p=allBeneficiari&err=benefAddFail");
            exit;
         }

}
else
{
    header("Location: ../index.php?p=allBeneficiari&err=noPost");
    exit;
}