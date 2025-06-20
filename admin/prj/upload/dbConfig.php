<?php 
 
// Database configuration 
$dbHost     = "localhost"; 
$dbUsername = "superphp"; 
$dbPassword = "admin"; 
$dbName     = "test"; 
 
// Create database connection 
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 
 
// Check connection 
if ($db->connect_error) { 
    die("Connection failed: " . $db->connect_error); 
} 
 
?>