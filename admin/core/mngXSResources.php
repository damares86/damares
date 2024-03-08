<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__."/coreConfig.php";

if(filter_input(INPUT_GET,"idLangToDel")){

    // check if there are resources with this lang
    $xsresources->lang_id = filter_input(INPUT_GET,"idLangToDel");
    $xsresources->table = 'resources' ;
    $stmt = $xsresources->countItem('lang_id') ;

    if($stmt>0)
    {
        header("Location: ../index.php?p=allXSLangs&err=resLangExists");
        exit; 
    }
    
    // delete the lang
    $xsresources->id = filter_input(INPUT_GET,"idLangToDel");
    $xsresources->table = 'resource_lang' ;

    if($xsresources->delete('id')){
        header("Location: ../index.php?p=allXSLangs&msg=resLangDel");
        exit;
    }else{
        header("Location: ../index.php?p=allXSLangs&err=resLangNoDel");
        exit;
    }

}
else if(filter_input(INPUT_GET,"idTypeToDel")){

    // check if there are resources with this lang
    $xsresources->lang_id = filter_input(INPUT_GET,"idTypeToDel");
    $xsresources->table = 'resources' ;
    $stmt = $xsresources->countItem('type_id') ;

    if($stmt>0)
    {
        header("Location: ../index.php?p=allXSTypes&err=resTypeExists");
        exit; 
    }
    
    // delete the lang
    $xsresources->id = filter_input(INPUT_GET,"idTypeToDel");
    $xsresources->table = 'resource_type' ;

    if($xsresources->delete('id')){
        header("Location: ../index.php?p=allXSTypes&msg=resTypeDel");
        exit;
    }else{
        header("Location: ../index.php?p=allXSTypes&err=resTypeNoDel");
        exit;
    }

}


$operation = filter_input(INPUT_POST,"operation") ;

// check if there's a customer to edit or add

if($operation=="editType")
{

    $id = filter_input(INPUT_POST,"idToMod") ;
    $xsresources->table = 'resource_type' ;
    $xsresources->id = $id ;
    $xsresources->resource_type = filter_input(INPUT_POST,"name") ;

    if($xsresources->update(['resource_type'],'id')){
        //success
        header("Location: ../index.php?p=editXSType&idToMod=$id&msg=resEditTypeSucc");
        exit;
    }else{
        // fail
        header("Location: ../index.php?p=editXSType&idToMod=$id&msg=resEditTypeFail");
        exit;
    }

}
else if($operation=="editLang")
{

    $id = filter_input(INPUT_POST,"idToMod") ;
    $xsresources->table = 'resource_lang' ;
    $xsresources->id = $id ;
    $xsresources->resource_lang = filter_input(INPUT_POST,"name") ;

    if($xsresources->update(['resource_lang'],'id')){
        //success
        header("Location: ../index.php?p=editXSLang&idToMod=$id&msg=resEditLangSucc");
        exit;
    }else{
        // fail
        header("Location: ../index.php?p=editXSLang&idToMod=$id&msg=resEditLangFail");
        exit;
    }

}
else if($operation=="edit")
{

        $id = filter_input(INPUT_POST,"idToMod") ;
        
        $customer->id = $id ;
        $stmt = $customer->showAllWhere('id',['id']);
               
        $customer->name = filter_input(INPUT_POST,"name") ;
        $customer->surname = filter_input(INPUT_POST,"surname") ;

        require "customersDetails.php";

        $details_arr = [] ;
        $details_opt_arr = [] ;

        foreach($customers_details as $item){
            $details_arr[] = array("$item" => "".$_POST[$item]."");
        }

        if($details_arr){
            $details_str = serialize($details_arr);
            $customer->details = $details_str;
        }

        foreach($customers_details_opt as $item){
            $details_opt_arr[] = array("$item" => "".$_POST[$item]."");
        }

        if($details_opt_arr){
            $details_opt_str = serialize($details_opt_arr);
            $customer->details_opt = $details_opt_str ;
        }

        if($customer->update(['name','surname','details','details_opt'],'id')){

			header("Location: ../index.php?p=editCustomer&idToMod=$id&msg=customerEdit");
			exit; 
		
		}else{
        
			header("Location: ../index.php?p=editCustomer&idToMod=$id&err=customerNoEdit");
			exit;
		
        }

}
else if($operation == "addType")
{

    $xsresources->resource_type = filter_input(INPUT_POST,"name");
    $xsresources->table = 'resource_type';

    if($xsresources->insert(['resource_type'])){
        //success
        header("Location: ../index.php?p=allXSTypes&msg=resTypeSucc");
        exit;
    }else{
        // fail
        header("Location: ../index.php?p=allXSTypes&err=resTypeFail");
        exit;
    }

}
else if($operation == "addLang")
{

    $xsresources->resource_lang = filter_input(INPUT_POST,"name");
    $xsresources->table = 'resource_lang';

    if($xsresources->insert(['resource_lang'])){
        //success
        header("Location: ../index.php?p=allXSLangs&msg=resLangSucc");
        exit;
    }else{
        // fail
        header("Location: ../index.php?p=allXSLangs&err=resLangFail");
        exit;
    }

}
else
{
    header("Location: ../index.php?p=allCustomers&err=noPost");
    exit;
}