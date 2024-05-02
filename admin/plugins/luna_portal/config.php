<?php

// plugin information

$pluginname = "luna_portal";
$description = "A simple documentation portal";
$link_parent = "luna_portal";

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS " . $prefix . "luna_products
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255) NOT NULL,
      version VARCHAR(20) DEFAULT NULL);
      CREATE TABLE IF NOT EXISTS " . $prefix . "luna_pages
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(255) NOT NULL,
      content TEXT NOT NULL,
      luna_products_id INT (5) NOT NULL,
      last_editor INT(5) NOT NULL,
      last_edit_time datetime DEFAULT CURRENT_TIMESTAMP);
      CREATE TABLE IF NOT EXISTS " . $prefix . "luna_settings
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255) NOT NULL,
      value VARCHAR(255) NOT NULL);
      CREATE TABLE IF NOT EXISTS " . $prefix . "luna_users
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255) DEFAULT NULL,
      username VARCHAR(255) NOT NULL,
      company VARCHAR(255) DEFAULT NULL,
      password VARCHAR(255) NOT NULL,
      email VARCHAR(255) NOT NULL,
      permissions VARCHAR(255) DEFAULT NULL);
      INSERT INTO ".$prefix."luna_settings
      (name, value)
      VALUES ('users','0');";

$parent_table = [[
      'link' => 'luna_portal',
      'label' => 'Luna portal',
      'icon' => 'moon-stars-fill'
]];

$child_table = [
      [
            'link' => 'allLunaProducts',
            'label' => 'Manage Products',
            'icon' => 'clipboard2-plus-fill'
      ],
      [
            'link' => 'allLunaUsers',
            'label' => 'Manage Users',
            'icon' => 'people-fill'
      ]
];

$query_drop_table = "DROP TABLE  " . $prefix . "luna_products, " . $prefix . "luna_pages, " . $prefix . "luna_settings, " . $prefix . "luna_users ";
