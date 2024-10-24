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

    $post->table = 'post' ;
    $post->id = filter_input(INPUT_GET,"idToDel");

    if($post->delete('id')){
        header("Location: ../index.php?p=allPosts&msg=postDel");
        exit;
    }else{
        header("Location: ../index.php?p=allPosts&err=postNoDel");
        exit;
    }

}

$operation = filter_input(INPUT_POST,"operation") ;

// check if there's a customer to edit or add

if($operation=="edit"){

        $id = filter_input(INPUT_POST,"idToMod") ;        

        $url_tablePage = filter_input(INPUT_POST,'url_tablePage');
        $url_pageName = filter_input(INPUT_POST,'url_pageName');
    
        $url_data = "&tablePage=$url_tablePage&pageName=$url_pageName" ;
    
        if( filter_input(INPUT_POST,"gall") )
        {
            $post->gall = filter_input(INPUT_POST,"gall");
        }
        else
        {
            $post->gall = 'none' ;
        }
        $post->title = filter_input(INPUT_POST,"title");
        $post->author = filter_input(INPUT_POST,"author");
        $post->content = filter_input(INPUT_POST,"content");
        $post->created = date("Y-m-d");
        $category = $_POST['categories'] ;
        $post->category_id = implode(',',$category) ;
    
        $errImg = '' ;
    
        if($_FILES['myfile']['size'] > 0)
        {
            $file->filename = $_FILES['myfile']['name'] ;
            $filename = $_FILES['myfile']['name'] ;
    
            if($file->countFile()>0){
                
                header("Location: ../index.php?p=allFiles&err=fileExists$url_data");
                exit;
            }
            // set data for file uploading
            $file->inputFileName = $_FILES['myfile']['tmp_name'] ;
            $file->label = 'post -> '.$post->title ;
            $file->path = "../../uploads/" ;
            $file->origin = filter_input(INPUT_POST,"origin");
            
            $file->operation = "add" ;
            
            if(!$file->uploadFile()){
                $errImg = 'err=postImgErr';
                $post->main_img = 'default.png' ;
            }
            else
            {
                $post->main_img = $filename ;
            }
        }
        else
        {
            $post->main_img = filter_input(INPUT_POST,'old_main_img') ;
        }
    
        $post->table = 'post' ;
        $post->id = $id ;

        if($post->update(['main_img','gall','title','author','content','created','category_id'],'id')){
    
            //success
            header("Location: ../index.php?p=editPost$url_data&idToMod=$id&msg=postEditSucc$errImg");
            exit;
    
        }else{
    
            // fail
            header("Location: ../index.php?p=editPost$url_data&idToMod=$id&err=postEditFail$errImg");
            exit;
        }
    

}else if($operation == "add"){

    if( filter_input(INPUT_POST,"gall") )
    {
        $post->gall = filter_input(INPUT_POST,"gall");
    }
    else
    {
        $post->gall = 'none' ;
    }
    $post->title = filter_input(INPUT_POST,"title");
    $post->author = filter_input(INPUT_POST,"author");
    $post->content = filter_input(INPUT_POST,"content");
    $post->created = date("Y-m-d");
    $category = $_POST['categories'] ;
    $post->category_id = implode(',',$category) ;

    $errImg = '' ;

    if($_FILES['myfile']['size'] > 0)
    {
        $file->filename = $_FILES['myfile']['name'] ;
        $filename = $_FILES['myfile']['name'] ;

        if($file->countFile()>0){
            
            header("Location: ../index.php?p=allFiles&err=fileExists");
            exit;
        }
        // set data for file uploading
        $file->inputFileName = $_FILES['myfile']['tmp_name'] ;
        $file->label = 'post -> '.$post->title ;
        $file->path = "../../uploads/" ;
        $file->origin = filter_input(INPUT_POST,"origin");
        
        $file->operation = "add" ;
        
        if(!$file->uploadFile()){
            $errImg = 'err=postImgErr';
            $post->main_img = 'default.png' ;
        }
        else
        {
            $post->main_img = $filename ;
        }
    }
    else
    {
        $errImg = 'err=postImgEmpty';
    }
    
    $post->table = 'post' ;

    if($post->insert(['main_img','gall','title','author','content','created','category_id'])){

        //success
        header("Location: ../index.php?p=allPosts&msg=postSucc$errImg");
        exit;

    }else{

        // fail
        header("Location: ../index.php?p=allPosts&err=postFail$errImg");
        exit;
    }

}else{
    header("Location: ../index.php?p=allPosts&err=noPost");
    exit;
}