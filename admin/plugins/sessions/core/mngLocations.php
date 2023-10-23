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

$operation = filter_input(INPUT_POST,"operation");

foreach (glob("../locale/$lang/*.php") as $row){
    require "$row";
}


if(filter_input(INPUT_GET,"idToDel")){

	$locId = filter_input(INPUT_GET,"idToDel") ;

	$session->table = "sessions" ;
	$session->location_id=$locId ;

	$stmt = $session->itemExists('location_id');

	if(!$stmt){
		
		$session->table = "location" ;
		$session->id = $locId ;
		
		if($session->delete('id')){
			header("Location: ../index.php?p=allLocations&msg=locDelSucc");
			exit;
		}else{
			header("Location: ../index.php?p=allLocations&err=locNotDel");
			exit;
		}

	}else{
		header("Location: ../index.php?p=allLocations&err=locUsed");
		exit;
	}

}

if($operation == "add"){
	
	$session->table = "location";
	$session->location_name = filter_input(INPUT_POST,"name");

	if($session->insert(['location_name'])){

		header("Location: ../index.php?p=allLocations&msg=locSucc");
		exit;

	}else{

		header("Location: ../index.php?p=allLocations&err=locErr");
		exit;
	}

}else if($operation=="edit"){
	
	$session->table = "location" ;
	$locId =filter_input(INPUT_POST,'idToMod');
	$session->id= $locId ;
	$session->location_name = filter_input(INPUT_POST,"name");

	if($session->update(['location_name'],'id')){
		
		header("Location: ../index.php?p=allLocations&msg=locEditSucc");
		exit;

	}else{

		header("Location: ../index.php?p=editLocation&idToMod=$id&err=locEditErr");
		exit;

	}


}else{
	header("Location: ../index.php?msg=errPost");
	exit;
}
exit;

?>
