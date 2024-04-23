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

        if($stmt->insert(['title','content','last_editor']))
        {
            $luna->table = 'luna_paragraph' ;
            $luna->title = $title ;
            $stmt1 = $luna->showAllWhere(['title'],'id') ;
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ;
            extract($row1) ;
            
            // get the paragraphs of the child page
            $luna->table = 'luna_child_paragraph' ;
            $luna->child_pages_id = $child_id ;
            $stmt = $luna->showAllWhere(['child_pages_id'],'id') ;
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
            header("Location:../index.php?p=allLunaPages&prod=$prod_id&err=lunaContentFail");
            exit ;
        }
       
    }
    else if(filter_input(INPUT_POST,'parent_id'))
    {
        // è un child
        $parent_id = filter_input(INPUT_POST,'parent_id') ;






    }
    else
    {
        // è un parent
    }






}
else
{
    header("Location: ../index.php?err=noPost");
    exit;
}