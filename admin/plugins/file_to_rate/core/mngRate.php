<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

require '../vendor/autoload.php';		// If installed via composer
$debug = new \bdk\Debug(array(
	'collect' => true,
	'output' => true,
));

spl_autoload_register('autoloader');

function autoloader($class){
	include("../class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

include "../inc/class_initialize.php";

$setting->name="lang" ;
$stmt = $setting->showByName();
$lang = $stmt['value'];

foreach (glob("../locale/$lang/*.php") as $row){
    require "$row";
}


if(filter_input(INPUT_GET,"idToDel")){


    $idToDel = filter_input(INPUT_GET,"idToDel");
    $file->id = $idToDel;
    
    $filename = $file->showFilenameById();
    $file->id = $idToDel;

    if($file->delete('id')){

		if(($rate->deleteFromTable(['file_id'],'fileAccountRate')) && ($rate->deleteFromTable(['file_id'],'file_cat')) && ($rate->deleteFromTable(['file_id'],'rate'))){
			
			unlink("../uploads/ratefile/$filename");
	
			header("Location: ../index.php?p=allFilesRate&msg=fileDel");
			exit;

		}else{
			header("Location: ../index.php?p=allFilesRate&err=fileNoDbDel");
			exit;
		}
    }else{
        header("Location: ../index.php?p=allFilesRate&err=fileNoDel");
        exit;
    }

} else if(filter_input(INPUT_GET,"idCatToDel")){

    $idToDel = filter_input(INPUT_GET,"idCatToDel");
    $rate->id = $idToDel ;

    if($rate->deleteFromTable(['id'],'rate_cat')){
        header("Location:  ../index.php?p=allCatRate&msg=catRateDel");
        exit;
    }else{
        header("Location:  ../index.php?p=allCatRate&msg=catRateNoDel");
        exit;
    }

}

$operation = filter_input(INPUT_POST,"operation") ;

// check if there's an account to edit or add

if(filter_input(INPUT_POST,"idToMod")){

    $idToMod = filter_input(INPUT_POST,"idToMod");
    
    $file->id = $idToMod ;
    $file->label = filter_input(INPUT_POST,"label") ;

    if($_FILES['myfile']['size'] > 0){

        $file->filename = $_FILES['myfile']['name'] ;
        $filename = $_FILES['myfile']['name'] ;
        $file->inputFileName = $_FILES['myfile']['tmp_name'] ;
        $file->path = "../uploads/ratefile/" ;
        $file->origin = filter_input(INPUT_POST,"origin");

        $file->operation = filter_input(INPUT_POST,"operation") ;

        
        
        if($file->uploadFile()){
            $filename_orig = $_POST['filename_orig'];
            unlink("../uploads/ratefile/$filename_orig");
          
            header("Location: ../index.php?p=allFilesRate&msg=fileEditSucc");
            exit;
        }else{
            header("Location: ../index.php?p=allFilesRate&err=fileEdiFail");
            exit;
        }

    } else{

        if($file->update(['label'],'id')){
            header("Location: ../index.php?p=allFilesRate&msg=fileEditSucc");
            exit;
        }else{
            header("Location: ../index.php?p=allFilesRate&msg=fileEditFail");
            exit;
        }
        
    }

        

}else if($operation == "add"){ 

    if($_FILES['myfile']['size'] > 0){
        $file->filename = $_FILES['myfile']['name'] ;
        $filename = $_FILES['myfile']['name'] ;

        if($file->countFile()>0){
            
            header("Location: ../index.php?p=allFilesRate&err=fileExists");
            exit;
        }
        // set data for file uploading
        $file->inputFileName = $_FILES['myfile']['tmp_name'] ;
        $file->label = filter_input(INPUT_POST,"label") ;
        $file->path = "../uploads/ratefile/" ;
        $file->origin = filter_input(INPUT_POST,"origin");
        
        $file->operation = "add" ;
        
        if($file->uploadFile()){

			$rate->rate_cat_id = $_POST['category'] ;
			
			$file->filename = $_FILES['myfile']['name'] ;

			$stmt = $file->showAllWhere('id',['filename']);
			
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$rate->file_id = $row['id'];

			$rate->insertIntoTable(['file_id','rate_cat_id'],'fileCat');

            //success
            header("Location: ../index.php?p=allFilesRate&msg=fileSucc");
            exit;
        }else{
            header("Location: ../index.php?p=allFilesRate&err=fileFail");
            exit;
        }
    }else{
        header("Location: ../index.php?p=allFilesRate&err=fileErr");
        exit;
    }

}else if($operation == "addCat"){

	$rate->cat_name = filter_input(INPUT_POST,"cat_name");

    if($rate->catExists()){
        header("Location: ../index.php?p=addCatRate&err=rateCatExist");
        exit;
    }else{
        
        if($rate->insertIntoTable(['cat_name'],'rate_cat')){

            //success
            header("Location: ../index.php?p=allCatRate&msg=catRateSucc");
            exit;
        }else{
            //success
            header("Location: ../index.php?p=allCatRate&err=catRateFail");
            exit;  
        }
    }
}else if($operation == "editCat"){

	$rate->cat_name = filter_input(INPUT_POST,"cat_name");

	
	if($rate->update(['cat_name'],'id','rate_cat')){

		header("Location: ../index.php?p=allCatRate&msg=catRateEdit");
		exit;

	}else{
		header("Location: ../index.php?p=allCatRate&err=catRateNoEdit");
		exit;
	}

}


?>