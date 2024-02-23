<?php 

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Rsa extends Common{

    # farmaci
    public $principio ;
    public $cpr_box ;
    public $magazzino ;

    # pazienti
    public $cognome ;
    public $nome ;

    # pazientiFarmaci
    public $id_pazienti ;
    public $id_farmaci ;
    public $cpr ;

    public function is_leap_year($year) {
        if ($year % 400 === 0) {
            return true;
        } elseif ($year % 100 === 0) {
            return false;
        } elseif ($year % 4 === 0) {
            return true;
        } else {
            return false;
        }
    }

}
 
?>