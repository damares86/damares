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
    
    $rsa->id_farmaci = filter_input(INPUT_GET,"idToDel");
    $rsa->table = 'pazientiFarmaci' ;
    $stmt = $rsa->showAllWhere('id',['id_farmaci']) ;
    $count = $stmt->rowCount();
            
    if( $count > 0 )
    {
        header("Location: ../index.php?p=allFarmaci&err=farmaciPazientiExists");
        exit;
    }      

    $rsa->id = filter_input(INPUT_GET,"idToDel");
    $rsa->table = 'farmaci' ;
    
    if($rsa->delete('id'))
    {
        header("Location: ../index.php?p=allFarmaci&msg=farmaciDel");
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allFarmaci&err=farmaciNoDel");
        exit;
    }

}

$operation = filter_input(INPUT_POST,"operation") ;


if(filter_input(INPUT_POST,"idToMod"))
{
    
    $idToMod = filter_input(INPUT_POST,"idToMod");
    $rsa->id = $idToMod ;

    $rsa->principio = filter_input(INPUT_POST,'principio') ;
    $rsa->cpr_box = filter_input(INPUT_POST,'cpr_box') ;

    $rsa->table = 'farmaci' ;

    if( $rsa->update(['principio','cpr_box'],'id') )
    {
        header("Location: ../index.php?p=allFarmaci&msg=farmaciEdit");
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allFarmaci&err=farmaciNoEdit");
        exit;
    }

}
else if($operation == "add")
{
        $rsa->principio = filter_input(INPUT_POST,'principio') ;
        $rsa->cpr_box = filter_input(INPUT_POST,'cpr_box') ;

        $rsa->table = 'farmaci' ;

        if( $rsa->insert(['principio','cpr_box']) )
        {
            header("Location: ../index.php?p=allFarmaci&msg=farmaciAddSucc");
            exit;
        }
        else
        {
            header("Location: ../index.php?p=allFarmaci&err=farmaciAddFail");
            exit;
        }

}
else
{
    header("Location: ../index.php?p=allFarmaci&err=noPost");
    exit;
}