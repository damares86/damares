<?php

// plugin information

$pluginname = "luna_portal" ;
$description = "A simple documentation portal" ;
$link_parent = "luna_portal" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS ".$prefix."parent_pages
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(255) NOT NULL,
      content TEXT NOT NULL,
      last_editor INT(5) NOT NULL,
      last_edit_time datetime DEFAULT CURRENT_TIMESTAMP);
      CREATE TABLE IF NOT EXISTS ".$prefix."child_pages
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(255) NOT NULL,
      content TEXT NOT NULL,
      last_editor INT(5) NOT NULL,
      last_edit_time datetime DEFAULT CURRENT_TIMESTAMP);
      CREATE TABLE IF NOT EXISTS ".$prefix."paragraph
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(255) NOT NULL,
      content TEXT NOT NULL,
      last_editor INT(5) NOT NULL,
      last_edit_time datetime DEFAULT CURRENT_TIMESTAMP);
      CREATE TABLE IF NOT EXISTS ".$prefix."parent_order
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      parent_pages_id TEXT NOT NULL);
      CREATE TABLE IF NOT EXISTS ".$prefix."parent_child
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      parent_pages_id INT (5) NOT NULL,
      child_pages_id TEXT NOT NULL);
      CREATE TABLE IF NOT EXISTS ".$prefix."child_paragraph
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      child_pages_id INT (5) NOT NULL,
      paragraph_id TEXT NOT NULL);";

$parent_table=[['link'=>'luna_portal',
                  'label'=>'Luna portal',
                  'icon'=>'moon-stars-fill']];

$child_table=[['link'=>'allPages',
                'label'=>'Manage Pages',
                'icon'=>'journal-bookmark-fill'],
                ['link'=>'addPage',
                'label'=>'Add a new page',
                'icon'=>'journal-plus']
               ];

$query_drop_table = "DROP TABLE  ".$prefix."parent_pages, ".$prefix."child_pages, ".$prefix."paragraph, ".$prefix."parent_order, ".$prefix."parent_child, ".$prefix."child_paragraph ";

?>