<?php

$stmt = $file->showIdByFilename();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$file_id = $row['id'] ;
$roles = $_POST['roles'];
print_r($roles);
exit;

foreach($roles as $item){
    $fileforrole->file_id = $file_id ;
    $fileforrole->role_id = $item ;
    $fileforrole->insert(['file_id','role_id']);
}



?>