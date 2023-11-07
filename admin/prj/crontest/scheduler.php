<?php 
require_once __DIR__ . '/vendor/autoload.php';

use GO\Scheduler;

// Create a new scheduler
$scheduler = new Scheduler();

$scheduler
->php(
    "test.php", // The script to execute
    "/etc/php/8.1/cli/php.ini", // The path to the PHP binary that is used to execute the script
    [
      "username" => "jack",
      "verified" => true,
    ],
    "myCustomIdentifier"
  )
  ->everyMinute();


// Run the scheduler
$scheduler->run();
