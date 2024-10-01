<?php

// plugin information

use PhpOffice\PhpSpreadsheet\Reader\Gnumeric\PageSetup;

$pluginname = "mini_cms";
$description = "A complete CMS, with page management, galleries and more";
$link_parent = "mini_cms";

// query to create the tables and insert values

$query_create_table = "CREATE TABLE IF NOT EXISTS " . $prefix . "mc_pages
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      page_name VARCHAR(255) NOT NULL,
      no_del INT(1) NOT NULL,
      layout VARCHAR(50) NOT NULL,
      header INT(1) NOT NULL,
      header_media VARCHAR(255) DEFAULT NULL,
      use_name INT(1) DEFAULT 0,
      use_desc INT(1) DEFAULT 0,
      counter INT(3) NOT NULL);
      CREATE TABLE IF NOT EXISTS " . $prefix . "mc_default_pages
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      page_name VARCHAR(255) NOT NULL,
      header INT(1) NOT NULL,
      header_media VARCHAR(255) DEFAULT NULL,
      use_name INT(1) DEFAULT 0,
      use_desc INT(1) DEFAULT 0);
      CREATE TABLE IF NOT EXISTS " . $prefix . "mc_menu
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      page_id INT(5) NOT NULL);
      CREATE TABLE IF NOT EXISTS " . $prefix . "mc_galleries
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      gallery_name VARCHAR(255) NOT NULL);
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
      CREATE TABLE IF NOT EXISTS " . $prefix . "mc_popup_cat
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      category VARCHAR(255) NOT NULL);
      CREATE TABLE IF NOT EXISTS " . $prefix . "mc_settings
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255) NOT NULL,
      value VARCHAR(255) NOT NULL);
      CREATE TABLE IF NOT EXISTS " . $prefix . "mc_contacts
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      label VARCHAR(255) NOT NULL,
      email VARCHAR(255) NOT NULL);
      INSERT INTO " . $prefix . "mc_default_pages
      (page_name, header, header_media,use_name,use_desc)
      VALUES ('contact','1','visual.jpg','1','1');
      INSERT INTO " . $prefix . "mc_default_pages
      (page_name, header, header_media,use_name,use_desc)
      VALUES ('login','1','visual.jpg','1','1');
      INSERT INTO " . $prefix . "mc_pages
      (page_name, no_del,layout,header,header_media,use_name,use_desc,counter)
      VALUES ('index','1','default','1','visual.jpg','1','1','1');
      INSERT INTO " . $prefix . "mc_settings
      (name, value )
      VALUES ('mc_site_name', 'Mini CMS Website');
      INSERT INTO " . $prefix . "mc_settings
      (name, value )
      VALUES ('mc_site_description', 'Your new beautiful website');
      INSERT INTO " . $prefix . "mc_settings
      (name, value )
      VALUES ('mc_use_text', '0');
      INSERT INTO " . $prefix . "mc_settings
      (name, value )
      VALUES ('mc_footer', 'Mini CMS by DMWeblab');
      INSERT INTO " . $prefix . "mc_settings
      (name, value )
      VALUES ('mc_theme', 'damares');
      INSERT INTO " . $prefix . "mc_settings
      (name, value )
      VALUES ('maintenance', '0');
      INSERT INTO " . $prefix . "mc_contacts
      (label, email )
      VALUES ('info', 'info@mail.com');
      INSERT INTO " . $prefix . "mc_popup_cat
      (category)
      VALUES ('Misc');";

// the data of the parent item of the menu

$menu_link = [[
      'link' => 'mini_cms',
      'label' => 'Mini CMS',
      'icon' => 'layout-wtf',
      'child' => [
            [
                  'link' => 'allDefaultPages',
                  'label' => 'Default pages',
                  'icon' => 'file-earmark-medical',
                  'show_menu' => '1'
            ],
            [
                  'link' => 'editDefaultPages',
                  'label' => 'Edit default pages',
                  'icon' => 'file-earmark-medical',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'allPages',
                  'label' => 'Custom pages',
                  'icon' => 'file-earmark-richtext',
                  'show_menu' => '1'
            ],
            [
                  'link' => 'addPage',
                  'label' => 'Add custom pages',
                  'icon' => 'file-earmark-richtext',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'editPage',
                  'label' => 'Edit custom pages',
                  'icon' => 'file-earmark-richtext',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'allMenu',
                  'label' => 'Manage menu',
                  'icon' => 'menu-app',
                  'show_menu' => '1'
            ],
            [
                  'link' => 'allGalleries',
                  'label' => 'Galleries',
                  'icon' => 'card-image',
                  'show_menu' => '1'
            ],
            [
                  'link' => 'editGallery',
                  'label' => 'Edit galleries',
                  'icon' => 'card-image',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'addGallery',
                  'label' => 'Add galleries',
                  'icon' => 'card-image',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'allTheme',
                  'label' => 'Theme and colors',
                  'icon' => 'palette',
                  'show_menu' => '1'
            ],
            [
                  'link' => 'allQuotes',
                  'label' => 'Quotes',
                  'icon' => 'quote',
                  'show_menu' => '1'
            ],
            [
                  'link' => 'editQuote',
                  'label' => 'Edit quote',
                  'icon' => 'quote',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'allPopup',
                  'label' => 'Popup',
                  'icon' => 'window-stack',
                  'show_menu' => '1'
            ],
            [
                  'link' => 'addPopup',
                  'label' => 'Add popup',
                  'icon' => 'window-stack',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'editPopup',
                  'label' => 'Edit popup',
                  'icon' => 'window-stack',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'allMcSettings',
                  'label' => 'Settings',
                  'icon' => 'wrench',
                  'show_menu' => '1'
            ]
      ]
]];

$query_drop_table = "DROP TABLE  " . $prefix . "mc_pages, " . $prefix . "mc_default_pages, " . $prefix . "mc_menu, " . $prefix . "mc_galleries, " . $prefix . "mc_color, " . $prefix . "mc_quotes, " . $prefix . "mc_popup";
