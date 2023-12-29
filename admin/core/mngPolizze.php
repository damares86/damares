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
    $cfa->table = 'polizze' ;
    
    if($cfa->delete('id'))
    {
        header("Location: ../index.php?p=allPolizze&msg=polizzeDel");
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allPolizze&err=polizzaNoDel");
        exit;
    }

}

$operation = filter_input(INPUT_POST,"operation") ;


if(filter_input(INPUT_POST,"idToMod"))
{
    $idToMod = filter_input(INPUT_POST,"idToMod");
    $cfa->id = $idToMod ;

    $cfa->id_collaboratore = $_POST['id_collaboratore'][0] ;
    $cfa->id_compagnia = $_POST['id_compagnia'][0] ;    
    $cfa->numero = filter_input(INPUT_POST, 'numero') ;
    $cfa->tipologia = filter_input(INPUT_POST, 'tipologia') ;
    $cfa->descrizione = filter_input(INPUT_POST, 'descrizione') ;
    $cfa->importo_gara = filter_input(INPUT_POST, 'importo_gara') ;
    
    $contraente = $_POST['contraente'] ;

    if( $contraente == 'exists_contr' )
    {
        $cfa->id_contraente = $_POST['id_contraente'][0] ;
    }
    else
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
        if( !$cfa->insert(['ragione_sociale_contraente','nome_contraente','cognome_contraente','via_contraente','citta_contraente','cap_contraente','codice_fiscale_contraente','p_iva_contraente','telefono_contraente','cellulare_contraente','email_contraente']) )
        {

            $err_contraente = '&err=errContraente' ;
        }
        else
        {
            $cfa->codice_fiscale_contraente = filter_input(INPUT_POST,'codice_fiscale_contraente');
            $cfa->table = 'contraente' ;
            $stmt1 = $cfa->showAllWhere('id',['codice_fiscale_contraente']) ;
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            extract($row1) ;
            $cfa->id_contraente = $row1['id'] ;
        }
    }

    $beneficiario = $_POST['beneficiario'] ;

    if( $beneficiario == 'exists_benef' )
    {
        $cfa->id_beneficiario =  $_POST['id_beneficiario'][0] ;
    }   
    else
    {
        // inserimento nuovo beneficiario
        $cfa->ragione_sociale_beneficiario = filter_input(INPUT_POST,'ragione_sociale_beneficiario');
        $cfa->via_beneficiario = filter_input(INPUT_POST,'via_beneficiario');
        $cfa->citta_beneficiario = filter_input(INPUT_POST,'citta_beneficiario');
        $cfa->cap_beneficiario = filter_input(INPUT_POST,'cap_beneficiario');
        $cfa->codice_fiscale_beneficiario = filter_input(INPUT_POST,'codice_fiscale_beneficiario');
        $cfa->p_iva_beneficiario = filter_input(INPUT_POST,'p_iva_beneficiario');
  
        $cfa->table = 'beneficiario' ;
        $err_beneficiario = '' ;
        if( !$cfa->insert(['ragione_sociale_beneficiario','via_beneficiario','citta_beneficiario','cap_beneficiario','codice_fiscale_beneficiario','p_iva_beneficiario']) )
        {
            $err_beneficiario = '&err=errBeneficiario' ;
        }
        else
        {
            $cfa->codice_fiscale_beneficiario = filter_input(INPUT_POST,'codice_fiscale_beneficiario');
            $cfa->table = 'beneficiario' ;
            $stmt1 = $cfa->showAllWhere('id',['codice_fiscale_beneficiario']) ;
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            extract($row1) ;
            $cfa->id_beneficiario = $row1['id'] ;            
        }
    } 

    $cfa->massimale = filter_input(INPUT_POST,'massimale') ;
    $cfa->st = filter_input(INPUT_POST,'st') ;
    $cfa->et = filter_input(INPUT_POST,'et') ;
    $cfa->consulenza = filter_input(INPUT_POST,'consulenza') ;
    $cfa->incasso_data = filter_input(INPUT_POST,'incasso_data') ;
    $cfa->incasso_mod = filter_input(INPUT_POST,'incasso_mod') ;
    $cfa->pagato = filter_input(INPUT_POST,'pagato') ;
    $cfa->broker = filter_input(INPUT_POST,'broker') ;
    if(filter_input(INPUT_POST,'copia_direzione'))
    {
        $cfa->copia_direzione = 1 ;
    }
    else
    {
        $cfa->copia_direzione = 0 ;
    }

    // details

    $cfa->table = 'polizze' ;

    if($cfa->update(['id_collaboratore','id_compagnia','numero','tipologia','id_contraente','id_beneficiario','descrizione','importo_gara','massimale','st','et','consulenza','incasso_data','incasso_mod','pagato','broker','copia_direzione'],'id'))
    {

        // CALENDAR
        $calendar->updateCalendar() ;
        
        header("Location: ../index.php?p=editPolizza&idToMod=$idToMod&msg=polizzeEdit".$err_contraente.$err_beneficiario);
        exit;
    }
    else
    {
        header("Location: ../index.php?p=editPolizza&idToMod=$idtoMod&err=polizzaNoEdit");
        exit;
    }


}
else if($operation == 'query')
{  

    if( filter_input(INPUT_POST,'st') == null && filter_input(INPUT_POST,'st') == null )
    {
        header("Location: ../index.php?p=allUtili&err=queryEmpty") ;
    }

    $str = '' ;

    if( filter_input(INPUT_POST,'st') )
    {
        $str .= '&st='.filter_input(INPUT_POST,'st').'&st_op='.filter_input(INPUT_POST,'start_date') ;
    }

    if( filter_input(INPUT_POST,'et') )
    {
        $str .= '&et='.filter_input(INPUT_POST,'et').'&et_op='.filter_input(INPUT_POST,'end_date') ;
    }

    header("Location: ../index.php?p=allUtili&query=true$str");
    exit;

}    
else if($operation == "add")
{
    
    $cfa->id_collaboratore = $_POST['id_collaboratore'][0] ;
    $cfa->id_compagnia = $_POST['id_compagnia'][0] ;    
    $cfa->numero = filter_input(INPUT_POST, 'numero') ;
    $cfa->tipologia = filter_input(INPUT_POST, 'tipologia') ;
    $cfa->descrizione = filter_input(INPUT_POST, 'descrizione') ;
    $cfa->importo_gara = filter_input(INPUT_POST, 'importo_gara') ;
    
    $contraente = $_POST['contraente'] ;
    
    if( $contraente == 'exists_contr' )
    {
        $cfa->id_contraente = $_POST['id_contraente'][0] ;
    }
    else
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
        if( !$cfa->insert(['ragione_sociale_contraente','nome_contraente','cognome_contraente','via_contraente','citta_contraente','cap_contraente','codice_fiscale_contraente','p_iva_contraente','telefono_contraente','cellulare_contraente','email_contraente']) )
        {

            $err_contraente = '&err=errContraente' ;
        }
        else
        {
            $cfa->codice_fiscale_contraente = filter_input(INPUT_POST,'codice_fiscale_contraente');
            $cfa->table = 'contraente' ;
            $stmt1 = $cfa->showAllWhere('id',['codice_fiscale_contraente']) ;
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            extract($row1) ;
            $cfa->id_contraente = $row1['id'] ;
        }
    }


    $beneficiario = $_POST['beneficiario'] ;

    if( $beneficiario == 'exists_benef' )
    {
        $cfa->id_beneficiario =  $_POST['id_beneficiario'][0] ;
    }   
    else
    {
        // inserimento nuovo beneficiario
        $cfa->ragione_sociale_beneficiario = filter_input(INPUT_POST,'ragione_sociale_beneficiario');
        $cfa->via_beneficiario = filter_input(INPUT_POST,'via_beneficiario');
        $cfa->citta_beneficiario = filter_input(INPUT_POST,'citta_beneficiario');
        $cfa->cap_beneficiario = filter_input(INPUT_POST,'cap_beneficiario');
        $cfa->codice_fiscale_beneficiario = filter_input(INPUT_POST,'codice_fiscale_beneficiario');
        $cfa->p_iva_beneficiario = filter_input(INPUT_POST,'p_iva_beneficiario');
  
        $cfa->table = 'beneficiario' ;
        $err_beneficiario = '' ;
        if( !$cfa->insert(['ragione_sociale_beneficiario','via_beneficiario','citta_beneficiario','cap_beneficiario','codice_fiscale_beneficiario','p_iva_beneficiario']) )
        {
            $err_beneficiario = '&err=errBeneficiario' ;
        }
        else
        {
            $cfa->codice_fiscale_beneficiario = filter_input(INPUT_POST,'codice_fiscale_beneficiario');
            $cfa->table = 'beneficiario' ;
            $stmt1 = $cfa->showAllWhere('id',['codice_fiscale_beneficiario']) ;
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            extract($row1) ;
            $cfa->id_beneficiario = $row1['id'] ;            
        }
    } 

    $cfa->massimale = filter_input(INPUT_POST,'massimale') ;
    $cfa->st = filter_input(INPUT_POST,'st') ;
    $cfa->et = filter_input(INPUT_POST,'et') ;
    $cfa->consulenza = filter_input(INPUT_POST,'consulenza') ;
    $cfa->incasso_data = filter_input(INPUT_POST,'incasso_data') ;
    $cfa->incasso_mod = filter_input(INPUT_POST,'incasso_mod') ;
    $cfa->pagato = filter_input(INPUT_POST,'pagato') ;
    $cfa->broker = filter_input(INPUT_POST,'broker') ;
    if(filter_input(INPUT_POST,'copia_direzione'))
    {
        $cfa->copia_direzione = 1 ;
    }
    else
    {
        $cfa->copia_direzione = 0 ;
    }

    // details

    $cfa->table = 'polizze' ;

    if($cfa->insert(['id_collaboratore','id_compagnia','numero','tipologia','id_contraente','id_beneficiario','descrizione','importo_gara','massimale','st','et','consulenza','incasso_data','incasso_mod','pagato','broker','copia_direzione']))
    {

        // CALENDAR
        $calendar->updateCalendar() ;

        header("Location: ../index.php?p=allPolizze&msg=polizzeAddSucc".$err_contraente.$err_beneficiario);
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allPolizze&err=polizzaAddFail");
        exit;
    }


}
else
{
    header("Location: ../index.php?p=allPolizza&err=noPost");
    exit;
}