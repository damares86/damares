<?php

// plugin information

$pluginname = "cms" ;
$description = "A module to create and manage a website, with dynamic pages and menu" ;
$link_parent = "cms" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS ".$prefix."pages
    ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    pagename VARCHAR(255) NOT NULL,
    nomod INT(1) NOT NULL DEFAULT 0);
    CREATE TABLE IF NOT EXISTS ".$prefix."contacts
    ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL);
    CREATE TABLE IF NOT EXISTS ".$prefix."menuParent
    ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    page_id INT(5) NOT NULL,
    inmenu INT(1) NOT NULL DEFAULT 0,
    itemorder INT(5) NOT NULL,
    label VARCHAR(255) NOT NULL,
    FOREIGN KEY (page_id) REFERENCES ".$prefix."pages(id));
    CREATE TABLE IF NOT EXISTS ".$prefix."menuChild
    ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    page_id INT(5) NOT NULL,
    inmenu INT(1) NOT NULL DEFAULT 0,
    itemorder INT(5) NOT NULL,
    parent_id INT(5) NOT NULL,
    label VARCHAR(255) NOT NULL,
    FOREIGN KEY (parent_id) REFERENCES ".$prefix."menuParent(id));";

$parent_table=[['link'=>'cms',
                'label'=>'Cms',
                'icon'=>'terminal']];

$child_table=[['link'=>'allPages',
                'label'=>'All pages',
                'icon'=>'file-earmark'],
             ['link'=>'allMenu',
                'label'=>'Menu',
                'icon'=>'menu-button'],
             ['link'=>'allContact',
                'label'=>'All contacts',
                'icon'=>'envelope-paper']];

$query_drop_table = "DROP TABLE  ".$prefix."pages, ".$prefix."contacts, ".$prefix."menuParent, ".$prefix."menuChild;";

?>