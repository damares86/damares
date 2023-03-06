<?php

// plugin information

$pluginname = "file_for_role" ;
$description = "Description lorem ipsum" ;

// query to create and drop the table

$query_create_table = "CREATE TABLE IF NOT EXISTS ".$prefix."filesRoles
    ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    file_id INT ( 5 ) NOT NULL,
    role_id INT (5) NOT NULL,
    FOREIGN KEY (file_id) REFERENCES files(id),
    FOREIGN KEY (role_id) REFERENCES roles(id))";

$query_drop_table = "DROP TABLE  ".$prefix."filesRoles";

?>