<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__."/coreConfig.php";

if(filter_input(INPUT_GET,"idLangToDel"))
{

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
else if(filter_input(INPUT_GET,"idTypeToDel"))
{

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
else if(filter_input(INPUT_GET,"idToDel"))
{

    $xsresources->id = filter_input(INPUT_GET,"idToDel");
    $xsresources->table = 'resources' ;

    if($xsresources->delete('id')){
        header("Location: ../index.php?p=allXSResources&msg=resDel");
        exit;
    }else{
        header("Location: ../index.php?p=allXSResources&err=resNoDel");
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
        header("Location: ../index.php?p=editXSType&idToMod=$id&err=resEditTypeFail");
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
        header("Location: ../index.php?p=editXSLang&idToMod=$id&err=resEditLangFail");
        exit;
    }

}
else if($operation=="edit")
{

        $id = filter_input(INPUT_POST,"idToMod") ;
        
        if($_FILES['myfile']['size'] > 0)
        {
            $resource_name = $_FILES['myfile']['name'] ;
            $file->filename = $resource_name ;
            $file->label = filter_input(INPUT_POST,"title");
            $filename = $_FILES['myfile']['name'] ;
            $file->inputFileName = $_FILES['myfile']['tmp_name'] ;
            $file->path = "../uploads/" ;
            $file->origin = filter_input(INPUT_POST,"origin");
            
            $file->operation = $operation ;
            
            // check sull'esistenza del file?
            
            if(!$file->uploadFile())
            {
                header("Location: ../index.php?p=allXSResources&err=fileResFail");
                exit;        
            }
        }
        else
        {
            $resource_name = filter_input(INPUT_POST,"oldFilename");
        }
    
        $xsresources->table = 'resources' ;
        $xsresources->id = $id ;
        $xsresources->resource_name = $resource_name ;
        $xsresources->title = filter_input(INPUT_POST,"title");
        $xsresources->description = filter_input(INPUT_POST,"content");
        $xsresources->product_id = filter_input(INPUT_POST,"product_id");
        $xsresources->lang_id = filter_input(INPUT_POST,"lang_id");
        $xsresources->type_id = filter_input(INPUT_POST,"type_id");
        $xsresources->resource_date = date("Y-m-d");

        if($xsresources->update(['resource_name','title','description','product_id','lang_id','type_id','resource_date'],'id'))
        {
            header("Location: ../index.php?p=allXSResources&msg=resEditSucc");
            exit;
        }
        else
        {
            header("Location: ../index.php?p=allXSResources&err=resEditFail");
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
else if($operation == "add")
{

    if($_FILES['myfile']['size'] > 0)
    {
        $resource_name = $_FILES['myfile']['name'] ;
        $file->filename = $resource_name ;
        $file->label = filter_input(INPUT_POST,"title");
        $filename = $_FILES['myfile']['name'] ;
        $file->inputFileName = $_FILES['myfile']['tmp_name'] ;
        $file->path = "../uploads/" ;
        $file->origin = filter_input(INPUT_POST,"origin");
        
        $file->operation = $operation ;
        
        // check sull'esistenza del file?
        
        if($file->uploadFile())
        {

            $xsresources->table = 'resources' ;
            $xsresources->resource_name = $resource_name ;
            $xsresources->title = filter_input(INPUT_POST,"title");
            $xsresources->description = filter_input(INPUT_POST,"content");
            $xsresources->product_id = filter_input(INPUT_POST,"product_id");
            $xsresources->lang_id = filter_input(INPUT_POST,"lang_id");
            $xsresources->type_id = filter_input(INPUT_POST,"type_id");
            $xsresources->resource_date = date("Y-m-d");

            if($xsresources->insert(['resource_name','title','description','product_id','lang_id','type_id','resource_date']))
            {
                header("Location: ../index.php?p=allXSResources&msg=resSucc");
                exit;
            }
            else
            {
                header("Location: ../index.php?p=allXSResources&err=resFail");
                exit;
            }
            
        }
        else
        {
            header("Location: ../index.php?p=allXSResources&err=fileResFail");
            exit;        
        }

    }else{
        header("Location: ../index.php?p=allXSResources&err=fileResEmpty");
        exit;        
    }
}
else
{
    header("Location: ../index.php?p=allCustomers&err=noPost");
    exit;
}