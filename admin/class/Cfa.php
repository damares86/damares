<?php 

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Cfa extends Common{

    // public $table = 'polizze' ;
    
    // collaboratore
    public $nome ;
    public $cognome ;
    public $sede_legale ;
    public $sede_operativa ;
    public $telefono ;
    public $cellulare ;
    public $email ;
    public $pec ;
    public $codice_fiscale ;
    public $p_iva ;
    public $ritenuta_acconto ;
    public $iban ;
    public $banca ;
    public $provvigioni_dare ;
    public $provvigioni_avere ;
    public $consulenza_collab ;
    public $premio_collab ;

    // compagnie
    public $provv ;    
    public $provv_calcolate_su ;    

    // contraente
    public $nome_contraente ;
    public $cognome_contraente ;
    public $ragione_sociale_contraente ;
    public $via_contraente ;
    public $citta_contraente ;
    public $cap_contraente ;
    public $codice_fiscale_contraente ;
    public $p_iva_contraente ;
    public $telefono_contraente ;
    public $cellulare_contraente ;
    public $email_contraente ;

    // beneficiario
    public $ragione_sociale_beneficiario ;
    public $via_beneficiario ;
    public $citta_beneficiario ;
    public $cap_beneficiario ;
    public $codice_fiscale_beneficiario ;
    public $p_iva_beneficiario ;

    // polizze
    public $da_pagare ; 
    public $id_collaboratore ;
    public $id_compagnia ;
    public $netto ;
    public $diritti ;
    public $imponibile ;
    public $lordo ;
    public $spese ;
    public $imposte ;
    public $numero ;
    public $tipologia ;
    public $id_contraente ;
    public $id_beneficiario ;
    public $descrizione ;
    public $importo_gara ;
    public $massimale ;
    public $st ;
    public $et ;
    public $id_calendar_cat ;
    public $consulenza ;
    public $incasso_data ;
    public $incasso_mod ;
    public $pagato_da_compagnia ;
    public $compagnia_pagato ;
    public $pagato_da_collaboratore ;
    public $collaboratore_pagato ;
    public $copia_direzione ;


}
 
?>