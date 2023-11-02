<?php

require __DIR__.'/vendor/autoload.php';		// If installed via composer

$debug = new \bdk\Debug(array(
	'collect' => true,
	'output' => true,
));


$text = "Lorem ipsum";

$filename = time().".txt";

$myfile = fopen("$filename", "w");

fwrite($myfile, $text);

fclose($myfile);

?>