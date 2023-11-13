<?php

// variabili per la visualizzazione negli "if...else" dell'index

// titolo e descrizione per la tabella dei plugin

$plugin_name = "Portfolio";
$description = "It creates a portfolio and manages your projects.";
$link_parent="portfolio";

$sidebar_icon="fas fa-fw fa-image";
$sidebar_title = 'side_port';
$sidebar_sub_show_title = 'side_project';
$sidebar_sub_show_link ="index.php?man=portfolio&op=show";
$sidebar_sub_add_title = 'side_project_cat';
$sidebar_sub_add_link ="index.php?man=catPortfolio&op=show";

$query_create_table = "CREATE TABLE IF NOT EXISTS ".$prefix."portfolio
( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    project_title VARCHAR(255) NOT NULL,
    main_img VARCHAR(255) NOT NULL DEFAULT 'visual.jpg',
    description text COLLATE utf8_unicode_ci NOT NULL,
    client VARCHAR(255) NOT NULL,
    completed date NOT NULL,
    category TEXT(255) NULL,
    link VARCHAR(255) NOT NULL);
    CREATE TABLE IF NOT EXISTS ".$prefix."portfolio_categories
    ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL);
    INSERT INTO ".$prefix."portfolio_categories
    (id, category_name)
    VALUES ('1','Misc')";

$parent_table=[['link'=>'portfolio',
                  'label'=>'Portfolio',
                  'icon'=>'image']];

$child_table=[['link'=>'allPortfolio',
                'label'=>'All projects',
                'icon'=>'images'],
                ['link'=>'addPortfolio',
                'label'=>'Add a project',
                'icon'=>'patch-plus'],
                ['link'=>'addCatPortfolio',
                'label'=>'All categories',
                'icon'=>'tag']
               ];

$query_drop_table = "DROP TABLE  ".$prefix."portfolio, ".$prefix."portfolio_categories";