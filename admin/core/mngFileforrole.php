<?php

$stmt1 = $file->showAllWhere('id',['filename']);
$row = $stmt1->fetch(PDO::FETCH_ASSOC);

$file_id = $row['id'] ;
$roles = $_POST['roles'];

foreach($roles as $item){
    $fileforrole->file_id = $file_id ;
    $fileforrole->role_id = $item ;
    $fileforrole->insertFileRole(['file_id','role_id']);
}


?>