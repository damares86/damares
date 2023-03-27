<?php

// plugin information

$pluginname = "account_register" ;
$description = "Allow user to register with a simple form" ;
$link_parent = "File to rate" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS  ".$prefix."rate_cat (
   id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   cat_name VARCHAR(255) NOT NULL);
   CREATE TABLE IF NOT EXISTS  ".$prefix."fileCat (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      file_id INT(5) NOT NULL,
      rate_cat_id INT (5) NOT NULL);
   CREATE TABLE IF NOT EXISTS  ".$prefix."fileAccountRate (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      account_id INT(5) NOT NULL,
      file_id INT(5) NOT NULL,
      rate INT (1) NOT NULL);
   CREATE TABLE IF NOT EXISTS  ".$prefix."rate (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      file_id INT(5) NOT NULL,
      vote_sum INT NOT NULL,
      vote_number INT(5) NOT NULL,
      star INT(3) NOT NULL,
      percent INT (3) NOT NULL);";

$parent_table=[['link'=>'#',
      'label'=>'File to rate',
      'icon'=>'star-fill']];

$child_table=[['link'=>'allFilesRate',
                'label'=>'All files to rate',
                'icon'=>'files-alt'],
                ['link'=>'addFileRate',
                'label'=>'Add file to rate',
                'icon'=>'file-earmark-plus'],
                ['link'=>'allRateCat',
                'label'=>'Rate categories',
                'icon'=>'grid-fill'],
                ['link'=>'addRateCat',
                'label'=>'Add rate category',
                'icon'=>'plus-square-fill']];

$query_drop_table = "DROP TABLE  ".$prefix."rate_cat, ".$prefix."fileCat, ".$prefix."fileAccountRate;";

?>