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

$plugin->pluginname = "rating_system" ;
$rating = false;
$cookie_rating="";
if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
    $rating = true ;
    if(isset($_COOKIE['damares-rate'])){
      $cookie_rating=json_decode($_COOKIE['damares-rate'],true);
    }
}

$operation = filter_input(INPUT_POST,"operation");

foreach (glob("../locale/$lang/*.php") as $row){
    require "$row";
}


if(filter_input(INPUT_GET,"idToDel")){

	$id = filter_input(INPUT_GET,"idToDel") ;

	$session->id=$id ;
	$session->table="sessions";

	if($session->delete('id')){
	
		header("Location: ../index.php?p=allSessions&msg=sessDelSucc");
		exit;

	}else{
		header("Location: ../index.php?p=allSessions&err=sessNotDel");
		exit;
	}


}

if($operation == "add"){

	$name = filter_input(INPUT_POST,"name");
	$date = filter_input(INPUT_POST,"date");
	$st = filter_input(INPUT_POST,"st");
	$et = filter_input(INPUT_POST,"et");
	$location = filter_input(INPUT_POST,'location');

	$people=[];

	$chair = $_POST['chair'];	
	if($chair){
		$chair_arr=[];		
		foreach($chair as $item){
			$chair_arr[] = $item ;
		}		
		// $chair_str = implode(",",$chair_arr);
		$people[]=["chair"=>$chair_arr];
	}
	
	$expert = $_POST['expert'];	
	if($expert){
		$expert_arr=[];		
		foreach($expert as $item){
			$expert_arr[] = $item ;
		}		
		// $expert_str = implode(",",$expert_arr);
		$people[]=["expert"=>$expert_arr];
	}
	
	$people_str = serialize($people);
	
	$session->sessions_name = $name ;
	$session->location_id = $location ;
	$session->date = $date ;
	$session->start_time = $st ;
	$session->end_time = $et ;
	$session->people_id = $people_str ;
	$session->relations_id = 0 ;
	$session->table = "sessions" ;
	
	if($session->insert(['sessions_name','location_id','date','start_time','end_time','people_id','relations_id'])){
	
		$session->table = "sessions" ;
		$session->sessions_name=$name;
		$stmt = $session->showAllWhere('id',['sessions_name']);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$newId = $row['id'];

		if($rating){
			require 'rateItems.php';
			if(in_array('sessions',$rateItems)){
				// get the rate cat id
				$rate->table="rate_cat";
				$rate->cat_name="sessions";
				$stmt2=$rate->showAllWhere('id',['cat_name']);
				$row2=$stmt2->fetch(PDO::FETCH_ASSOC);
				extract($row2);

				// insert item in item_rate table
				$rate->table="item_rate" ;
				$rate->rate_cat_id=$row2['id'];
				$rate->item_id = $newId;
				$rate->insert(['rate_cat_id','item_id']);

			}
		}
		header("Location: ../index.php?p=editSession&idToMod=$newId&msg=sessSucc");
		exit;
	}else{
		header("Location: ../index.php?p=allSessions&err=sessErr");
		exit;
	}

}else if($operation=="edit"){

	$idToMod = filter_input(INPUT_POST,"idToMod");
	$name = filter_input(INPUT_POST,"name");
	$date = filter_input(INPUT_POST,"date");
	$st = filter_input(INPUT_POST,"st");
	$et = filter_input(INPUT_POST,"et");
	$location = filter_input(INPUT_POST,'location');

	$people=[];

	$chair = $_POST['chair'];	
	if($chair){
		$chair_arr=[];		
		foreach($chair as $item){
			$chair_arr[] = $item ;
		}		
		// $chair_str = implode(",",$chair_arr);
		$people[]=["chair"=>$chair_arr];
	}

	$expert = $_POST['expert'];	
	if($expert){
		$expert_arr=[];		
		foreach($expert as $item){
			$expert_arr[] = $item ;
		}		
		// $expert_str = implode(",",$expert_arr);
		$people[]=["expert"=>$expert_arr];
	}
	
	$people_str = serialize($people);

	// get the old relations
	$relations_arr=[];
	foreach(array_keys($_POST) as $item){
		if(preg_match("/check/",$item)){
			$key_arr=explode("_",$item);
			$relations_arr[]=$key_arr[1];
		}
	}
	
	$relations=$_POST['relations'];
	
	foreach($relations as $item){
		if(!in_array($item,$relations_arr)){
			$relations_arr[] = $item ;
		}
	}
	
	$relations_str=implode(',',$relations_arr);
	
	$session->id = $idToMod;
	$session->sessions_name = $name ;
	$session->location_id = $location ;
	$session->date = $date ;
	$session->start_time = $st ;
	$session->end_time = $et ;
	$session->people_id = $people_str ;
	$session->relations_id = $relations_str ;
	$session->table = "sessions" ;
	
	if($session->update(['sessions_name','location_id','date','start_time','end_time','people_id','relations_id'],'id')){
		$session->table = "sessions" ;
		$session->sessions_name=$name;
		$stmt = $session->showAllWhere('id',['sessions_name']);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$newId = $row['id'];
		header("Location: ../index.php?p=editSession&idToMod=$newId&msg=sessEditSucc");
		exit;
	}else{
		header("Location: ../index.php?p=allSessions&err=sessEditErr");
		exit;
	}

}else if($operation=="editActive"){

	$id=filter_input(INPUT_POST,'idToMod');
	$active=filter_input(INPUT_POST,"activeSess");

	$session->id=$id;

	if($active){
		$session->active=1;
	}else{
		$session->active=0;
	}

	if($session->updateTable(['active'],'id','sessions')){
		header("Location: ../index.php?p=editSession&idToMod=$id&msg=activeSucc");
		exit;
	}else{
		header("Location: ../index.php?p=editSession&idToMod=$id&err=activeErr");
		exit;
	}

}else{
	header("Location: ../index.php?msg=errPost");
	exit;
}
exit;

?>
