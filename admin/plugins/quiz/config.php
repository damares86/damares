<?php

// plugin information

$pluginname = "quiz" ;
$description = "Create and manage quiz with variable number of question and score management" ;
$link_parent = "quiz" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS  ".$prefix."quiz (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      quiz_name VARCHAR(255) NOT NULL,
      counter INT (2) NOT NULL, 
      active INT(1) DEFAULT 0);
      CREATE TABLE IF NOT EXISTS  ".$prefix."quiz_scores (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      quiz_id INT(5) NOT NULL,
      winner_id INT(5) NOT NULL);
      CREATE TABLE IF NOT EXISTS  ".$prefix."quiz_relation (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      quiz_id INT(5) NOT NULL,
      relation_id INT(5) NOT NULL);";

$parent_table=[['link'=>'quiz',
                  'label'=>'Quiz',
                  'icon'=>'trophy-fill']];

$child_table=[['link'=>'allQuiz',
                'label'=>'All quiz',
                'icon'=>'patch-question'],
                ['link'=>'addQuiz',
                'label'=>'Add a new quiz',
                'icon'=>'patch-plus']
               ];

$query_drop_table = "DROP TABLE  ".$prefix."quiz, ".$prefix."quiz_scores, ".$prefix."quiz_relation;";

?>