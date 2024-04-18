<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__."/coreConfig.php";

// check if there's a customer to delete

if(filter_input(INPUT_GET,"idToDel")){

    $customer->id = filter_input(INPUT_GET,"idToDel");

    if($customer->delete('id')){
        header("Location: ../index.php?p=allCustomers&msg=customerDel");
        exit;
    }else{
        header("Location: ../index.php?p=allCustomers&err=customerNoDel");
        exit;
    }

}

$operation = filter_input(INPUT_POST,"operation") ;

// check if there's a customer to edit or add

if($operation == "editLunaProduct")
{
        $idToMod = filter_input(INPUT_POST,"idToMod") ;
        $luna->id = $idToMod ;
        $luna->name = filter_input(INPUT_POST,"name") ; 
        $luna->version = filter_input(INPUT_POST,"version") ; 
        $luna->table = 'luna_products' ;

        if($luna->update(['name','version'],'id'))
        {
            header("Location:../index.php?p=editLunaProduct&msg=lunaProdEditSucc&idToMod=$idToMod");
            exit ;
       }
       else
       {
            header("Location:../index.php?p=editLunaProduct&err=lunaProdEditFail&idToMod=$idToMod");
            exit ;
       }
    
        
     
}
else if($operation == "addLunaProduct")
{

   $luna->name = filter_input(INPUT_POST,'name') ;
   $luna->version = filter_input(INPUT_POST,'version') ;
   $luna->table = 'luna_products' ;

   if($luna->insert(['name','version']))
   {
        header('Location:../index.php?p=allLunaProducts&msg=lunaProdSucc');
        exit ;
   }
   else
   {
        header('Location:../index.php?p=allLunaProducts&err=lunaProdFail');
        exit ;
   }

}
else
{
    header("Location: ../index.php?p=allCustomers&err=noPost");
    exit;
}