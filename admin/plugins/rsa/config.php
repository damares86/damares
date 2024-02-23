<?php

// plugin information

$pluginname = "rsa" ;
$description = "Gestione Ordini Farmaci RSA" ;
$link_parent = "rsa" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS ".$prefix."pazienti
      ( id INT ( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      cognome VARCHAR(255) NOT NULL,
      nome VARCHAR(255) NOT NULL);
      CREATE TABLE IF NOT EXISTS ".$prefix."farmaci
      ( id INT ( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      principio VARCHAR(255) NOT NULL,
      cpr_box INT(10) NOT NULL);
      CREATE TABLE IF NOT EXISTS ".$prefix."pazientiFarmaci
      ( id INT ( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      id_pazienti INT(10) NOT NULL,
      id_farmaci INT(10) NOT NULL,
      cpr FLOAT NOT NULL,
      magazzino INT(10) DEFAULT 0);";

$parent_table=[['link'=>'allPazienti',
                  'label'=>'Pazienti',
                  'icon'=>'person-vcard'],
            ['link'=>'allFarmaci',
                  'label'=>'Elenco farmaci',
                  'icon'=>'capsule'],
            ['link'=>'addOrdini',
                  'label'=>'Calcola un ordine',
                  'icon'=>'box-seam']];

$query_drop_table = "DROP TABLE  ".$prefix."pazienti, ".$prefix."farmaci, ".$prefix."pazientiFarmaci";

?>