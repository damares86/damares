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

    $cfa->id_contraente = filter_input(INPUT_GET,"idToDel");
    $cfa->table = 'polizze' ;
    $stmt = $cfa->showAllWhere('id',['id_contraente']) ;
    $count = $stmt->rowCount();
            
    if( $count > 0 )
    {
        header("Location: ../index.php?p=allContraenti&err=contrPolizzaExists");
        exit;
    }      
    
    $cfa->id = filter_input(INPUT_GET,"idToDel");
    $cfa->table = 'contraente' ;
    
    if($cfa->delete('id'))
    {
        header("Location: ../index.php?p=allContraenti&msg=contrDel");
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allContraenti&err=contrNoDel");
        exit;
    }

}

$operation = filter_input(INPUT_POST,"operation") ;


if(filter_input(INPUT_POST,"idToMod"))
{
    
    $idToMod = filter_input(INPUT_POST,"idToMod");
    $cfa->id = $idToMod ;

    // inserimento nuovo contraente
    $cfa->ragione_sociale_contraente = filter_input(INPUT_POST,'ragione_sociale_contraente');
    $cfa->nome_contraente = filter_input(INPUT_POST,'nome_contraente');
    $cfa->cognome_contraente = filter_input(INPUT_POST,'cognome_contraente');
    $cfa->via_contraente = filter_input(INPUT_POST,'via_contraente');
    $cfa->citta_contraente = filter_input(INPUT_POST,'citta_contraente');
    $cfa->cap_contraente = filter_input(INPUT_POST,'cap_contraente');
    $cfa->codice_fiscale_contraente = filter_input(INPUT_POST,'codice_fiscale_contraente');
    $cfa->p_iva_contraente = filter_input(INPUT_POST,'p_iva_contraente');
    $cfa->telefono_contraente = filter_input(INPUT_POST,'telefono_contraente');
    $cfa->cellulare_contraente = filter_input(INPUT_POST,'cellulare_contraente');
    $cfa->email_contraente = filter_input(INPUT_POST,'email_contraente');
    
    $cfa->table = 'contraente' ;
    $err_contraente = '' ;
    if( $cfa->update(['ragione_sociale_contraente','nome_contraente','cognome_contraente','via_contraente','citta_contraente','cap_contraente','codice_fiscale_contraente','p_iva_contraente','telefono_contraente','cellulare_contraente','email_contraente'],'id') )
    {
        header("Location: ../index.php?p=allContraenti&msg=contrEdit");
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allContraenti&err=contrNoEdit");
        exit;
    }

}
else if($operation == "add")
{

         // inserimento nuovo contraente
         $cfa->ragione_sociale_contraente = filter_input(INPUT_POST,'ragione_sociale_contraente');
         $cfa->nome_contraente = filter_input(INPUT_POST,'nome_contraente');
         $cfa->cognome_contraente = filter_input(INPUT_POST,'cognome_contraente');
         $cfa->via_contraente = filter_input(INPUT_POST,'via_contraente');
         $cfa->citta_contraente = filter_input(INPUT_POST,'citta_contraente');
         $cfa->cap_contraente = filter_input(INPUT_POST,'cap_contraente');
         $cfa->codice_fiscale_contraente = filter_input(INPUT_POST,'codice_fiscale_contraente');
         $cfa->p_iva_contraente = filter_input(INPUT_POST,'p_iva_contraente');
         $cfa->telefono_contraente = filter_input(INPUT_POST,'telefono_contraente');
         $cfa->cellulare_contraente = filter_input(INPUT_POST,'cellulare_contraente');
         $cfa->email_contraente = filter_input(INPUT_POST,'email_contraente');
         
         $cfa->table = 'contraente' ;
         $err_contraente = '' ;
         if( $cfa->insert(['ragione_sociale_contraente','nome_contraente','cognome_contraente','via_contraente','citta_contraente','cap_contraente','codice_fiscale_contraente','p_iva_contraente','telefono_contraente','cellulare_contraente','email_contraente']) )
         {
            header("Location: ../index.php?p=allContraenti&msg=contrAddSucc");
            exit;
         }
         else
         {
            header("Location: ../index.php?p=allContraenti&err=contrAddFail");
            exit;
         }

}
else
{
    header("Location: ../index.php?p=allContraenti&err=noPost");
    exit;
}