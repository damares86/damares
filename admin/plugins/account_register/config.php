<?php

// plugin information

$pluginname = "account_register" ;
$description = "Allow user to register with a simple form" ;
$link_parent = "settings" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS  ".$prefix."register_account_temp (
   id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   email VARCHAR(250) NOT NULL,
   username VARCHAR(250) NOT NULL,
   password VARCHAR(250) NOT NULL,
   token VARCHAR(250) NOT NULL,
   expDate DATETIME NOT NULL);
   INSERT INTO ".$prefix."settings
   (name,value)
   VALUES ('reg_role','Manager');";

$child_table=[['link'=>'setRegister',
                'label'=>'Account register',
                'icon'=>'person-badge']];

$query_drop_table = "DROP TABLE  ".$prefix."register_account_temp;
                     DELETE FROM ".$prefix."settings WHERE value = reg_role";

?>