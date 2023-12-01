<?php

// plugin information

$pluginname = "calendar" ;
$description = "Manages events and shows in a calendar" ;
$link_parent = "Calendar" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS ".$prefix."calendar
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      event_id INT(5) NOT NULL,
      event_title VARCHAR(255) NOT NULL,
      event_start_date VARCHAR(255) NOT NULL,
      event_end_date VARCHAR(255) DEFAULT NULL)";

$parent_table=[['link'=>'calendar',
                  'label'=>'Calendar',
                  'icon'=>'calendar-week']];

$child_table=[['link'=>'addCalendarCat',
            'label'=>'Add an event category',
            'icon'=>'bookmark-plus']
            ];

$query_drop_table = "DROP TABLE  ".$prefix."calendar";

?>