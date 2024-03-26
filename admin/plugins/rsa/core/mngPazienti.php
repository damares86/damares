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

    $idToDel = filter_input(INPUT_GET,"idToDel");

    // remove all pazientiFarmaci record
    $rsa->id_pazienti = $idToDel ;
    $rsa->table = 'pazientiFarmaci' ;
    $stmt = $rsa->showAllWhere('id',['id_pazienti']) ;

    $error = 0 ;
    while( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
    {
        extract($row);

        $rsa->table = 'pazientiFarmaci' ;
        $rsa->id = $row['id'] ;

        if(!$rsa->delete('id'))
        {
            $error++;
        }
        
    }
    
    if ($error==0 )
    {            
        $rsa->id = $idToDel;
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
    else
    {
        header("Location: ../index.php?p=allPazienti&err=pazienteFarmaciNoDel");
        exit; 
    }

}

$operation = filter_input(INPUT_POST,"operation") ;

if(filter_input(INPUT_POST,"idToMod"))
{

    if($operation == 'edit')
    {

        $rsa->table = 'pazienti' ;
        $id_paziente = filter_input(INPUT_POST,"idToMod") ;
        $rsa->id = $id_paziente ;
        $rsa->nome = filter_input(INPUT_POST,'nome') ;
        $rsa->cognome = filter_input(INPUT_POST,'cognome') ;

        if( $rsa->update(['cognome','nome'],'id') )
        {

            $counter = $_POST['counter'] ;
            $error = 0 ;
            
            for($i = 1 ; $i <= $counter; $i++)
            {
                
                $rsa->table = 'pazientiFarmaci' ;
                $rsa->id_pazienti = $id_paziente ;
                
                $rsa->id_farmaci = filter_input(INPUT_POST,'farmaco_'.$i.'');
                
                $stmt = $rsa->showAllWhere('id',['id_pazienti','id_farmaci']) ;
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                extract($row) ;
                
                $id_pazientiFarmaci = $row['id'] ;

                if(filter_input(INPUT_POST,'del_'.$i.''))
                {
                    $rsa->table = 'pazientiFarmaci' ;                    
                    $rsa->id = $id_pazientiFarmaci ;
                    
                    if(!$rsa->delete('id'))
                    {
                        $error++ ;
                    }
                }
                else
                {
                    $rsa->table = 'pazientiFarmaci' ;
                    $rsa->id = $id_pazientiFarmaci ;
                    $rsa->id_pazienti = $id_paziente ;
                    $rsa->id_farmaci = filter_input(INPUT_POST,'farmaco_'.$i.'');
                    $rsa->cpr = filter_input(INPUT_POST,'cpr_'.$i.'');
                    $rsa->magazzino = filter_input(INPUT_POST,'magazzino_'.$i.'') ;
                    
                    if(!$rsa->update(['id_pazienti','id_farmaci','cpr','magazzino'],'id'))
                    {
                        $error++;
                    }
                }
                
            }

            if($error == 0 )
            {
                header("Location: ../index.php?p=editPaziente&idToMod=$id_paziente&msg=pazientiEdit");
                exit;
            }
            else
            {
                header("Location: ../index.php?p=allPazienti&err=farmaciPazientiEditErr");
                exit;
            }

        }
        else
        {
            header("Location: ../index.php?p=allPazienti&err=pazientiNoEdit");
            exit;
        }

    }
    else if($operation == 'addFarmaco')
    {
        $rsa->table = 'pazientiFarmaci' ;
        $id_paziente = filter_input(INPUT_POST,"idToMod") ;
        $rsa->id_pazienti = $id_paziente ;
        $rsa->id_farmaci = filter_input(INPUT_POST,"farmaco") ;
        $rsa->cpr = filter_input(INPUT_POST,"cpr") ;
        $rsa->magazzino = filter_input(INPUT_POST,'magazzino') ;


        if($rsa->insert(['id_pazienti','id_farmaci','cpr','magazzino']))
        {
            header("Location: ../index.php?p=editPaziente&idToMod=$id_paziente&msg=pazientiFarmaciAddSucc");
            exit;
        }
        else
        {
            header("Location: ../index.php?p=editPaziente&idToMod=$id_paziente&err=pazientiFarmaciAddFail");
            exit;
        }
    }

}
else if($operation == "add")
{

        $rsa->table = 'pazienti' ;
        $rsa->nome = filter_input(INPUT_POST,'nome') ;
        $rsa->cognome = filter_input(INPUT_POST,'cognome') ;

         if( $rsa->insert(['cognome','nome']) )
         {
            $rsa->table = 'pazienti' ;
            $rsa->nome = filter_input(INPUT_POST,'nome') ;
            $rsa->cognome = filter_input(INPUT_POST,'cognome') ;
            $stmt = $rsa->showAllWhere('id',['nome','cognome']) ;
            $row = $stmt->fetch(PDO::FETCH_ASSOC) ;
            extract($row);
            $id_paziente = $row['id'] ;

            if(filter_input(INPUT_POST,'cpr'))
            {

                $rsa->table = 'pazientiFarmaci' ;
                $rsa->id_pazienti = $id_paziente ;
                $rsa->id_farmaci = filter_input(INPUT_POST,'farmaco') ;
                $rsa->magazzino = filter_input(INPUT_POST,'magazzino') ;
                $rsa->cpr = filter_input(INPUT_POST,'cpr') ;

                if($rsa->insert(['id_pazienti','id_farmaci','cpr','magazzino']))
                {
                    header("Location: ../index.php?p=editPaziente&idToMod=$id_paziente&msg=pazientiAddSucc");
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
                header("Location: ../index.php?p=editPaziente&idToMod=$id_paziente&msg=pazientiAddSucc");
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