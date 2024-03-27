<?php

// plugin information

$pluginname = "xs_resources" ;
$description = "Manage XStream Resources" ;
$link_parent = "xs_resources" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS ".$prefix."resources
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      resource_name VARCHAR(255) NOT NULL,
      title VARCHAR(255) NOT NULL,
      description TEXT NOT NULL,
      product_id INT ( 5 ) NOT NULL,
      lang_id INT ( 5 ) NOT NULL,
      type_id INT ( 5 ) NOT NULL,
      resource_date DATE);
      CREATE TABLE IF NOT EXISTS ".$prefix."resource_lang
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      resource_lang VARCHAR(255) NOT NULL);
      CREATE TABLE IF NOT EXISTS ".$prefix."resource_type
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      resource_type VARCHAR(255) NOT NULL,
      img VARCHAR(255) NOT NULL);";

$parent_table=[['link'=>'xs_resources',
                  'label'=>'Resources',
                  'icon'=>'file-earmark-pdf']];

$child_table=[['link'=>'allXSResources',
            'label'=>'All resources',
            'icon'=>'files'],
            ['link'=>'allXSLangs',
            'label'=>'Resources language',
            'icon'=>'translate'],
            ['link'=>'allXSTypes',
            'label'=>'Resources type',
            'icon'=>'bookmarks']
            ];

$query_drop_table = "DROP TABLE  ".$prefix."resources, ".$prefix."resource_lang, ".$prefix."resource_type";

?>