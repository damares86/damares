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
	
	$question->table = "questions" ;
	$question->id = filter_input(INPUT_GET,"idToDel");

	if($question->delete('id')){
		header("Location: ../index.php?p=allQuestions&msg=qDel");
		exit;
	}else{
		header("Location: ../index.php?p=allQuestions&err=qNotDel");
		exit;	
	}

}else if(filter_input(INPUT_GET,"idToApp")){

	$question->table = "questions" ;
	$question->id = filter_input(INPUT_GET,"idToApp");
	$question->approved = 1;

	if($question->update(['approved'],'id')){
		header("Location: ../index.php?p=allQuestions&msg=qApp");
		exit;
	}else{
		header("Location: ../index.php?p=allQuestions&err=qNotApp");
		exit;	
	}

}

if($operation == "add"){

	
	$page_origin=filter_input(INPUT_POST,"p");
	
	$question->question = filter_input(INPUT_POST,"question-form");
	$question->account_id = filter_input(INPUT_POST,"account_id");
	$session_id = filter_input(INPUT_POST,"session_id");
	$question->session_id = $session_id;
	
	$question->table = "questions" ;

	if($question->insert(['question','account_id','session_id'])){
		header("Location: ../../session-details.php?id=$session_id&p=$page_origin&msg=qSucc");
		exit;
	}else{
		header("Location: ../../session-details.php?id=$session_id&p=$page_origin&err=qErr");
		exit;
	}

	
}else{
	header("Location: ../index.php?msg=errPost");
	exit;
}
exit;

?>
