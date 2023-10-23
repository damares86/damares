<?php

// plugin information

$pluginname = "rating_system" ;
$description = "Add a rating system for file, user or other things" ;
$link_parent = "rating" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS  ".$prefix."rate_cat (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      cat_name VARCHAR(255) NOT NULL,
      active INT ( 1 ) DEFAULT 0);
      CREATE TABLE IF NOT EXISTS  ".$prefix."item_rate (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      rate_cat_id INT ( 5 ) NOT NULL,
      item_id INT ( 5 ) NOT NULL,
      rate_active INT ( 1 ) DEFAULT 0);
      CREATE TABLE IF NOT EXISTS  ".$prefix."rate (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      item_rate_id INT ( 5 ) NOT NULL,
      vote_sum  INT ( 5 ) DEFAULT 0,
      vote_number  INT ( 5 ) DEFAULT 0,
      star  TEXT,
      star_vote  FLOAT ( 1,1 ) DEFAULT 0,
      percent  INT ( 5 ) DEFAULT 0);";

$parent_table=[['link'=>'rating',
                  'label'=>'Rating',
                  'icon'=>'stars']];

$child_table=[['link'=>'allRate',
                'label'=>'Rate results',
                'icon'=>'star-half'],
                ['link'=>'editRateItems',
                'label'=>'Manage rate items',
                'icon'=>'file-check'],
                ['link'=>'editRateCat',
                'label'=>'Manage rate categories',
                'icon'=>'card-checklist']
               ];

$query_drop_table = "DROP TABLE  ".$prefix."rate_cat, ".$prefix."item_rate, ".$prefix."rate;";

?>