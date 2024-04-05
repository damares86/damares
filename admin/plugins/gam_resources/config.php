<?php

// plugin information

$pluginname = "gam_resources" ;
$description = "Manage GAM Resources (prayers, song, etc)" ;
$link_parent = "gam_resources" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS ".$prefix."resources
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      resource_name VARCHAR(255) NOT NULL,
      title VARCHAR(255) NOT NULL,
      description TEXT DEFAULT NULL,
      cat_id INT ( 5 ) NOT NULL,
      type_id INT ( 5 ) NOT NULL,
      img VARCHAR(255) DEFAULT 'default_res.png',
      resource_date DATE);
      CREATE TABLE IF NOT EXISTS ".$prefix."resource_cat
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      cat VARCHAR(255) NOT NULL);
      CREATE TABLE IF NOT EXISTS ".$prefix."resource_type
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      type VARCHAR(255) NOT NULL);";

$parent_table=[['link'=>'gam_resources',
                  'label'=>'GAM Resources',
                  'icon'=>'book']];

$child_table=[['link'=>'allGamResources',
            'label'=>'All Gam Resources',
            'icon'=>'file-earmark-pdf'],
            ['link'=>'allGamCats',
            'label'=>'Resources category',
            'icon'=>'file'],
            ['link'=>'allGamTypes',
            'label'=>'Resources type',
            'icon'=>'bookmarks']
            ];

$query_drop_table = "DROP TABLE  ".$prefix."resources, ".$prefix."resource_cat, ".$prefix."resource_type";

?>