<?php
    // require '../admin/vendor/autoload.php';		// If installed via composer
    // $debug = new \bdk\Debug(array(
    // 	'collect' => true,
    // 	'output' => true,
    // ));

spl_autoload_register('autoloader');

function autoloader($class){
	include("../admin/class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

require "../admin/inc/class_initialize.php" ;

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
            }
        }
    }
}

require "../admin/inc/check_cookie.php" ;

$setting->name="lang" ;
$stmt = $setting->showByName();
$lang = $stmt['value'];

foreach (glob("../admin/locale/$lang/*.php") as $row){
    require "$row";
}
?>