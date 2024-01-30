<?php

$ch = curl_init('http://minicms.altervista.org/admin/core/mngScadenze.php');
  
// execute!
$response = curl_exec($ch);
// close the connection, release resources used
curl_close($ch);

// do anything you want with your response

?>