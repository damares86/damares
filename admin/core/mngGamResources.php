<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__."/coreConfig.php";

if(filter_input(INPUT_GET,"idCatToDel"))
{

    // check if there are resources with this cat
    $gamresources->cat_id = filter_input(INPUT_GET,"idCatToDel");
    $gamresources->table = 'resources' ;
    $stmt = $gamresources->countItem('cat_id') ;

    if($stmt>0)
    {
        header("Location: ../index.php?p=allGamCats&err=resCatExists");
        exit; 
    }
    
    // delete the cat
    $gamresources->id = filter_input(INPUT_GET,"idCatToDel");
    $gamresources->table = 'resource_cat' ;

    if($gamresources->delete('id')){
        header("Location: ../index.php?p=allGamCats&msg=resCatDel");
        exit;
    }else{
        header("Location: ../index.php?p=allGamCats&err=resCatNoDel");
        exit;
    }

}
else if(filter_input(INPUT_GET,"idTypeToDel"))
{

    // check if there are resources with this type
    $gamresources->type_id = filter_input(INPUT_GET,"idTypeToDel");
    $gamresources->table = 'resources' ;
    $stmt = $gamresources->countItem('type_id') ;

    if($stmt>0)
    {
        header("Location: ../index.php?p=allGamTypes&err=resTypeExists");
        exit; 
    }
    
    // delete the lang
    $gamresources->id = filter_input(INPUT_GET,"idTypeToDel");
    $gamresources->table = 'resource_type' ;

    if($gamresources->delete('id')){
        header("Location: ../index.php?p=allGamTypes&msg=resTypeDel");
        exit;
    }else{
        header("Location: ../index.php?p=allGamTypes&err=resTypeNoDel");
        exit;
    }

}
else if(filter_input(INPUT_GET,"idToDel"))
{

    $gamresources->table = 'resources' ;
    $gamresources->id = filter_input(INPUT_GET,"idToDel");
    $stmt = $gamresources->showAllWhere('id',['id']) ;
    $row = $stmt->fetch(PDO::FETCH_ASSOC) ;
    $filename = $row['resource_name'] ;
    
    $gamresources->table = 'resources' ;
    $gamresources->id = filter_input(INPUT_GET,"idToDel");

    if($gamresources->delete('id')){

        $errFile = '' ;

        if(!unlink('../uploads/'.$filename))
        {
            $errFile = '&err=fileNotDel' ;
        }

        header("Location: ../index.php?p=allGamResources&msg=resDel$errFile");
        exit;
    }else{
        header("Location: ../index.php?p=allGamResources&err=resNoDel");
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
        $errOldFile = '' ;
        
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
                header("Location: ../index.php?p=allGamResources&err=fileResFail");
                exit;        
            }
            else
            {
                if(!unlink('../uploads/'.filter_input(INPUT_POST,"oldFilename")))
                {
                    $errOldFile = '&err=oldFileDelFail' ;
                }
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
            header("Location: ../index.php?p=editGamResource&idToMod=$id&msg=resEditSucc$errOldFile");
            exit;
        }
        else
        {
            header("Location: ../index.php?p=editGamResource&idToMod=$id&err=resEditFail$errOldFile");
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
    header("Location: ../index.php?p=allGamResources&err=noPost");
    exit;
}