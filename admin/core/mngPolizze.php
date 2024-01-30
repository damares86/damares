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


$operation = filter_input(INPUT_POST,"operation") ;


if(filter_input(INPUT_POST,"idToMod"))
{
    $idToMod = filter_input(INPUT_POST,"idToMod");
    $cfa->id = $idToMod ;

    $cfa->id_collaboratore = $_POST['id_collaboratore'][0] ;
    $cfa->id_compagnia = $_POST['id_compagnia'][0] ;        
    $cfa->imponibile = filter_input(INPUT_POST, 'imponibile') ;
    $cfa->imposte = filter_input(INPUT_POST, 'imposte') ;
    $lordo = filter_input(INPUT_POST, 'lordo') ;
    $cfa->lordo = $lordo ;

    if( filter_input(INPUT_POST, 'netto') )
    {
        $cfa->netto = filter_input(INPUT_POST, 'netto') ;
    }
    else
    {
        $cfa->netto = 0 ;

    }

    if( filter_input(INPUT_POST, 'diritti') )
    {
        $cfa->diritti = filter_input(INPUT_POST, 'diritti') ;
    }
    else
    {
        $cfa->diritti = 0 ;

    }

    if( filter_input(INPUT_POST, 'spese') )
    {
        $cfa->spese = filter_input(INPUT_POST, 'spese') ;
    }
    else
    {
        $cfa->spese = 0 ;

    }

    $cfa->numero = filter_input(INPUT_POST, 'numero') ;
    $cfa->tipologia = filter_input(INPUT_POST, 'tipologia') ;
    $cfa->descrizione = filter_input(INPUT_POST, 'descrizione') ;

    if( filter_input(INPUT_POST, 'importo_gara') )
    {
        $cfa->importo_gara = filter_input(INPUT_POST, 'importo_gara') ;
    }
    else
    {
        $cfa->importo_gara = 0 ;

    }
    
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
    $consulenza = filter_input(INPUT_POST,'consulenza') ;
    $cfa->consulenza = $consulenza ;
    $cfa->incasso_data = filter_input(INPUT_POST,'incasso_data') ;
    $cfa->incasso_mod = filter_input(INPUT_POST,'incasso_mod') ;

    $pagato_collab = 0 ;
    
    if(filter_input(INPUT_POST,'pagato_da_collaboratore'))
    {
        $pagato_collab = filter_input(INPUT_POST,'pagato_da_collaboratore') ;
        $cfa->pagato_da_collaboratore = $pagato_collab ;
    }
    else
    {
        $cfa->pagato_da_collaboratore = 0 ;
    }
  
    $old_collaboratore_pagato = filter_input(INPUT_POST,"old_collaboratore_pagato");
    if(filter_input(INPUT_POST,'collaboratore_pagato'))
    {
        $cfa->collaboratore_pagato = 1 ;
    }
    else
    {
        $cfa->collaboratore_pagato = 0 ;
    }

    $pagato_comp = 0 ;

    if(filter_input(INPUT_POST,'pagato_da_compagnia'))
    {
        $pagato_comp = filter_input(INPUT_POST,'pagato_da_compagnia') ;
        $cfa->pagato_da_compagnia = $pagato_comp ;
    }
    else
    {
        $cfa->pagato_da_compagnia = 0 ;
    }
    $old_compagnia_pagato = filter_input(INPUT_POST,"old_compagnia_pagato");

    if(filter_input(INPUT_POST,'compagnia_pagato'))
    {
        $cfa->compagnia_pagato = 1 ;
    }
    else
    {
        $cfa->compagnia_pagato = 0 ;
    }


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

    if($cfa->update([        
        'id_collaboratore',
        'id_compagnia',
        'netto',
        'diritti',
        'imponibile',
        'lordo',
        'spese',
        'imposte',
        'numero',
        'tipologia',
        'id_contraente',
        'id_beneficiario',
        'descrizione',
        'importo_gara',
        'massimale',
        'st',
        'et',
        'consulenza',
        'incasso_data',
        'incasso_mod',
        'pagato_da_collaboratore',
        'collaboratore_pagato',
        'pagato_da_compagnia',
        'compagnia_pagato',
        'copia_direzione'
        ],'id'))
    {

        // CALENDAR
        $calendar->updateCalendar() ;

        // $cfa->id = $_POST['id_compagnia'][0] ; 
        // $cfa->table = 'compagnie' ;
        // $stmt1 = $cfa->showAllWhere('id',['id']) ;
        // $row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ;
        // extract($row1) ;

        $da_pagare_compagnia = $lordo - $pagato_comp ;
        
        $cfa->id_compagnia = $_POST['id_compagnia'][0] ;
        $cfa->table = 'pag_compagnia' ;
        $stmt1 = $cfa->showAllWhere('id',['id_compagnia']);
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        extract($row1) ;
        $pag_compagnia = $row1['da_pagare'] ;
        $pag_mod = '' ;


        if($cfa->compagnia_pagato == 1 && $old_compagnia_pagato!=1)
        {
            $pag_mod  = $pag_compagnia - $da_pagare_compagnia ;
        }
        else if($cfa->compagnia_pagato == 0 && $old_compagnia_pagato!=0)
        {
            $pag_mod  = $pag_compagnia + $da_pagare_compagnia ;            
        }
        
        $err_pag_compagnia = '' ;
        if($pag_mod)
        {
            $cfa->da_pagare = $pag_mod ;
            $cfa->id_compagnia = $_POST['id_compagnia'][0] ;
            $cfa->table = 'pag_compagnia' ;
            if(!$cfa->update(['da_pagare'],'id_compagnia'))
            {
                $err_pag_compagnia = '&err=noPagComp';
            }
        }

        $da_pagare_collaboratore = $lordo + $consulenza - $pagato_collab ;
        
        $cfa->id_collaboratore = $_POST['id_collaboratore'][0] ;
        $cfa->table = 'pag_collaboratore' ;
        $stmt3 = $cfa->showAllWhere('id',['id_collaboratore']);
        $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
        extract($row3) ;
        $pag_collaboratore = $row3['da_pagare'] ;
        $pag_mod = '' ;

        if($cfa->collaboratore_pagato == 1 && $old_collaboratore_pagato!=1)
        {
            $pag_mod = $pag_collaboratore - $da_pagare_collaboratore ;
        }
        else if($cfa->collaboratore_pagato == 0 && $old_collaboratore_pagato!=0)
        {
            $pag_mod = $pag_collaboratore + $da_pagare_collaboratore ;            
        }
        
        $err_pag_collaboratore = '' ;
        if($pag_mod)
        {
            $cfa->da_pagare = $pag_mod ;
            $cfa->id_collaboratore = $_POST['id_collaboratore'][0] ;
            $cfa->table = 'pag_collaboratore' ;
            if(!$cfa->update(['da_pagare'],'id_collaboratore'))
            {
                $err_pag_collaboratore = '&err=noPagCollab';
            }
        }
    
        header("Location: ../index.php?p=editPolizza&idToMod=$idToMod&msg=polizzeEdit".$err_contraente.$err_beneficiario.$err_pag_compagnia.$err_pag_collaboratore);
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
    $cfa->imponibile = filter_input(INPUT_POST, 'imponibile') ;
    $cfa->imposte = filter_input(INPUT_POST, 'imposte') ;
    $lordo = filter_input(INPUT_POST, 'lordo') ;
    $cfa->lordo = $lordo ;

    if( filter_input(INPUT_POST, 'netto') )
    {
        $cfa->netto = filter_input(INPUT_POST, 'netto') ;
    }
    else
    {
        $cfa->netto = 0 ;

    }

    if( filter_input(INPUT_POST, 'diritti') )
    {
        $cfa->diritti = filter_input(INPUT_POST, 'diritti') ;
    }
    else
    {
        $cfa->diritti = 0 ;

    }

    if( filter_input(INPUT_POST, 'spese') )
    {
        $cfa->spese = filter_input(INPUT_POST, 'spese') ;
    }
    else
    {
        $cfa->spese = 0 ;

    }


    $cfa->numero = filter_input(INPUT_POST, 'numero') ;
    $cfa->tipologia = filter_input(INPUT_POST, 'tipologia') ;
    $cfa->descrizione = filter_input(INPUT_POST, 'descrizione') ;

    if( filter_input(INPUT_POST, 'importo_gara') )
    {
        $cfa->importo_gara = filter_input(INPUT_POST, 'importo_gara') ;
    }
    else
    {
        $cfa->importo_gara = 0 ;

    }
    
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
    $consulenza = filter_input(INPUT_POST,'consulenza') ;
    $cfa->consulenza = $consulenza ;
    $cfa->incasso_data = filter_input(INPUT_POST,'incasso_data') ;
    $cfa->incasso_mod = filter_input(INPUT_POST,'incasso_mod') ;

    if(filter_input(INPUT_POST,'pagato_da_collaboratore'))
    {
        $cfa->pagato_da_collaboratore = filter_input(INPUT_POST,'pagato_da_collaboratore') ;
    }
    else
    {
        $cfa->pagato_da_collaboratore = 0 ;
    }
  
    if(filter_input(INPUT_POST,'collaboratore_pagato'))
    {
        $cfa->collaboratore_pagato = 1 ;
    }
    else
    {
        $cfa->collaboratore_pagato = 0 ;
    }

    if(filter_input(INPUT_POST,'pagato_da_compagnia'))
    {
        $cfa->pagato_da_compagnia = filter_input(INPUT_POST,'pagato_da_compagnia') ;
    }
    else
    {
        $cfa->pagato_da_compagnia = 0 ;
    }

    if(filter_input(INPUT_POST,'compagnia_pagato'))
    {
        $cfa->compagnia_pagato = 1 ;
    }
    else
    {
        $cfa->compagnia_pagato = 0 ;
    }


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

    if($cfa->insert([
        'id_collaboratore',
        'id_compagnia',
        'netto',
        'diritti',
        'imponibile',
        'lordo',
        'spese',
        'imposte',
        'numero',
        'tipologia',
        'id_contraente',
        'id_beneficiario',
        'descrizione',
        'importo_gara',
        'massimale',
        'st',
        'et',
        'consulenza',
        'incasso_data',
        'incasso_mod',
        'pagato_da_collaboratore',
        'collaboratore_pagato',
        'pagato_da_compagnia',
        'compagnia_pagato',
        'copia_direzione'
        ]))
    {

        // CALENDAR
        $calendar->updateCalendar() ;

        $da_pagare_compagnia = $lordo - $pagato_comp ;
        
        $cfa->id_compagnia = $_POST['id_compagnia'][0] ;
        $cfa->table = 'pag_compagnia' ;
        $stmt1 = $cfa->showAllWhere('id',['id_compagnia']);
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        extract($row1) ;
        $pag_compagnia = $row1['da_pagare'] ;

        if($cfa->compagnia_pagato == 1)
        {
            $cfa->da_pagare = $pag_compagnia - $da_pagare_compagnia ;
        }
        else
        {
            $cfa->da_pagare = $pag_compagnia + $da_pagare_compagnia ;            
        }

        $cfa->id_compagnia = $_POST['id_compagnia'][0] ;
        $cfa->table = 'pag_compagnia' ;
        $err_pag_compagnia = '' ;
        if(!$cfa->update(['da_pagare'],'id_compagnia'))
        {
            $err_pag_compagnia = '&err=noPagComp';
        }
    

        $da_pagare_collaboratore = $lordo + $consulenza - $pagato_collab ;
        
        $cfa->id_collaboratore = $_POST['id_collaboratore'][0] ;
        $cfa->table = 'pag_collaboratore' ;
        $stmt3 = $cfa->showAllWhere('id',['id_collaboratore']);
        $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
        extract($row3) ;
        $pag_collaboratore = $row3['da_pagare'] ;

        if($cfa->collaboratore_pagato == 1)
        {
            $cfa->da_pagare = $pag_collaboratore - $da_pagare_collaboratore ;
        }
        else
        {
            $cfa->da_pagare = $pag_collaboratore + $da_pagare_collaboratore ;            
        }
        
        $cfa->id_collaboratore = $_POST['id_collaboratore'][0] ;
        $cfa->table = 'pag_collaboratore' ;
        $err_pag_collaboratore = '' ;
        if(!$cfa->update(['da_pagare'],'id_collaboratore'))
        {
            $err_pag_collaboratore = '&err=noPagCollab';
        }

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