<?php

// plugin information

$pluginname = "base_module";
$description = "Lorem ipsum";
$link_parent = "base_module";

// query to create the tables and insert values

$query_create_table = "CREATE TABLE IF NOT EXISTS " . $prefix . "table_name
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      field VARCHAR(255) NOT NULL);
      CREATE TABLE IF NOT EXISTS " . $prefix . "second_table_name
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      field VARCHAR(255) NOT NULL);";

// the data of the parent item of the menu

$menu_link = [[
      'link' => 'base_module',
      'label' => 'Base module',
      'icon' => 'icon-name',
      'child' => [
            [
                  'link' => 'allBaseModule',
                  'label' => 'All base module',
                  'icon' => 'icon-name',
                  'show_menu' => '1'
            ],
            [
                  'link' => 'addBaseModule',
                  'label' => 'Add a new base module',
                  'icon' => 'icon-name',
                  'show_menu' => '0'
            ]
      ]
]];

$query_drop_table = "DROP TABLE  " . $prefix . "table_name, " . $prefix . "second_table_name";
