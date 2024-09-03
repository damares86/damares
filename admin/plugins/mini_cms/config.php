<?php

// plugin information

use PhpOffice\PhpSpreadsheet\Reader\Gnumeric\PageSetup;

$pluginname = "mini_cms";
$description = "A complete cMS, with page management, galleries and more";
$link_parent = "mini_cms";

// query to create the tables and insert values

$query_create_table = "CREATE TABLE IF NOT EXISTS " . $prefix . "mc_pages
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      page_name VARCHAR(255) NOT NULL,
      no_mod INT(1) NOT NULL,
      layout VARCHAR(50) NOT NULL,
      header INT(1) NOT NULL,
      use_name INT(1) NOT NULL,
      use_desc INT(1) NOT NULL,
      img VARCHAR(255) NOT NULL,
      counter INT(3) NOT NULL);
      CREATE TABLE IF NOT EXISTS " . $prefix . "mc_default_pages
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      page_name VARCHAR(255) NOT NULL,
      header INT(1) NOT NULL,
      use_name INT(1) NOT NULL,
      use_desc INT(1) NOT NULL,
      img VARCHAR(255) NOT NULL);
      CREATE TABLE IF NOT EXISTS " . $prefix . "mc_menu
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      page_id INT(5) NOT NULL);
      CREATE TABLE IF NOT EXISTS " . $prefix . "mc_galleries
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      page_id INT(5) NOT NULL);
      CREATE TABLE IF NOT EXISTS " . $prefix . "mc_color
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      color VARCHAR(10) NOT NULL);
      CREATE TABLE IF NOT EXISTS " . $prefix . "mc_quotes
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      quote TEXT NOT NULL,
      author VARCHAR(255) NOT NULL);
      CREATE TABLE IF NOT EXISTS " . $prefix . "mc_popup
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(255) NOT NULL,
      content TEXT NOT NULL,
      page_id INT(5) NOT NULL,
      popup_cat_id INT(5) NOT NULL);
      INSERT INTO " . $prefix . "settings
      (name, value )
      VALUES ('mc_site_name', 'Mini CMS Website');
      INSERT INTO " . $prefix . "settings
      (name, value )
      VALUES ('mc_site_description', 'Your new beautiful website');
      INSERT INTO " . $prefix . "settings
      (name, value )
      VALUES ('mc_use_text', '0');
      INSERT INTO " . $prefix . "settings
      (name, value )
      VALUES ('mc_footer', 'Mini CMS by DMWeblab');
      INSERT INTO " . $prefix . "settings
      (name, value )
      VALUES ('mc_theme', 'mini_cms');
      INSERT INTO " . $prefix . "settings
      (name, value )
      VALUES ('maintenance', '0');";

// the data of the parent item of the menu

$menu_link = [[
      'link' => 'mini_cms',
      'label' => 'Mini CMS',
      'icon' => 'layout-wtf',
      'child' => [
            [
                  'link' => 'allDefaultPages',
                  'label' => 'Default pages',
                  'icon' => 'file-earmark-medical'
            ],
            [
                  'link' => 'allPages',
                  'label' => 'Custom pages',
                  'icon' => 'file-earmark-richtext'
            ],
            [
                  'link' => 'allMenu',
                  'label' => 'Manage menu',
                  'icon' => 'menu-app'
            ],
            [
                  'link' => 'allGalleries',
                  'label' => 'Galleries',
                  'icon' => 'card-image'
            ],
            [
                  'link' => 'allTheme',
                  'label' => 'Theme and colors',
                  'icon' => 'palette'
            ],
            [
                  'link' => 'allQuotes',
                  'label' => 'Quotes',
                  'icon' => 'quotes'
            ],
            [
                  'link' => 'allPopup',
                  'label' => 'Popup',
                  'icon' => 'window-stack'
            ],
            [
                  'link' => 'allMcSettings',
                  'label' => 'Settings',
                  'icon' => 'wrench'
            ]
      ]
]];

$query_drop_table = "DROP TABLE  " . $prefix . "mc_pages, " . $prefix . "mc_default_pages, " . $prefix . "mc_menu, " . $prefix . "mc_galleries, " . $prefix . "mc_color, " . $prefix . "mc_quotes, " . $prefix . "mc_popup";
