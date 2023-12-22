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

$operation = filter_input(INPUT_POST,"operation") ;


if(filter_input(INPUT_POST,"idToMod"))
{
    
    $cfa->id = filter_input(INPUT_POST,"idToMod");

    $cfa->nome = filter_input(INPUT_POST,'nome') ;
    $cfa->sede_legale = filter_input(INPUT_POST,'sede_legale') ;
    $cfa->netto = filter_input(INPUT_POST,'netto') ;
    $cfa->imponibile = filter_input(INPUT_POST,'imponibile') ;
    $cfa->lordo = filter_input(INPUT_POST,'lordo') ;
    $cfa->spese = filter_input(INPUT_POST,'spese') ;
    $cfa->provv = filter_input(INPUT_POST,'provv') ;

    // details

    $cfa->table = 'compagnie' ;

    if($cfa->update(['nome','sede_legale','netto','imponibile','lordo','spese','provv'],'id'))
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
    $cfa->netto = filter_input(INPUT_POST,'netto') ;
    $cfa->imponibile = filter_input(INPUT_POST,'imponibile') ;
    $cfa->lordo = filter_input(INPUT_POST,'lordo') ;
    $cfa->spese = filter_input(INPUT_POST,'spese') ;
    $cfa->provv = filter_input(INPUT_POST,'provv') ;

    // details

    $cfa->table = 'compagnie' ;

    if($cfa->insert(['nome','sede_legale','netto','imponibile','lordo','spese','provv']))
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