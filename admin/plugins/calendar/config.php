<?php

// plugin information

$pluginname = "calendar" ;
$description = "Manages events and shows in a calendar" ;
$link_parent = "Calendar" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS ".$prefix."calendar_cat
      ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      cat_name VARCHAR(255) NOT NULL,
      cat_color VARCHAR(7) DEFAULT '#008db1');
      INSERT INTO ".$prefix."calendar_cat
      (id, cat_name, cat_color)
      VALUES ('1','default','#008db1')";

$parent_table=[['link'=>'calendar',
                  'label'=>'Calendar',
                  'icon'=>'calendar-week']];

$child_table=[['link'=>'calendar',
            'label'=>'Show calendar',
            'icon'=>'calendar3'],
            ['link'=>'allCalendars',
            'label'=>'All calendars',
            'icon'=>'calendar2-range'],
            ['link'=>'addCalendar',
            'label'=>'Add a calendar',
            'icon'=>'calendar-plus']
            ];

$query_drop_table = "DROP TABLE  ".$prefix."calendar_cat";

?>