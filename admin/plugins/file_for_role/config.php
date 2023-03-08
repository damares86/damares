<?php

// plugin information

$pluginname = "file_for_role"  ;
$description = "Assign every file to specific roles" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS ".$prefix."filesRoles
    ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    file_id INT ( 5 ) NOT NULL,
    role_id INT ( 5 ) NOT NULL);" ;

$query_drop_table = "DROP TABLE  ".$prefix."filesRoles;";

?>