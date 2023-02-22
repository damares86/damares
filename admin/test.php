<?php

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

require "inc/header.php" ;

$account->id=1;
$items = ['id'];

$test = $account->showAll($items,'id'); 

print_r($test) ;
exit;