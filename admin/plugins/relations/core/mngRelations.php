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

session_start();

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
	$id = filter_input(INPUT_GET,"idToDel") ;

	$relation->id=$id ;

	if($relation->deleteFromTable('id','relations')){
		$error=0;
		$relation->relation_id = $id;
		$stmt = $relation->showAllWhereTable('id','relations_speakers_doc',['relation_id']);

		foreach($stmt as $item){
			$doc_id = $item['speaker_doc_id'];
			$relation->id=$doc_id;
			$stmt1 = $relation->showAllWhereTable('id','speakers_doc',['id']);
			$row1=$stmt1->fetch(PDO::FETCH_ASSOC);
			$filename=$row1['speakers_doc_name'];
			if($relation->deleteFromTable('id','speakers_doc')){
				unlink("../../uploads/$filename");
			}else{
				$error++;
			}
		}
		$errorMsg="";
		
		if($error>0){
			$errorMsg="&err=relFileNotDel";
		}

		header("Location: ../index.php?p=allRelations&msg=relDelSucc$errorMsg");
		exit;

	}else{
		header("Location: ../index.php?p=allRelations&err=relNotDel");
		exit;
	}

}else if(filter_input(INPUT_GET,"fileIdToDel")){

	$id = filter_input(INPUT_GET,"fileIdToDel");
	$idRel = filter_input(INPUT_GET,"sessId");

	$relation->id=$id ;

	$stmt = $relation->showAllWhereTable('id','speakers_doc',['id']);
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	$filename=$row['speakers_doc_name'];

	if($relation->deleteFromTable('id','speakers_doc')){

		$relation->speaker_doc_id = $id ;

		if($relation->deleteFromTable('speaker_doc_id','relations_speakers_doc')){
			
			if(!unlink("../../uploads/$filename")){
				header("Location: ../index.php?p=editRelation&idToMod=$idRel&err=fileDelTable");
				exit;
			} else{
				header("Location: ../index.php?p=editRelation&idToMod=$idRel&msg=fileDel");
				exit;
			}
		}else{
			header("Location: ../index.php?p=editRelation&idToMod=$idRel&err=fileDelTable");
			exit;
		}
		
	}else{		
		header("Location: ../index.php?p=editRelation&idToMod=$idRel&err=fileNotDel");
		exit;
	}

}else if(filter_input(INPUT_GET,"rel_id")){

	
	$rel_id=filter_input(INPUT_GET,"rel_id");
	$page=filter_input(INPUT_GET,"page");
	
	if(isset($_COOKIE['damares-program'])){

		$data = json_decode($_COOKIE['damares-program'],true);

		
		if(filter_input(INPUT_GET,"op")){
			
			if (($key = array_search($rel_id, $data)) !== false) {
				unset($data[$key]);
			}
			
			$json=$data ;
			
		}else{
			if(!in_array($rel_id,$data)){
				$data[]=$rel_id;
				
				$json=$data ;
			}
		}
			
	}else{
	
		$json=[$rel_id];

	}

	if(empty($json)){
		unset($_COOKIE['damares-program']);
		setcookie("damares-program", '', time() - 3600,"/");
	}else{
		setcookie("damares-program", json_encode($json), time()+(60 * 60 *24 * 365 *10 ),"/");
	}
	
	header("Location: ../../my-program.php");
	exit;
}


if($operation == "add"){
	$name = filter_input(INPUT_POST,"name");
	$date = filter_input(INPUT_POST,"date");
	$st = filter_input(INPUT_POST,"st");
	$et = filter_input(INPUT_POST,"et");
	$location = filter_input(INPUT_POST,'location');
	$speakers = $_POST['speakers'];
	
	$speakers_arr=[];
	
	foreach($speakers as $item){
		$speakers_arr[] = $item ;
	}

	$speakers_str = implode(",",$speakers_arr);
	$relation->relations_name = $name ;
	$relation->date = $date ;
	$relation->start_time = $st ;
	$relation->end_time = $et ;
	$relation->location = $location ;
	$relation->speakers_id = $speakers_str ;
	if($_POST['announcer']){
		$ann = $_POST['announcer'];
		$ann_arr=[];

		foreach($ann as $item){
			$ann_arr[]=$item;
		}

		$ann_str = implode(",",$ann_arr);
		$relation->announcer_id = $ann_str ;
	}else{
		$relation->announcer_id = 0 ;
	}
	
	if($relation->insertIntoTable(['relations_name','date','start_time','end_time','location','speakers_id','announcer_id'],'relations')){
		$relation->relations_name=$name;
		$stmt = $relation->showAllWhereTable('id','relations',['relations_name']);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$newId = $row['id'];
		header("Location: ../index.php?p=editRelation&idToMod=$newId&msg=relSucc");
		exit;
	}else{
		header("Location: ../index.php?p=allRelationss&err=relErr");
		exit;
	}

}else if($operation=="edit"){
	


	$idToMod=filter_input(INPUT_POST,'idToMod');
	$name = filter_input(INPUT_POST,"name");
	$date = filter_input(INPUT_POST,"date");
	$st = filter_input(INPUT_POST,"st");
	$et = filter_input(INPUT_POST,"et");
	$location = filter_input(INPUT_POST,'location');
	$speakers = $_POST['speakers'];	
	$announcer = $_POST['announcer'];
	$speakers_arr=[];
	$announcer_arr=[];
	$files_arr=[];
	
	// get the previous speakers
	foreach(array_keys($_POST) as $item){
		if(preg_match("/check/",$item)){
			$key_arr=explode("_",$item);
			$speakers_arr[]=$key_arr[1];
		}else if(preg_match("/myfile/",$item)){
			// get the files label with the speaker id
		
			if($_POST[$item]){
				$key_arr=explode("_",$item);
				$files_arr[]=array($key_arr[2]=>$item);
			}
		}
	}



	foreach($speakers as $item){
		if(!in_array($item,$speakers_arr)){
			$speakers_arr[] = $item ;
		}
	}
	
	$speakers_str = implode(",",$speakers_arr);

	$announcer_str=implode(",",$announcer_arr);

	$relation->id=$idToMod;
	$relation->relations_name = $name ;
	$relation->date = $date ;
	$relation->start_time = $st ;
	$relation->end_time = $et ;
	$relation->location = $location ;
	$relation->announcer = $announcer_str;
	$relation->speakers_id = $speakers_str ;
	if($_POST['announcer']){
		$ann = $_POST['announcer'];
		$ann_arr=[];

		foreach($ann as $item){
			$ann_arr[]=$item;
		}

		$ann_str = implode(",",$ann_arr);
		$relation->announcer_id = $ann_str ;
	}else{
		$relation->announcer_id = 0 ;
	}
	
	if($relation->updateTable(['relations_name','date','start_time','end_time','location','announcer_id','speakers_id'],'id','relations')){
		if($files_arr){
			$fileErrCount=0;
			$fileErr="";
			
			$relation->table="speakers_doc";
			// $relation->speaker_id = $speakers_str;
			
			// upload the file based on speaker id
			foreach($files_arr as $key){
				$sp = array_keys($key);
				$sp_id= $sp[0];
				
								
				foreach(array_keys($_FILES) as $item){
									
					$key_arr=explode("_",$item);
					foreach($files_arr as $row){
						$label_key=array_keys($row);

						if($label_key[0]==$key_arr[2]&&$label_key[0]==$sp_id){

							$myfile=$_FILES[$item];
								$relation->speakers_doc_name = $myfile['name'] ;
								$relation->inputFileName = $myfile['tmp_name'] ;
								$relation->path = "../../uploads/" ;
								$relation->origin = filter_input(INPUT_POST,"origin");
							
							$label_value=array_values($row);
							$label=$label_value[0];
							$relation->label =filter_input(INPUT_POST,"$label");
							$relation->speaker_id =$sp_id;
								if($relation->uploadFile()){	

									$relation->relation_id=$idToMod;
									
									// get the id of the uploaded file
									$relation->speakers_doc_name = $myfile['name'] ;
									$stmt = $relation->showAllWhereTable('id','speakers_doc',['speakers_doc_name']);
									$row = $stmt->fetch(PDO::FETCH_ASSOC);
									$relation->speaker_doc_id = $row['id'];
									
									if(!$relation->insertIntoTable(['relation_id','speaker_id','speaker_doc_id'],'relations_speakers_doc')){
										$fileErrCount++;				
									}				
								}					
						}
					}					
					
				}
			}	
			
		if($fileErrCount>0){
			$fileErr="&err=fileFail";
		}
	}
		header("Location: ../index.php?p=editRelation&idToMod=$idToMod&msg=relEditSucc$fileErr");
		exit;
	}else{
		header("Location: ../index.php?p=editRelation&idToMod=$idToMod&err=relEditErr");
		exit;
	}


}else if($operation=="editActive"){

	$id=filter_input(INPUT_POST,'idToMod');
	$active=filter_input(INPUT_POST,"activeRel");

	$relation->id=$id;

	if($active){
		$relation->active=1;
	}else{
		$relation->active=0;
	}

	if($relation->updateTable(['active'],'id','relations')){
		header("Location: ../index.php?p=editRelation&idToMod=$id&msg=activeSucc");
		exit;
	}else{
		header("Location: ../index.php?p=editRelation&idToMod=$id&err=activeErr");
		exit;
	}

}else{
	header("Location: ../index.php?msg=errPost");
	exit;
}
exit;

?>
