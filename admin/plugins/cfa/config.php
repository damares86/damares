<?php

// plugin information

$pluginname = "cfa" ;
$description = "CFA Manager" ;
$link_parent = "cfa" ;

// query to create and drop the table

// REMEMBER: add all pages to section tables and also settings pages

$query_create_table = "CREATE TABLE IF NOT EXISTS ".$prefix."collaboratori
      ( id INT ( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      nome VARCHAR(255) NOT NULL,
      cognome VARCHAR(255) NOT NULL,
      sede_legale VARCHAR(255) NOT NULL,
      sede_operativa VARCHAR(255) NOT NULL,
      telefono VARCHAR(15) NOT NULL,
      cellulare VARCHAR(15) NOT NULL,
      email VARCHAR(255) NOT NULL,
      pec VARCHAR(255) NOT NULL,
      codice_fiscale VARCHAR(255) NOT NULL,
      p_iva VARCHAR(255) NOT NULL,
      ritenuta_acconto INT(10) NOT NULL,
      iban VARCHAR(27) NOT NULL,
      banca VARCHAR(255) NOT NULL,
      provvigioni_dare VARCHAR(255) NOT NULL,
      provvigioni_avere VARCHAR(255) NOT NULL,      
      details TEXT DEFAULT NULL,
      details_opt TEXT DEFAULT NULL);
      CREATE TABLE IF NOT EXISTS ".$prefix."compagnie
      ( id INT ( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      nome VARCHAR(255) NOT NULL,
      sede_legale VARCHAR(255) NOT NULL,
      netto INT(10) NOT NULL,
      imponibile INT(10) NOT NULL,
      lordo INT(10) NOT NULL,
      spese INT(10) NOT NULL,
      provv INT(10) NOT NULL,      
      details TEXT DEFAULT NULL,
      details_opt TEXT DEFAULT NULL);
      CREATE TABLE IF NOT EXISTS ".$prefix."contraente
      ( id INT ( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      ragione_sociale VARCHAR(255) NOT NULL,
      nome VARCHAR(255) NOT NULL,
      cognome VARCHAR(255) NOT NULL,
      via VARCHAR(255) NOT NULL,
      citta VARCHAR(255) NOT NULL,
      cap VARCHAR(6) NOT NULL,
      codice_fiscale VARCHAR(16) NOT NULL,
      p_iva VARCHAR(255) NOT NULL,
      telefono VARCHAR(15) NOT NULL,
      cellulare VARCHAR(15) NOT NULL,
      email VARCHAR(255) NOT NULL, 
      details TEXT DEFAULT NULL,
      details_opt TEXT DEFAULT NULL);
      CREATE TABLE IF NOT EXISTS ".$prefix."beneficiario
      ( id INT ( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      ragione_sociale VARCHAR(255) NOT NULL,
      via VARCHAR(255) NOT NULL,
      citta VARCHAR(255) NOT NULL,
      cap VARCHAR(6) NOT NULL,
      codice_fiscale VARCHAR(16) NOT NULL,
      p_iva VARCHAR(255) NOT NULL,
      details TEXT DEFAULT NULL,
      details_opt TEXT DEFAULT NULL);
      CREATE TABLE IF NOT EXISTS ".$prefix."polizze
      ( id INT ( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      id_collaboratore INT(10) NOT NULL,
      id_compagnia INT(10) NOT NULL,
      numero INT(30) NOT NULL,
      tipologia VARCHAR(255) NOT NULL,
      id_contraente INT(10) NOT NULL,
      id_beneficiario INT(10) NOT NULL,
      descrizione TEXT,
      importo_gara INT(10) NOT NULL,
      massimale INT(20) NOT NULL,
      st DATE NOT NULL,
      et DATE NOT NULL,
      id_calendar_cat INT(5) DEFAULT NULL,
      consulenza INT(20) NOT NULL,
      incasso_data DATE NOT NULL,
      incasso_mod VARCHAR(255) NOT NULL,
      pagato INT(20) NOT NULL);
      ";

$parent_table=[['link'=>'allCollaboratori',
                  'label'=>'Collaboratori',
                  'icon'=>'person-vcard'],
            ['link'=>'allPolizze',
                  'label'=>'Polizze',
                  'icon'=>'file-post'],
            ['link'=>'allUtili',
                  'label'=>'Utili',
                  'icon'=>'bank'],];

// $child_table=[['link'=>'allCustomers',
//                 'label'=>'All Customers',
//                 'icon'=>'people-fill'],
//                 ['link'=>'addCustomer',
//                 'label'=>'Add a customer',
//                 'icon'=>'person-plus-fill']
//                ];

$query_drop_table = "DROP TABLE  ".$prefix."collaboratori, ".$prefix."compagnie, ".$prefix."contraente, ".$prefix."beneficiario, ".$prefix."polizze";

?>