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

    // compagnie
    public $netto ;
    public $imponibile ;
    public $lordo ;
    public $spese ;
    public $provv ;    

    // contraente
    public $ragione_sociale ;
    public $via ;
    public $citta ;
    public $cap ;

    // beneficiario
    // come sopra

    // polizze
    public $id_collaboratore ;
    public $id_compagnia ;
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
    public $pagato ;


}

?>