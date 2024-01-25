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
    $cfa->table = 'compagnie' ;
    
    if($cfa->delete('id'))
    {
        header("Location: ../index.php?p=allCompagnie&msg=compagnieDel");
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allCompagnie&err=compagnieNoDel");
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
    
    $cfa->id = filter_input(INPUT_POST,"idToMod");

    $cfa->nome = filter_input(INPUT_POST,'nome') ;
    $cfa->sede_legale = filter_input(INPUT_POST,'sede_legale') ;
    $cfa->p_iva = filter_input(INPUT_POST,'p_iva') ;
    $cfa->provv = filter_input(INPUT_POST,'provv') ;
    $cfa->ritenuta_acconto = filter_input(INPUT_POST,'ritenuta_acconto') ;
    $cfa->provv_calcolate_su = filter_input(INPUT_POST,'provv_calcolate_su') ;

    // details

    $cfa->table = 'compagnie' ;

    if($cfa->update(['nome','sede_legale','p_iva','provv','ritenuta_acconto','provv_calcolate_su'],'id'))
    {
        header("Location: ../index.php?p=allCompagnie&msg=compagnieEdit");
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allCompagnie&err=compagnieNoEdit");
        exit;
    }


}
else if($operation == "add")
{

    $cfa->nome = filter_input(INPUT_POST,'nome') ;
    $cfa->sede_legale = filter_input(INPUT_POST,'sede_legale') ;
    $cfa->p_iva = filter_input(INPUT_POST,'p_iva') ;
    $cfa->provv = filter_input(INPUT_POST,'provv') ;
    $cfa->ritenuta_acconto = filter_input(INPUT_POST,'ritenuta_acconto') ;
    $cfa->provv_calcolate_su = filter_input(INPUT_POST,'provv_calcolate_su') ;

    // details

    $cfa->table = 'compagnie' ;

    if($cfa->insert(['nome','sede_legale','p_iva','provv','ritenuta_acconto','provv_calcolate_su']))
    {
        header("Location: ../index.php?p=allCompagnie&msg=compagnieAddSucc");
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allCompagnie&err=compagnieAddFail");
        exit;
    }

}
else
{
    header("Location: ../index.php?p=allCompagnie&err=noPost");
    exit;
}