<?php

require __DIR__."/prefix.php";
require __DIR__."/version.php";

spl_autoload_register('autoloader');

function autoloader($class){
	include("class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

// recall of all the classes
$files=glob("class/*.php", GLOB_BRACE);
rsort($files); 

// creation of the file with all the initialization of the classes
if(!is_file('inc/class_initialize.php')){
$file_handle = fopen('inc/class_initialize.php', 'w');
fwrite($file_handle, '<?php');
fwrite($file_handle, "\n");
foreach ($files as $filename) {
    $nomefile = pathinfo($filename);
    $file=$nomefile['filename'];
    $file_var = strtolower($file);
    fwrite($file_handle, '$'.$file_var.' = new '.$file.'($db);');
    fwrite($file_handle, "\n");
}
if($prefix){
    fwrite($file_handle,'$common->prx = "'.$prefix.'_";') ;
    fwrite($file_handle, "\n");
}
fwrite($file_handle,"?>");
chmod('inc/class_initialize.php',0777);
}

include "inc/class_initialize.php";

// get the p from url if exists
if(filter_input(INPUT_GET,"p")){
    $page = filter_input(INPUT_GET,"p");
}else{
    $page = "dashboard";
}