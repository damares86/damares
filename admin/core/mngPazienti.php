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

    $rsa->id = filter_input(INPUT_GET,"idToDel");
    $rsa->table = 'pazienti' ;

    if($rsa->delete('id'))
    {
        header("Location: ../index.php?p=allPazienti&msg=pazienteDel");
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allPazienti&err=pazienteNoDel");
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

        $rsa->table = 'pazienti' ;
        $rsa->nome = filter_input(INPUT_POST,'nome') ;
        $rsa->cognome = filter_input(INPUT_POST,'cognome') ;

        $counter = filter_input(INPUT_POST,'counter') ;

         if( $rsa->insert(['cognome','nome']) )
         {
            $rsa->table = 'pazienti' ;
            $rsa->nome = filter_input(INPUT_POST,'nome') ;
            $rsa->cognome = filter_input(INPUT_POST,'cognome') ;
            $stmt = $rsa->showAllWhere('id',['nome','cognome']) ;
            $row = $stmt->fetch(PDO::FETCH_ASSOC) ;
            extract($row);

           $id_paziente= $row['id'] ;
           $error = 0 ;

            for($i=1;$i<=$counter; $i++)
            {
                # query for farmaco
                $farmaco = 'f_'.$i ;
                $rsa->id_farmaco = filter_input(INPUT_POST,$farmaco) ;
                $rsa->table = 'farmaci' ;
                $stmt1 = $rsa->showAllWhere('id',['id']) ;
                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                extract($row1) ;
                $rsa->id_farmaci = $row1['id'] ;
                
                $rsa->table = 'farmaciPazienti' ;
                $rsa->id_pazienti = $id_paziente ;
                $cpr = 'cpr_'+$i ;
                $rsa->cpr = filter_input(INPUT_POST,$cpr) ;
                
                if(!$rsa->insert(['id_pazienti','id_farmaci','cpr']))
                {
                    $error++ ;
                }

            }

            if($error == 0)
            {
                header("Location: ../index.php?p=allPazienti&msg=pazientiAddSucc");
                exit;
            }
            else
            {
                header("Location: ../index.php?p=allPazienti&err=farmaciPazientiErr");
                exit;
            }

         }
         else
         {
            header("Location: ../index.php?p=allPazienti&err=pazientiAddFail");
            exit;
         }

}
else
{
    header("Location: ../index.php?p=allPazienti&err=noPost");
    exit;
}