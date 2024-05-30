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
      CREATE TABLE IF NOT EXISTS ".$prefix."product_files
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      product_files_name VARCHAR(255) NOT NULL,
      product_files_label VARCHAR(255) NOT NULL,
      product_files_cat_id INT ( 5 ) NOT NULL,
      product_id INT ( 5 ) NOT NULL,
      permissions TEXT);
      CREATE TABLE IF NOT EXISTS ".$prefix."product_files_cat
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      cat_name VARCHAR(255) NOT NULL);
      CREATE TABLE IF NOT EXISTS ".$prefix."product_permissions
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      customers_id INT(5) NOT NULL,
      product_id INT(5) NOT NULL)";

$parent_table=[['link'=>'xs_products',
                  'label'=>'Products',
                  'icon'=>'display']];

$child_table=[['link'=>'allXSProduct',
                  'label'=>'All products',
                  'icon'=>'display'],
                  ['link'=>'allXSProductCat',
                  'label'=>'Files categories',
                  'icon'=>'bookmarks']] ;


$query_drop_table = "DROP TABLE  ".$prefix."product, ".$prefix."product_files, ".$prefix."product_files_cat, ".$prefix."product_permissions";

?>