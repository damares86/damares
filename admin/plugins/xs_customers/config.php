<?php

// plugin information

$pluginname = "xs_customers" ;
$description = "Create and manage XStream customers" ;
$link_parent = "xs_customers" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS ".$prefix."customers
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255) NOT NULL,
      username VARCHAR(255) NOT NULL,
      company VARCHAR(255) NOT NULL,
      password VARCHAR(255) NOT NULL,
      email VARCHAR(255) NOT NULL,
      details TEXT DEFAULT NULL,
      details_opt TEXT DEFAULT NULL,
      auth_token VARCHAR(255) DEFAULT 'none',
      last_login datetime DEFAULT CURRENT_TIMESTAMP)";

$parent_table=[['link'=>'xs_customers',
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