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

    // TODO

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
else if($operation == 'addPage')
{
    // $type = filter_input(INPUT_POST,'type') ;
    $prod_id = filter_input(INPUT_POST,'product_id') ;
    $title = filter_input(INPUT_POST,'title') ;
    $content = filter_input(INPUT_POST,'content') ;
    
    if(filter_input(INPUT_POST,'child_id'))
    {
        // è un paragrafo
        $child_id = filter_input(INPUT_POST,'child_id') ;
        
        $luna->title = $title ;
        $luna->content = $content ;
        $luna->last_editor = $_SESSION['account_id'] ;
        $luna->table = 'luna_paragraph' ;

        if($luna->insert(['title','content','last_editor']))
        {
            $luna->table = 'luna_paragraph' ;
            $luna->title = $title ;
            $stmt1 = $luna->showAllWhere('id',['title']) ;
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ;
            extract($row1) ;
            
            // get the paragraphs of the child page
            $luna->table = 'luna_child_paragraph' ;
            $luna->child_pages_id = $child_id ;

            if($luna->itemExists('child_pages_id'))
            {   

                $stmt = $luna->showAllWhere('id',['child_pages_id']) ;
                $row = $stmt->fetch(PDO::FETCH_ASSOC) ;
                extract($row) ;
                
                $arr = explode(',',$row['paragraph_id_arr']) ;
                $arr[] = $row1['id'] ;
                $str = implode(',',$arr) ;
                
                $luna->table = 'luna_child_paragraph' ;
                $luna->id = $row['id'] ;
                $luna->paragraph_id_arr = $str ;
                
                if($luna->update(['paragraph_id_arr'],'id'))
                {
                    header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentSucc");
                    exit ;
                }
                else
                {
                    header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentTreeFail");
                    exit ;
                }
            }
            else
            {
                $luna->table = 'luna_child_paragraph' ;
                $luna->child_pages_id = $child_id ;
                $luna->paragraph_id_arr = $row1['id'] ;
                if($luna->insert(['child_pages_id','paragraph_id_arr']))
                {
                    header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentSucc");
                    exit ;
                }
                else
                {
                    header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentTreeFail");
                    exit ;
                }
            }

        }
        else
        {
            header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentFail");
            exit ;
        }
       
    }
    else if(filter_input(INPUT_POST,'parent_id'))
    {
        // è un child
        $parent_id = filter_input(INPUT_POST,'parent_id') ;
        
        $luna->title = $title ;
        $luna->content = $content ;
        $luna->last_editor = $_SESSION['account_id'] ;
        $luna->table = 'luna_child' ;

        if($luna->insert(['title','content','last_editor']))
        {
            $luna->table = 'luna_child' ;
            $luna->title = $title ;
            $stmt1 = $luna->showAllWhere('id',['title']) ;
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ;
            extract($row1) ;
            
            // get the paragraphs of the child page
            $luna->table = 'luna_parent_child' ;
            $luna->parent_pages_id = $parent_id ;
            if($luna->itemExists('parent_pages_id'))
            {   
                $stmt = $luna->showAllWhere('id',['parent_pages_id']) ;
                $row = $stmt->fetch(PDO::FETCH_ASSOC) ;
                extract($row) ;
                
                $arr = explode(',',$row['child_pages_id_arr']) ;
                $arr[] = $row1['id'] ;
                $str = implode(',',$arr) ;
                
                $luna->table = 'luna_parent_child' ;
                $luna->id = $row['id'] ;
                $luna->child_pages_id_arr = $str ;

                if($luna->update(['child_pages_id_arr'],'id'))
                {
                    header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentSucc");
                    exit ;
                }
                else
                {
                    header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentTreeFail");
                    exit ;
                }
            }
            else
            {
                $luna->table = 'luna_parent_child' ;
                $luna->parent_pages_id = $parent_id ;
                $luna->child_pages_id_arr = $row1['id'] ;
                if($luna->insert(['parent_pages_id','child_pages_id_arr']))
                {
                    header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentSucc");
                    exit ;
                }
                else
                {
                    header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentTreeFail");
                    exit ;
                }
            }
        }
        else
        {
            header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentFail");
            exit ;
        }

    }
    else
    {
        // it's a parent
        $luna->title = $title ;
        $luna->content = $content ;
        $luna->luna_products_id = $prod_id  ;
        $luna->last_editor = $_SESSION['account_id'] ;
        $luna->table = 'luna_parent' ;

        if($luna->insert(['title','content','luna_products_id','last_editor']))
        {
            $luna->table = 'luna_parent' ;
            $luna->title = $title ;
            
            $stmt1 = $luna->showAllWhere('id',['title']) ;
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ;
            extract($row1) ;
            
            // get the parent order for the product
            $luna->table = 'luna_parent_order' ;
            $luna->luna_products_id = $prod_id ;

            if($luna->itemExists('luna_products_id'))
            {                
                // there are already parent pages for this product
                $stmt = $luna->showAllWhere('id',['luna_products_id']) ;
                $row = $stmt->fetch(PDO::FETCH_ASSOC) ;
                extract($row) ;
                
                // add the page to the other parent pages
                $arr = explode(',',$row['parent_pages_id_arr']) ;
                $arr[] = $row1['id'] ;
                $str = implode(',',$arr) ;
                
                $luna->table = 'luna_parent_order' ;
                $luna->id = $row['id'] ;
                $luna->parent_pages_id_arr = $str ;
                
                if($luna->update(['parent_pages_id_arr'],'id'))
                {
                    header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentSucc");
                    exit ;
                }
                else
                {
                    header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentTreeFail");
                    exit ;
                }
            }
            else
            {
                // it's the first parent page for the product
                $luna->table = 'luna_parent_order' ;
                $luna->luna_products_id = $prod_id ;
                $luna->parent_pages_id_arr = $row1['id'] ;
                if($luna->insert(['parent_pages_id_arr','luna_products_id']))
                {
                    header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentSucc");
                    exit ;
                }
                else
                {
                    header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentTreeFail");
                    exit ;
                }
            }
        }
        else
        {
            header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentFail");
            exit ;
        }

    }

}
else if($operation == 'editPage')
{

    $idToMod = filter_input(INPUT_POST,'idToMod') ;

    $prod_id = filter_input(INPUT_POST,'product_id') ;
    $title = filter_input(INPUT_POST,'title') ;
    $content = filter_input(INPUT_POST,'content') ;
    
    if(filter_input(INPUT_POST,'child_id'))
    {
        // è un paragrafo
        $luna->id = $idToMod ;               
        $luna->title = $title ;
        $luna->content = $content ;
        $luna->last_editor = $_SESSION['account_id'] ;
        $luna->table = 'luna_paragraph' ;

        if($luna->update(['title','content','last_editor'],'id'))
        {
            header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentEditSucc");
            exit ;
        }
        else
        {
            header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentEditTreeFail");
            exit ;
        }
       
    }
    else if(filter_input(INPUT_POST,'parent_id'))
    {
        // è un child
        $luna->id = $idToMod ;               
        $luna->title = $title ;
        $luna->content = $content ;
        $luna->last_editor = $_SESSION['account_id'] ;
        $luna->table = 'luna_child' ;

        if($luna->update(['title','content','last_editor'],'id'))
        {
            
            header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentEditSucc");
            exit ;
        }
        else
        {
            header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentEditTreeFail");
            exit ;
        }
    }
    else
    {
        // it's a parent
        $luna->id = $idToMod ;               
        $luna->title = $title ;
        $luna->content = $content ;
        $luna->luna_products_id = $prod_id  ;
        $luna->last_editor = $_SESSION['account_id'] ;
        $luna->table = 'luna_parent' ;

        if($luna->update(['title','content','luna_products_id','last_editor'],'id'))
        {

            header("Location:../index.php?p=allLunaPages&prod=$prod_id&msg=lunaContentEditSucc");
            exit ;
        }
        else
        {
            header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentEditTreeFail");
            exit ;
        }
    }            

}
else
{
    header("Location: ../index.php?err=noPost");
    exit;
}