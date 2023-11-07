<?php

// plugin information

$pluginname = "relations" ;
$description = "Create and manage relations and speakers in conventions" ;
$link_parent = "relations" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS  ".$prefix."relations (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      relations_name VARCHAR(255) NOT NULL,
      date DATETIME NOT NULL,
      start_time TIME NOT NULL,
      end_time TIME NOT NULL,
      location INT(5) NOT NULL,
      speakers_id TEXT NOT NULL,
      announcer_id TEXT,
      active INT(5) DEFAULT 0,
      details TEXT DEFAULT NULL,
      details_opt TEXT DEFAULT NULL);
   CREATE TABLE IF NOT EXISTS  ".$prefix."speakers (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      speakers_name VARCHAR(255) NOT NULL,
      avatar VARCHAR(255) DEFAULT 'default.png',
      description TEXT,
      details TEXT DEFAULT NULL,
      details_opt TEXT DEFAULT NULL);
   CREATE TABLE IF NOT EXISTS  ".$prefix."speakers_doc (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      speakers_doc_name VARCHAR(255) NOT NULL,
      label VARCHAR(255) NOT NULL,
      speaker_id INT(5) NOT NULL); 
   CREATE TABLE IF NOT EXISTS  ".$prefix."relations_speakers_doc (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      relation_id INT(5) NOT NULL,
      speaker_id INT(5) NOT NULL,
      speaker_doc_id INT(5) NOT NULL);";

$parent_table=[['link'=>'relations',
                  'label'=>'Relations',
                  'icon'=>'person-video3']];

$child_table=[['link'=>'allRelations',
                'label'=>'All relations',
                'icon'=>'window-fullscreen'],
                ['link'=>'addRelation',
                'label'=>'Add a relation',
                'icon'=>'window-plus'],
                ['link'=>'allSpeakers',
                'label'=>'All speakers',
                'icon'=>'person-vcard'],
                ['link'=>'addSpeaker',
                'label'=>'Add a new speaker',
                'icon'=>'person-plus-fill'],
               ];

$query_drop_table = "DROP TABLE  ".$prefix."relations, ".$prefix."speakers, ".$prefix."speakers_doc, ".$prefix."relations_speakers_doc;";

?>