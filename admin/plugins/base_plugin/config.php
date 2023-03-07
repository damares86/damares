<?php

// plugin information

$pluginname = "base_plugin" ;
$description = "Description lorem ipsum" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS ".$prefix."baseTable
    ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    field INT ( 5 ) NOT NULL,
    FOREIGN KEY (field) REFERENCES ext_table(id));
    INSERT INTO ".$prefix."sectionChild
        (link,label,icon,parent_id)
        VALUES ('baseLink','Base name','terminal','1')" ;

$query_disable = "DELETE FROM ".$prefix."sectionChild WHERE link = 'baseLink'";

$query_drop_table = "DROP TABLE  ".$prefix."baseTable;
            DELETE FROM ".$prefix."sectionChild WHERE link = 'baseLink'";

?>