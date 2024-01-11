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

    $idToDel = filter_input(INPUT_GET,"idToDel");
    $post->id = $idToDel ;
    
    $post->table = 'post' ;
    $stmt = $post->showAll('id') ;
    
    $num = 0 ; 

    while( $row  = $stmt->fetch(PDO::FETCH_ASSOC) )
    {
        extract($row) ;

        $catArr = explode(',',$row['category_id']) ;
        if(in_array( $idToDel, $catArr ))
        {
            $num++ ;
        }
    }

    if( $num >0 )
    {
        header("Location: ../index.php?p=allPostsCat&err=postCatCount");
        exit;
    }
    else
    {
        
        $post->table = 'post_categories' ;
        
        if($post->delete('id'))
        {
            header("Location: ../index.php?p=allPostsCat&msg=postCatDel");
            exit;
        }
        else
        {
            header("Location: ../index.php?p=allPostsCat&err=postCatNoDel");
            exit;
        }
    }

}

$operation = filter_input(INPUT_POST,"operation") ;

// check if there's a customer to edit or add

if($operation=="edit")
{

        $id = filter_input(INPUT_POST,"idToMod") ;
        
        $post->id = $id ;
        $post->category_name = filter_input(INPUT_POST,'category_name') ;
        $post->table = 'post_categories' ;
      
        if($post->update(['category_name'],'id'))
        {    
            //success
            header("Location: ../index.php?p=editPostCat&idToMod=$id&msg=postCatSucc");
            exit;
    
        }
        else
        {
    
            // fail
            header("Location: ../index.php?p=editPostCat&idToMod=$id&&err=postCatFail");
            exit;
        }

}
else if($operation == "add")
{

    $post->category_name = filter_input(INPUT_POST,'category_name') ;
    $post->table = 'post_categories' ;
  
    if($post->insert(['category_name']))
    {

        //success
        header("Location: ../index.php?p=allPostsCat&msg=postCatSucc");
        exit;

    }else{

        // fail
        header("Location: ../index.php?p=allPostsCat&err=postCatFail");
        exit;
    }

}
else
{
    header("Location: ../index.php?p=allPostsCat&err=noPost");
    exit;
}