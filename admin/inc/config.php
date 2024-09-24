<?php
require "core/prefix.php";
require __DIR__ . "/damares_version.php";

spl_autoload_register('autoloader');

function autoloader($class)
{
    include("class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

// recall of all the classes
$files = glob("class/*.php", GLOB_BRACE);
rsort($files);

// creation of the file with all the initialization of the classes
if (!is_file('inc/class_initialize.php')) {
    $file_handle = fopen('inc/class_initialize.php', 'w');
    fwrite($file_handle, '<?php');
    fwrite($file_handle, "\n");
    foreach ($files as $filename) {
        $nomefile = pathinfo($filename);
        $file = $nomefile['filename'];
        if ($file != "PhpXlsxGenerator") {
            $file_var = strtolower($file);
            fwrite($file_handle, '$' . $file_var . ' = new ' . $file . '($db);');
            fwrite($file_handle, "\n");
        }
    }
    if ($prefix) {
        fwrite($file_handle, '$common->prx = "' . $prefix . '_";');
        fwrite($file_handle, "\n");
    }
    fwrite($file_handle, "?>");
    chmod('inc/class_initialize.php', 0777);
}
include "inc/class_initialize.php";

$setting->name = "debug";
$dbg = $setting->showAllWhere('id', ['name']);
$row_debug = $dbg->fetch(PDO::FETCH_ASSOC);
extract($row_debug);

if ($row_debug['value'] == 1) {
    require 'vendor/autoload.php';        // If installed via composer
    $debug = new \bdk\Debug(array(
        'collect' => true,
        'output' => true,
    ));
}

// get the p from url if exists
if (filter_input(INPUT_GET, "p")) {
    $page = filter_input(INPUT_GET, "p");
} else {
    $page = "index";
}

$pageLabel = "";
$pageId = "";

$parent = $section->showByLink($page, 'sectionParent');
$child = $section->showByLink($page, 'sectionChild');

if ($parent) {
    $pageLabel = $parent['label'];
    $pageLink = $parent['link'];
    $pageId = $parent['id'];
    $check_parent = $pageId;
} else if ($child) {
    $pageLabel = $child['label'];
    $pageLink = $child['link'];
    $pageId = $child['id'];
    $check_parent = 0;
} else {
    /////////////////////////////////////////////////
    // GESTIRE IL CASO DI PAGINA NON INSERITA NEL DB
    /////////////////////////////////////////////////
    $pageLabel = "";
    $pageLink = "";
    $pageId = "";
    $check_parent = 0;
}

$setting->name = "lang";
$stmt = $setting->showByName();
$lang = $stmt['value'];

foreach (glob("locale/$lang/*.php") as $row) {
    require "$row";
}

// variable for require script for chart
$apex = '';
