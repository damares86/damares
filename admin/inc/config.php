<?php
require "core/prefix.php";
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

$module = $plugin->showAll('id');
foreach($module as $row){
    $plugin->pluginname = $row['pluginname'] ;
        if($plugin->itemExists('pluginname') && $plugin->isActive()==1){
            $scan = scandir("plugins/".$row['pluginname']."/class");
            $exclude = array('..', '.','.gitkeep');
            foreach($scan as $file){
            if (!in_array($file,$exclude)) {
                $item = pathinfo($file);
                include "class/plugin/".$item['basename']."";
                echo "class/plugin/".$item['basename']."";
                $class_file = $item['filename'] ;
                $class_var = strtolower($class_file) ;
                $$class_var = new $class_file($db);
            }
        }
    }
}

// get the p from url if exists
if(filter_input(INPUT_GET,"p")){
    $page = filter_input(INPUT_GET,"p");
}else{
    $page = "dashboard";
}

$pageLabel = "" ;
$pageId = "" ;

$parent = $section->showByLink($page,'sectionParent');
$child = $section->showByLink($page,'sectionChild');

if($parent){
    $pageLabel = $parent['label'] ;
    $pageLink = $parent['link'] ;
    $pageId = $parent['id'] ;
}else if($child){
    $pageLabel = $child['label'] ;
    $pageLink = $child['link'] ;
    $pageId = $child['id'] ;
}else{
    $pageLabel = "" ;
    $pageLink = "" ;
    $pageId = "" ;
}

$setting->name="lang" ;
$stmt = $setting->showByName();
$lang = $stmt['value'];

foreach (glob("locale/$lang/*.php") as $row){
    require "$row";
}