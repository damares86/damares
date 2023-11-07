<?php

// plugin information

$pluginname = "questions" ;
$description = "Post questions during a session" ;
$link_parent = "questions" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS  ".$prefix."questions (
      id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      session_id INT(5) NOT NULL,
      account_id INT(5) NOT NULL,
      question TEXT,
      approved INT(1) DEFAULT 0);";

$parent_table=[['link'=>'allQuestions',
                  'label'=>'Questions',
                  'icon'=>'question-square']];


$query_drop_table = "DROP TABLE  ".$prefix."questions";

?>