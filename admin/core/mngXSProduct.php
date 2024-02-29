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

if(filter_input(INPUT_GET,"idToDel"))
{

    $xsproduct->id = filter_input(INPUT_GET,"idToDel");
    $xsproduct->table = 'product' ;

    if($xsproduct->delete('id'))
    {
        header("Location: ../index.php?p=allXSProduct&msg=prodDel");
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allXSProduct&err=prodNoDel");
        exit;
    }

}
else if(filter_input(INPUT_GET,"idToDelCat"))
{

    $xsproduct->id = filter_input(INPUT_GET,"idToDelCat");
    $xsproduct->table = 'product_files_cat' ;

    if($xsproduct->delete('id'))
    {
        header("Location: ../index.php?p=allXSProductCat&msg=prodCatDel");
        exit;
    }
    else
    {
        header("Location: ../index.php?p=allXSProductCat&err=prodCatNoDel");
        exit;
    }

}

$operation = filter_input(INPUT_POST,"operation") ;

// check if there's a customer to edit or add

if($operation == "addCat")
{

    $xsproduct->cat_name = filter_input(INPUT_POST,"name");
    $xsproduct->table = 'product_files_cat' ;

    if($xsproduct->insert(['cat_name']))
    {

        //success
        header("Location: ../index.php?p=allXSProductCat&msg=productCatSucc");
        exit;

    }
    else
    {

        // fail
        header("Location: ../index.php?p=allXSProductCat&err=productCatFail");
        exit;
    }    

}
else if($operation=="editCat")
{

    $id = filter_input(INPUT_POST,'idToMod');
    $xsproduct->id = $id ;
    $xsproduct->cat_name = filter_input(INPUT_POST,'name');
    $xsproduct->table = 'product_files_cat' ;

    if($xsproduct->update(['cat_name'],'id')){

        header("Location: ../index.php?p=editXSProductCat&idToMod=$id&msg=productCatEdit");
        exit; 
    
    }else{
    
        header("Location: ../index.php?p=editXSProductCat&idToMod=$id&err=productCatNoEdit");
        exit;
    
    }

}
else if($operation=="edit")
{



        if($customer->update(['name','surname','details','details_opt'],'id')){

			header("Location: ../index.php?p=editCustomer&idToMod=$id&msg=customerEdit");
			exit; 
		
		}else{
        
			header("Location: ../index.php?p=editCustomer&idToMod=$id&err=customerNoEdit");
			exit;
		
        }

}
else if($operation == "add")
{
    
    $xsproduct->product_name = filter_input(INPUT_POST,"name");
    $xsproduct->table = 'product' ;

    if($xsproduct->insert(['product_name']))
    {

        //success
        header("Location: ../index.php?p=allXSProduct&msg=productSucc");
        exit;

    }
    else
    {

        // fail
        header("Location: ../index.php?p=allXSProduct&err=productFail");
        exit;
    }    

}
else
{
    header("Location: ../index.php?p=allXSProduct&err=noPost");
    exit;
}