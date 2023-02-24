<?php

require "inc/header.php" ;

$role->rolename = 'User' ; 

$id = $role->showIdByRolename();

print_r($id);
exit;


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
        
$num = $section->countChild('1');
print_r($num) ;
exit;













