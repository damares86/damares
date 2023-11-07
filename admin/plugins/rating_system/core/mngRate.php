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


if(filter_input(INPUT_GET,"act")){
	
	$act=filter_input(INPUT_GET,"act");
	$rate->id = filter_input(INPUT_GET,"idToMod");
	$rate->table = "item_rate";

	if($act=="yes"){

		$rate->rate_active=1;
		if($rate->update(['rate_active'],'id')){
			header("Location: ../index.php?p=editRateItems&msg=rateItemActSucc");
			exit;
		}else{
			header("Location: ../index.php?p=editRateItems&err=rateItemActErr");
			exit;
		}

	}else if($act=="no"){

		$rate->rate_active=0;
		if($rate->update(['rate_active'],'id')){
			header("Location: ../index.php?p=editRateItems&msg=rateItemDeactSucc");
			exit;
		}else{
			header("Location: ../index.php?p=editRateItems&err=rateItemDeactErr");
			exit;
		}

	}

}

if($operation == "editActive"){

	$cat = $_POST['cat'];
	$error=0;
	
	$rate->table = "rate_cat";
	$stmt = $rate->showAll('id');

	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		
		extract($row);

		$rate->table = "rate_cat";
		$rate->rate_cat_id = $row['id'];
		
		$rate->cat_name = $row['cat_name'];
		$cat_name = $row['cat_name'];
		if($cat){
			if($row['active']==0){
				
				if(in_array($row['id'],$cat)){

					$active=1;
					$rate->active = 1 ;
					if($rate->update(['active'],'cat_name')){
						
						$stmt1 = $rate->showAllTable('id',''.$cat_name.'');
						foreach($stmt1 as $row1){
							$rate->item_id=$row1['id'];
							if(!$rate->insertIntoTable(['rate_cat_id','item_id'],'item_rate')){
								$error++;
							}
						}
					}else{
						$error++;
					}
				}
			}else if($row['active']==1){
				
				if(!in_array($row['id'],$cat)){

					$rate->active=0;
					if($rate->update(['active'],'cat_name')){
						if(!$rate->deleteFromTable('rate_cat_id','item_rate')){
							$error++;
						}
					}else{
						$error++;
					}					
				}
			}
		}else{
			$rate->active=0;
			if($rate->update(['active'],'cat_name')){
				
				if(!$rate->deleteFromTable('rate_cat_id','item_rate')){
					$error++;
				}
			}else{
				$error++;
			}
		}
	}

	if($error==0){
		header("Location: ../index.php?p=editRateCat&msg=rateActiveSucc");
		exit;
	}else{
		header("Location: ../index.php?p=editRateCat&err=rateActiveErr");
		exit;
	}

}else if($operation=="editRateSession"){
	
	$rate_session = filter_input(INPUT_POST,"idToMod");
	$rate_id=filter_input(INPUT_POST,"rate_item_id");
	$active=filter_input(INPUT_POST,"activeRate");
	$err="";

	$rate->id=$rate_id;

	if($active){
		$rate->rate_active=1;
	}else{
		$rate->rate_active=0;
	}

	if($rate->updateTable(['rate_active'],'id','item_rate')){
		
		
		$stmt = $rate->showAllTable('id','rate_cat');
		$rate_cat="";
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			if($row['cat_name']=="speakers"){
				$rate_cat=$row['id'];
				break;
			}
		}
		
		$relation->id = $rate_relation;
		$relation->table="relations";
		$stmt1 = $relation->showAllWhere('id',['id']);
		
		while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
			extract($row1);
			
			$speakers_str=$row1['speakers_id'];
			$speakers_arr=explode(",",$speakers_str); 


			$error=0;

			foreach($speakers_arr as $item){

				$rate->item_id=$item;
				$rate->rate_cat_id=$rate_cat;

				$rate->updateTableMultiple(['rate_active'],['rate_cat_id','item_id'],'item_rate');

				
				if(!$rate->updateTableMultiple(['rate_active'],['rate_cat_id','item_id'],'item_rate')){
					$error++;
				}

			}
		}

		if($error>0){
			$err="&err=speakersNotRate";
		}

		header("Location: ../index.php?p=editSession&idToMod=$rate_session&msg=activeRateSessSucc$err");
		exit;
	}else{
		header("Location: ../index.php?p=editSession&idToMod=$rate_sessio&err=activeRateSessErr");
		exit;
	}

}else if($operation=="rateFe"){
	
	$rate_cat = filter_input(INPUT_POST,'rate_cat');
	$origin = filter_input(INPUT_POST,'origin');
	$idOrigin_form = filter_input(INPUT_POST,'idOrigin');
	$idOrigin="";
	if($idOrigin_form){
		$idOrigin="&id=$idOrigin_form";
	}
	$page_form = filter_input(INPUT_POST,'p');
	if($page_form){
		$page="&p=$page_form";
	}

	$rate->cat_name = $rate_cat ;
	$rate->table = "rate_cat";
	
	$stmt = $rate->showAllWhere('id',['cat_name']);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	extract($row);
	
	$cat_id = $row['id'];
	$idToMod = filter_input(INPUT_POST,"idToMod");
	$rate->rate_cat_id = $cat_id ;
	$rate->item_id = $idToMod ;

	$rate->table = "item_rate";

	$stmt1 = $rate->showAllWhere('id',['rate_cat_id','item_id']);
	$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
	extract($row1);
	
	$item_rate_id=  $row1['id'];
	$rate->item_rate_id =$item_rate_id;
	$rate->table = "rate";
	$star_form = $_POST['star'] ;

	if($rate->itemExists('item_rate_id')){

		// update
		$stmt2 = $rate->showAllWhere('id',['item_rate_id']);
		$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
		extract($row2);

		$new_vote_sum = $row2['vote_sum'] + $star_form;
		$rate->vote_sum = $new_vote_sum ;
		$new_vote_number = $row2['vote_number'] + 1;
		$rate->vote_number = $new_vote_number ;
		
		$star_arr = unserialize($row2['star']);
		$new_star_arr=[];

		

		for($i=0;$i<5;$i++){
			$array_value=array_values($star_arr[$i]);
			$value = intval($array_value[0]);
			$idx=$i;
			if($star_form==$i){
				$value = $value+1;
			}
			$new_idx = $idx+1;
			$new_star_arr[]=array($new_idx=>$value);
		}
		
		$rate->star=serialize($new_star_arr);

		$vote_star = $new_vote_sum/$new_vote_number;

		$rate->star_vote = $vote_star ;

		$rate->percent = ($vote_star*100)/5;


		if($rate->update(['vote_sum','vote_number','star','star_vote','percent'],'item_rate_id')){

			// print_r($_COOKIE);
			if($_COOKIE['damares-rate']){

				$data = json_decode($_COOKIE['damares-rate'],true);
				if(!in_array($item_rate_id,$data)){
					$data[]=$item_rate_id;
				}
				// print_r($data);
				// exit;
				
				$json = $data;
			}else{
				$json =[$item_rate_id];
			}
			
			setcookie("damares-rate", json_encode($json), time()+(60 * 60 *24 * 365 *10 ),"/");

			header("Location: ../../$origin.php?msg=rateOk".$idOrigin.$page."");
			exit;
		}else{
			header("Location: ../../$origin.php?msg=rateFail".$idOrigin.$page."");
			exit;
		}
		

	}else{

		// insert
		$rate->vote_sum = $star_form ;
		$rate->vote_number = 1 ;

		$star_arr=[];

		for($i=1;$i<6;$i++){
			$value="";

			if($i == $star_form){
				$value=1;
			}

			$star_arr[]=array($i=>$value);

		}

		$star_serial = serialize($star_arr);

		$rate->star = $star_serial;

		$star_float = sprintf("%.1f",$star_form);

		$rate->star_vote = $star_form ;

		$rate->percent = ($star_form*100)/5;

		if($rate->insert(['item_rate_id','vote_sum','vote_number','star','star_vote','percent'])){

			if($_COOKIE['damares-rate']){

				$data = json_decode($_COOKIE['damares-rate'],true);
				if(!in_array($item_rate_id,$data)){
					$data[]=$item_rate_id;
				}
				// print_r($data);
				// exit;
				
				$json = $data;
			}else{
				$json =[$item_rate_id];
			}
			
			setcookie("damares-rate", json_encode($json), time()+(60 * 60 *24 * 365 *10 ),"/");

			header("Location: ../../$origin.php?msg=rateOk".$idOrigin.$page."");
			exit;
		}else{
			header("Location: ../../$origin.php?msg=rateFail".$idOrigin.$page."");
			exit;
		}

		

	}
	

}else{
	header("Location: ../index.php?msg=errPost");
	exit;
}
exit;

?>
