<?php

// plugin information

$pluginname = "newsletter";
$description = "A basic newsletter manager";
$link_parent = "newsletter";

// query to create the tables and insert values

$query_create_table = "CREATE TABLE " . $prefix . "newsletter_subscribers (
      id INT AUTO_INCREMENT PRIMARY KEY,
      email VARCHAR(255) NOT NULL UNIQUE,
      name VARCHAR(255),
      subscribed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      confirmed TINYINT(1) DEFAULT 1
      );
      CREATE TABLE " . $prefix . "newsletter_messages (
      id INT AUTO_INCREMENT PRIMARY KEY,
      subject VARCHAR(255) NOT NULL,
      body TEXT NOT NULL,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP
      );
      CREATE TABLE newsletter_queue (
      id INT AUTO_INCREMENT PRIMARY KEY,
      message_id INT,
      subscriber_id INT,
      status ENUM('queued', 'sent', 'failed') DEFAULT 'queued',
      sent_at DATETIME DEFAULT NULL,
      error TEXT DEFAULT NULL,
      FOREIGN KEY (message_id) REFERENCES newsletter_messages(id),
      FOREIGN KEY (subscriber_id) REFERENCES newsletter_subscribers(id)
      );
       CREATE TABLE IF NOT EXISTS " . $prefix . "newsletter_settings
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255) NOT NULL,
      value LONGTEXT NOT NULL) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
       INSERT INTO " . $prefix . "newsletter_settings
      (name, value )
      VALUES ('confirmation', '0');";

// the data of the parent item of the menu

$menu_link = [[
      'link' => 'newsletter',
      'label' => 'Newsletter',
      'icon' => 'envelope-check-fill',
      'child' => [
            [
                  'link' => 'addEmail',
                  'label' => 'Create a new email',
                  'icon' => 'envelope-plus-fill',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'editEmail',
                  'label' => 'Edit an email',
                  'icon' => 'envelope-open-fill',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'allEmails',
                  'label' => 'All email',
                  'icon' => 'envelope-fill',
                  'show_menu' => '1'
            ],
            [
                  'link' => 'allSubscribers',
                  'label' => 'Manage subscribers',
                  'icon' => 'people-fill',
                  'show_menu' => '1'
            ],
            [
                  'link' => 'addSubscriber',
                  'label' => 'Add subscriber',
                  'icon' => 'person-plus-fill',
                  'show_menu' => '0'
            ],
            [
                  'link' => 'editSubscriber',
                  'label' => 'Edit subscriber',
                  'icon' => 'person-fill',
                  'show_menu' => '0'
            ],            
            [
                  'link' => 'allNewsletterSettings',
                  'label' => 'Newsletter Settings',
                  'icon' => 'gear-fill',
                  'show_menu' => '1'
            ],

      ]
]];

$query_drop_table = "DROP TABLE  " . $prefix . "table_name, " . $prefix . "second_table_name";
