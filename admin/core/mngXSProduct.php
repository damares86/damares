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

    $cat_name = filter_input(INPUT_POST,"name");
    $xsproduct->cat_name = $cat_name ;
    $xsproduct->table = 'product_files_cat' ;

    // check if already exists 
    $stmt = $xsproduct->countItem('cat_name') ;

    if($stmt>0)
    {
        header("Location: ../index.php?p=allXSProductCat&err=prodCatExists");
        exit; 
    }

    if($xsproduct->insert(['cat_name']))
    {

        $error = 0 ;
        $$exclude = array('..', '.');
        foreach (scandir("../../product") as $row)
        {
            $cat_dir = "../../product/$row/$cat_name" ;
            
            if(!is_dir($cat_dir))
            {
                $oldmask = umask(0);
                if(!mkdir($cat_dir, 0777, true))
                {
                    $error++;
                }
                else
                {
                    umask($oldmask);
                }
            }
            else
            {
                $oldmask = umask(0);
                chmod($cat_dir, 0777);
                umask($oldmask);
            }
        }

        $errFolder = '' ;

        if($error>0)
        {
            $errFolder = "&err=productCatFolderErr" ;
        }
        //success
        header("Location: ../index.php?p=allXSProductCat&msg=productCatSucc$errFolder");
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
 
    $xsproduct->product_name = filter_input(INPUT_POST,"name");
    $product_id = filter_input(INPUT_POST,"idToMod");
    $xsproduct->id = $product_id ;
    $xsproduct->table = 'product' ;

    if($xsproduct->update(['product_name'],'id'))
    {

        //success
        header("Location: ../index.php?p=editXSProduct&idToMod=$product_id&msg=productEditSucc");
        exit;
        
    }
    else
    {
        
        // fail
        header("Location: ../index.php?p=editXSProduct&idToMod=$product_id&err=productEditFail");
        exit;
    }    

}
else if($operation == "add")
{
    
    $product_name = filter_input(INPUT_POST,"name");
    $xsproduct->product_name = $product_name ;
    $xsproduct->table = 'product' ;

    if($xsproduct->insert(['product_name']))
    {
        // BASE FOLDER 'PRODUCT' CREATION
        
        $error= 0 ;

        $base_directory = '../../product';
        if(!is_dir($base_directory))
        {
            $oldmask = umask(0);
            if(!mkdir($base_directory, 0777, true))
            {
                $error++;
            }
            else
            {
                umask($oldmask);
            }
            umask($oldmask);
        }
        else
        {
            $oldmask = umask(0);
            chmod($base_directory, 0777);
            umask($oldmask);
        }
        
        // SPECIFIC PRODUCT FOLDER CREATION
        $target_directory = "$base_directory/$product_name";

        if(!is_dir($target_directory))
        {
            $oldmask = umask(0);
            if(!mkdir($target_directory, 0777, true))
            {
                $error++;
            }
            else
            {
                umask($oldmask);
            }
            umask($oldmask);
        }
        else
        {
            $oldmask = umask(0);
            chmod($target_directory, 0777);
            umask($oldmask);
        }
        
        // CYCLE ALL THE PRODUCT FILES CAT AND CREATE THE FOLDERS
        $xsproduct->table = 'product_files_cat' ;
        $stmt = $xsproduct->showAll('id') ;

        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            $file_dir = $row['cat_name'] ;
            $file_dir = strtolower($file_dir) ;
            $file_directory = "$target_directory/$file_dir" ;

            if(!is_dir($file_directory))
            {
                $oldmask = umask(0);
                if(!mkdir($file_directory, 0777, true))
                {
                    $error++;
                }
                else
                {
                    umask($oldmask);
                }
                umask($oldmask);
            }
            else
            {
                $oldmask = umask(0);
                chmod($file_directory, 0777);
                umask($oldmask);
            }
        }
        
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