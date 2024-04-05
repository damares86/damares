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
//////////////////////////////////////////

    // check if there are resources with this lang
    $gamresources->lang_id = filter_input(INPUT_GET,"idLangToDel");
    $gamresources->table = 'resources' ;
    $stmt = $gamresources->countItem('lang_id') ;

    if($stmt>0)
    {
        header("Location: ../index.php?p=allXSLangs&err=resLangExists");
        exit; 
    }
    
    // delete the lang
    $gamresources->id = filter_input(INPUT_GET,"idLangToDel");
    $gamresources->table = 'resource_lang' ;

    if($gamresources->delete('id')){
        header("Location: ../index.php?p=allXSLangs&msg=resLangDel");
        exit;
    }else{
        header("Location: ../index.php?p=allXSLangs&err=resLangNoDel");
        exit;
    }

}
else if(filter_input(INPUT_GET,"idTypeToDel"))
{
//////////////////////////////////////////

    // check if there are resources with this lang
    $gamresources->lang_id = filter_input(INPUT_GET,"idTypeToDel");
    $gamresources->table = 'resources' ;
    $stmt = $gamresources->countItem('type_id') ;

    if($stmt>0)
    {
        header("Location: ../index.php?p=allXSTypes&err=resTypeExists");
        exit; 
    }
    
    // delete the lang
    $gamresources->id = filter_input(INPUT_GET,"idTypeToDel");
    $gamresources->table = 'resource_type' ;

    if($gamresources->delete('id')){
        header("Location: ../index.php?p=allXSTypes&msg=resTypeDel");
        exit;
    }else{
        header("Location: ../index.php?p=allXSTypes&err=resTypeNoDel");
        exit;
    }

}
else if(filter_input(INPUT_GET,"idToDel"))
{
//////////////////////////////////////////

    $gamresources->id = filter_input(INPUT_GET,"idToDel");
    $gamresources->table = 'resources' ;

    if($gamresources->delete('id')){
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
    $gamresources->table = 'resource_type' ;
    $gamresources->id = $id ;
    $gamresources->type = filter_input(INPUT_POST,"name") ;

    if($gamresources->update(['type'],'id')){
        //success
        header("Location: ../index.php?p=editGamType&idToMod=$id&msg=resEditTypeSucc");
        exit;
    }else{
        // fail
        header("Location: ../index.php?p=editGamType&idToMod=$id&err=resEditTypeFail");
        exit;
    }

}
else if($operation=="editCat")
{

    $id = filter_input(INPUT_POST,"idToMod") ;
    $gamresources->table = 'resource_cat' ;
    $gamresources->id = $id ;
    $gamresources->cat = filter_input(INPUT_POST,"name") ;

    if($gamresources->update(['cat'],'id')){
        //success
        header("Location: ../index.php?p=editGamCat&idToMod=$id&msg=resEditCatSucc");
        exit;
    }else{
        // fail
        header("Location: ../index.php?p=editGamCat&idToMod=$id&err=resEditCatFail");
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
    
        $gamresources->table = 'resources' ;
        $gamresources->id = $id ;
        $gamresources->resource_name = $resource_name ;
        $gamresources->title = filter_input(INPUT_POST,"title");
        $gamresources->description = filter_input(INPUT_POST,"content");
        $gamresources->cat_id = filter_input(INPUT_POST,"cat_id");
        $gamresources->type_id = filter_input(INPUT_POST,"type_id");
        $gamresources->resource_date = date("Y-m-d");

        if($gamresources->update(['resource_name','title','description','cat_id','type_id','resource_date'],'id'))
        {
            header("Location: ../index.php?p=editGamResource&idToMod=$id&msg=resEditSucc");
            exit;
        }
        else
        {
            header("Location: ../index.php?p=editGamResource&idToMod=$id&err=resEditFail");
            exit;
        }
                

}
else if($operation == "addType")
{
    
    $gamresources->type = filter_input(INPUT_POST,"name");
    $gamresources->table = 'resource_type';

    if($gamresources->insert(['type'])){
        //success
        header("Location: ../index.php?p=allGamTypes&msg=resTypeSucc");
        exit;
    }else{
        // fail
        header("Location: ../index.php?p=allGamTypes&err=resTypeFail");
        exit;
    }

}
else if($operation == "addCat")
{

    $gamresources->cat = filter_input(INPUT_POST,"name");
    $gamresources->table = 'resource_cat';

    if($gamresources->insert(['cat'])){
        //success
        header("Location: ../index.php?p=allGamCats&msg=resCatSucc");
        exit;
    }else{
        // fail
        header("Location: ../index.php?p=allGamCats&err=resCatFail");
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

            $gamresources->table = 'resources' ;
            $gamresources->resource_name = $resource_name ;
            $gamresources->title = filter_input(INPUT_POST,"title");
            $gamresources->description = filter_input(INPUT_POST,"content");
            $gamresources->cat_id = filter_input(INPUT_POST,"cat_id");
            $gamresources->type_id = filter_input(INPUT_POST,"type_id");
            $gamresources->resource_date = date("Y-m-d");

            if($gamresources->insert(['resource_name','title','description','cat_id','type_id','resource_date']))
            {
                header("Location: ../index.php?p=allGamResources&msg=resSucc");
                exit;
            }
            else
            {
                header("Location: ../index.php?p=allGamResources&err=resFail");
                exit;
            }
            
        }
        else
        {
            header("Location: ../index.php?p=allGamResources&err=fileResFail");
            exit;        
        }

    }else{
        header("Location: ../index.php?p=allGamResources&err=fileResEmpty");
        exit;        
    }
}
else
{
    header("Location: ../index.php?p=allCustomers&err=noPost");
    exit;
}