<?php

// plugin information

$pluginname = "post";
$description = "Manage a blog, with custom categories";
$link_parent = "post";

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS " . $prefix . "post
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      main_img VARCHAR(255) NOT NULL,
      gall VARCHAR(255) DEFAULT NULL,
      title VARCHAR(255) NOT NULL,
      author VARCHAR(255) NOT NULL,
      content text COLLATE utf8_unicode_ci NOT NULL,
      created datetime NOT NULL,
      category_id VARCHAR (255) NULL);
      CREATE TABLE IF NOT EXISTS post_categories
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      category_name VARCHAR(255) NOT NULL);
      INSERT INTO post_categories
      (id, category_name)
      VALUES ('1','Misc')";

$menu_link = [[
      'link' => 'post',
      'label' => 'Posts',
      'icon' => 'vector-pen',
      'child' => [
            [
                  'link' => 'addPost',
                  'label' => 'Add post',
                  'icon' => 'file-earmark-plus'
            ],
            [
                  'link' => 'allPosts',
                  'label' => 'All Posts',
                  'icon' => 'file-earmark-post'
            ],
            [
                  'link' => 'allPostsCat',
                  'label' => 'All categories',
                  'icon' => 'bookmarks'
            ]
      ]
]];

$query_drop_table = "DROP TABLE  " . $prefix . "post, " . $prefix . "post_categories";
