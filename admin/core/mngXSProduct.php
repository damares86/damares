<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__."/coreConfig.php";

function rmdir_recursive($dir) {
    foreach(scandir($dir) as $file) {
        if ('.' === $file || '..' === $file) continue;
        if (is_dir($dir.'/'.$file)) rmdir_recursive($dir.'/'.$file);
        else unlink($dir.'/'.$file);
    }
    rmdir($dir);
}


if(filter_input(INPUT_GET,"idToDel"))
{

    $xsproduct->id = filter_input(INPUT_GET,"idToDel");
    $xsproduct->table = 'product' ;

    $stmt = $xsproduct->showAllWhere('id',['id']);
    $row = $stmt->fetch(PDO::FETCH_ASSOC) ;
    extract($row) ;

    $prod_name = $row['product_name'] ;

    $count_files = 0 ;

    $exclude = array('..', '.');
    foreach (scandir("../../product/$prod_name") as $row1)
    {
        $cat_dir = "../../product/$prod_name/$row1" ;

        if(!in_array($row1,$exclude))
        {
            $folder = scandir($cat_dir) ;

            foreach($folder as $row2)
            {
                if(!in_array($row2,$exclude))
                {
                        $count_files++;
                }
            }
        }
    }

    if($count_files>0)
    {
        header("Location: ../index.php?p=allXSProduct&err=prodFileExistsNoDel");
        exit;
    }
    else
    {        
        if($xsproduct->delete('id'))
        {

            $errDelFolder = '' ; 

            $dir="../../product/$prod_name" ;
            rmdir_recursive($dir);
            
            $old_folder = scandir("../../product/$prod_name");
            if($old_folder)
            {
                $errDelFolder = '&err=prodFolderNoDel' ;
            }

            header("Location: ../index.php?p=allXSProduct&msg=prodDel$errDelFolder");
            exit;
 
        }
        else
        {
            header("Location: ../index.php?p=allXSProduct&err=prodNoDel");
            exit;
        }
    }

}
else if(filter_input(INPUT_GET,"idToDelCat"))
{

    $xsproduct->id = filter_input(INPUT_GET,"idToDelCat");
    $xsproduct->table = 'product_files_cat' ;
    $stmt = $xsproduct->showAllWhere('id',['id']);
    $row2= $stmt->fetch(PDO::FETCH_ASSOC) ;
    extract($row2) ;

    $cat_name = $row2['cat_name'] ;
    $cat_name = strtolower($cat_name) ;
    
    $count_files = 0 ;

    $exclude = array('..', '.');
    foreach (scandir("../../product") as $row)
    {
        $cat_dir = "../../product/$row/$cat_name" ;
        
        if(!in_array($row,$exclude))
        {
            $folder = scandir($cat_dir) ;

            foreach($folder as $row1)
            {
                if(!in_array($row1,$exclude))
                {
                        $count_files++;
                }
            }
        }
        
    }

    if($count_files>0)
    {
        header("Location: ../index.php?p=allXSProductCat&err=prodCatExistsNoDel");
        exit; 
    }
    else
    {
        $xsproduct->id = filter_input(INPUT_GET,"idToDelCat");
        $xsproduct->table = 'product_files_cat' ;

        if($xsproduct->delete('id'))
        {
            $exclude = array('..', '.');
            foreach (scandir("../../product") as $row)
            {
                $cat_dir = "../../product/$row/$cat_name" ;

                if(!in_array($row,$exclude))
                {
                   rmdir($cat_dir);
                }
                
            }
            header("Location: ../index.php?p=allXSProductCat&msg=prodCatDel");
            exit;
        }
        else
        {
            header("Location: ../index.php?p=allXSProductCat&err=prodCatNoDel");
            exit;
        }
    }

}
else if(filter_input(INPUT_GET,"idFileToDel"))
{

    $xsproduct->id = filter_input(INPUT_GET,'idFileToDel') ;
    $xsproduct->table = 'product_files' ;

    $prod = filter_input(INPUT_GET,'prod') ;
    $prodId = filter_input(INPUT_GET,'prodId') ;
    $cat = filter_input(INPUT_GET,'cat') ;
    $file = filter_input(INPUT_GET,'fileName') ;

    if($xsproduct->delete('id'))
    {
        if(!unlink("../../product/$prod/$cat/$file"))
        {
            header("Location: ../index.php?p=editXSProduct&idToMod=$prodId&err=prodFileFolderNoDel");
            exit;
        }
        else
        {
            header("Location: ../index.php?p=editXSProduct&idToMod=$prodId&msg=prodFileDel");
            exit;
        }
    }
    else
    {
        header("Location: ../index.php?p=editXSProduct&idToMod=$prodId&err=prodFileNoDel");
        exit;
    }

}

$operation = filter_input(INPUT_POST,"operation") ;

// check if there's a customer to edit or add

if($operation == "addCat")
{

    $cat_name = filter_input(INPUT_POST,"name");
    $cat_name = str_replace(' ','_',$cat_name);
    $cat_name = strtolower($cat_name);
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
        $exclude = array('..', '.');
        foreach (scandir("../../product") as $row)
        {
            $cat_dir = "../../product/$row/$cat_name" ;
            echo $cat_dir.'<br>';
            if(!in_array($row, $exclude))
            {

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
else if($operation=='addFilesCat')
{

    $id =  filter_input(INPUT_POST,"productId");

    $files_cat_name = $_FILES['myfile']['name'] ;
    $file->filename = $files_cat_name ;
    $file->label = filter_input(INPUT_POST,"label");
    $filename = $_FILES['myfile']['name'] ;
    $file->inputFileName = $_FILES['myfile']['tmp_name'] ;
    $cat_name = filter_input(INPUT_POST,'filesCatName');
    $prod_name = filter_input(INPUT_POST,'productName');
    $prod_folder_name = strtolower($prod_name) ;
    $lc_cat_name = strtolower($cat_name) ;
    $file->path = "../../product/$prod_folder_name/$lc_cat_name/" ;
    $file->origin = filter_input(INPUT_POST,"origin");

    $file->operation = 'add' ;
    if($file->uploadFile())
    {
        
        $xsproduct->product_files_name = $files_cat_name ;
        $xsproduct->product_files_label = filter_input(INPUT_POST,"label");
        $xsproduct->product_files_cat_id = filter_input(INPUT_POST,"filesCatId"); 
        $xsproduct->product_id = filter_input(INPUT_POST,"productId");

        $cust_id = [] ;
        foreach($_POST['permissions'] as $item)
        {
            $cust_id[] = $item ;       
        }

        $cust_id_str = implode(',',$cust_id) ;
        $xsproduct->permissions = $cust_id_str ;
        
        $xsproduct->table = 'product_files' ;

        if($xsproduct->insert(['product_files_name','product_files_label','product_files_cat_id','product_id','permissions']))
        {
            header("Location: ../index.php?p=editXSProduct&idToMod=$id&msg=productFilesCatAdd");
            exit; 
        }
        else
        {
            header("Location: ../index.php?p=editXSProduct&idToMod=$id&err=productFilesCatFail");
            exit; 
        }

    }
    else
    {
        header("Location: ../index.php?p=editXSProduct&idToMod=$id&err=productFilesCatUploadFail");
        exit; 
    }

}
else if($operation=="editCat")
{

    $id = filter_input(INPUT_POST,'idToMod');
    $xsproduct->id = $id ;
    $cat_name = filter_input(INPUT_POST,'name');
    $xsproduct->cat_name = $cat_name;
    $old_cat_name = filter_input(INPUT_POST,'oldCatName');
    $xsproduct->old_cat_name = $old_cat_name ;
    $xsproduct->table = 'product_files_cat' ;

    if($xsproduct->update(['cat_name'],'id')){

        $error = 0 ;
        $exclude = array('..', '.');
        foreach (scandir("../../product") as $row)
        {
            $item=pathinfo($row);
            if(!in_array($item['basename'],$exclude)){
                $prod_folder = $item['basename'];
                echo "../../product/$prod_folder/$old_cat_name <br>";
                if(!rename("../../product/$prod_folder/$old_cat_name" ,"../../product/$prod_folder/$cat_name"))
                {
                    $error++;
                }
            }

        }
        
        $errRename = '' ;
        if($error>0)
        {
            $errRename = '&err=productCatFolderEditErr' ;
        }

        header("Location: ../index.php?p=editXSProductCat&idToMod=$id&msg=productCatEdit");
        exit; 
    
    }else{
    
        header("Location: ../index.php?p=editXSProductCat&idToMod=$id&err=productCatNoEdit");
        exit;
    
    }

}
else if($operation=="edit")
{
 
    $product_name = filter_input(INPUT_POST,"name");
    $xsproduct->product_name = $product_name ;
    $product_folder_name = strtolower($product_name);
    $old_product_name = filter_input(INPUT_POST,"oldProdName");
    $xsproduct->old_product_name = $old_product_name ;
    
    $product_id = filter_input(INPUT_POST,"idToMod");
    $xsproduct->id = $product_id ;
    $xsproduct->table = 'product' ;

    if($xsproduct->update(['product_name'],'id'))
    {

        $error = 0 ;
       
        if(!rename("../../product/$old_product_name" ,"../../product/$product_folder_name"))
        {
            $error++;
        }
       
        $errEdit = '' ;
        if($error>0)
        {
            $errEdit = "&err=productEditFolderFail" ;
        }
        //success
        header("Location: ../index.php?p=editXSProduct&idToMod=$product_id&msg=productEditSucc$errEdit");
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

        $product_folder_name = strtolower($product_name);
        
        // SPECIFIC PRODUCT FOLDER CREATION
        $target_directory = "$base_directory/$product_folder_name";

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