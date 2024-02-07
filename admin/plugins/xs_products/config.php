<?php

// plugin information

$pluginname = "xs_products" ;
$description = "Manage XStream Products" ;
$link_parent = "xs_products" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS ".$prefix."product
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      product_name VARCHAR(255) NOT NULL);
      CREATE TABLE IF NOT EXISTS ".$prefix."product_doc
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      product_doc_name VARCHAR(255) NOT NULL,
      product_doc_label VARCHAR(255) NOT NULL,
      product_id INT ( 5 ) NOT NULL)";

$parent_table=[['link'=>'allXSProduct',
                  'label'=>'Products',
                  'icon'=>'display']];


$query_drop_table = "DROP TABLE  ".$prefix."product, ".$prefix."product_doc";

?>