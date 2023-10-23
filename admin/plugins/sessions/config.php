<?php

// plugin information

$pluginname = "sessions" ;
$description = "Create and manage sessions and speakers in conventions" ;
$link_parent = "sessions" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS  ".$prefix."sessions (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      sessions_name VARCHAR(255) NOT NULL,
      location_id INT(5) NOT NULL,
      date DATETIME NOT NULL,
      start_time TIME NOT NULL,
      end_time TIME NOT NULL,
      people_id TEXT NOT NULL,
      relations_id TEXT NOT NULL,
      active INT(5) DEFAULT 0,
      question_active INT(5) DEFAULT 0,
      details TEXT DEFAULT NULL,
      details_opt TEXT DEFAULT NULL);
   CREATE TABLE IF NOT EXISTS  ".$prefix."location (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      location_name VARCHAR(255) NOT NULL);
   CREATE TABLE IF NOT EXISTS  ".$prefix."people (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      people_name VARCHAR(255) NOT NULL,
      avatar VARCHAR(255) DEFAULT 'default.png',
      description TEXT,
      details TEXT DEFAULT NULL,
      details_opt TEXT DEFAULT NULL);
   CREATE TABLE IF NOT EXISTS  ".$prefix."people_cat (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      people_cat_name VARCHAR(255) NOT NULL);
   CREATE TABLE IF NOT EXISTS  ".$prefix."people_cat_id (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      people_id INT(5) NOT NULL,
      cat_id INT(5) NOT NULL);
   INSERT INTO ".$prefix."people_cat
      (id, people_cat_name) 
      VALUES ('1','Chairperson');
   INSERT INTO ".$prefix."people_cat
      (id, people_cat_name) 
      VALUES ('2','Expert');
   INSERT INTO ".$prefix."people_cat
      (id, people_cat_name) 
      VALUES ('3','Announcer');";

$parent_table=[['link'=>'sessions',
                  'label'=>'Sessions',
                  'icon'=>'person-video3']];

$child_table=[['link'=>'allSessions',
                'label'=>'All sessions',
                'icon'=>'window-dock'],
                ['link'=>'addSession',
                'label'=>'Add a new session',
                'icon'=>'window-plus'],
                ['link'=>'allPeople',
                'label'=>'All announcer',
                'icon'=>'person-vcard'],
                ['link'=>'addPeople',
                'label'=>'Add a new announcer',
                'icon'=>'person-plus-fill'],
                ['link'=>'allLocations',
                'label'=>'All locations',
                'icon'=>'pin-map-fill'],
               ];

$query_drop_table = "DROP TABLE  ".$prefix."sessions, ".$prefix."location, ".$prefix."people, ".$prefix."people_cat,".$prefix."people_cat_id;";

?>