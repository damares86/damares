<?php

require "inc/header.php" ;


$file->filename = "referto.pdf" ;
print_r($file->filename."<br>");
$stmt = $file->showAllWhere('id',['filename']);
echo "ciao <br>";
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$file_id = $row['id'] ;
$roles = $_POST['roles'];
print_r($file_id) ;
exit ;

foreach($roles as $item){
    $fileforrole->file_id = $file_id ;
    $fileforrole->role_id = $item ;
    print_r("file ".$fileforrole->file_id." - Role ".$fileforrole->role_id."");
    $fileforrole->insert(['file_id','role_id']);
}




// $plugin->pluginname = "file_for_role" ;
// $active = $plugin->isActive();
// $ffr = false;
// if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
//     $ffr = true ;
// }

// print_r($ffr);

// $role->rolename = 'User' ; 

// $id = $role->showIdByRolename();

// print_r($id);
// exit;


// $items = ['accounts','file','setting'];

// $test = "";

// $i = 1;
// foreach($items as $item){
//     $test.="$item = :$item" ;
//     if($i<count($items)){
//         $test.=", ";            
//     }
//     $i++;
// }
// print_r($test);
// exit;

//////////////////////////////////////


// $account->id=1;
// $items = ['id'];

// $test = $account->showAll($items,'id'); 

// print_r($test) ;
// exit;

//////////////////////////////////////

// $stmt = $section->showAll('id','sectionParent') ;

// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
//         extract($row);

//         echo $row['link'];
//         echo "<br>";
// }

// echo "fine";

//////////////////////////////////////
        
// $num = $section->countChild('1');
// print_r($num) ;
// exit;

?>









