<?php

// plugin information

$pluginname = "customers" ;
$description = "Create and manage customers" ;
$link_parent = "customers" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS ".$prefix."customers
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255) NOT NULL,
      surname VARCHAR(255) NOT NULL,
      details TEXT DEFAULT NULL,
      details_opt TEXT DEFAULT NULL)";

$parent_table=[['link'=>'customers',
                  'label'=>'Customers',
                  'icon'=>'person-vcard']];

$child_table=[['link'=>'allCustomers',
                'label'=>'All Customers',
                'icon'=>'people-fill'],
                ['link'=>'addCustomer',
                'label'=>'Add a customer',
                'icon'=>'person-plus-fill']
               ];

$query_drop_table = "DROP TABLE  ".$prefix."customers";

?>