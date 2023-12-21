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
      ragione_sociale_contraente VARCHAR(255) NOT NULL,
      nome_contraente VARCHAR(255) NOT NULL,
      cognome_contraente VARCHAR(255) NOT NULL,
      via_contraente VARCHAR(255) NOT NULL,
      citta_contraente VARCHAR(255) NOT NULL,
      cap_contraente VARCHAR(6) NOT NULL,
      codice_fiscale_contraente VARCHAR(16) NOT NULL,
      p_iva_contraente VARCHAR(255) NOT NULL,
      telefono_contraente VARCHAR(15) NOT NULL,
      cellulare_contraente VARCHAR(15) NOT NULL,
      email_contraente VARCHAR(255) NOT NULL, 
      details TEXT DEFAULT NULL,
      details_opt TEXT DEFAULT NULL);
      CREATE TABLE IF NOT EXISTS ".$prefix."beneficiario
      ( id INT ( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      ragione_sociale_beneficiario VARCHAR(255) NOT NULL,
      via_beneficiario VARCHAR(255) NOT NULL,
      citta_beneficiario VARCHAR(255) NOT NULL,
      cap_beneficiario VARCHAR(6) NOT NULL,
      codice_fiscale_beneficiario VARCHAR(16) NOT NULL,
      p_iva_beneficiario VARCHAR(255) NOT NULL,
      details TEXT DEFAULT NULL,
      details_opt TEXT DEFAULT NULL);
      CREATE TABLE IF NOT EXISTS ".$prefix."polizze
      ( id INT ( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      id_collaboratore INT(10) NOT NULL,
      id_compagnia INT(10) NOT NULL,
      numero INT(30) NOT NULL,
      tipologia VARCHAR(255) NOT NULL,
      id_contraente INT(10) DEFAULT NULL,
      id_beneficiario INT(10) DEFAULT NULL,
      descrizione TEXT,
      importo_gara INT(10) NOT NULL,
      massimale INT(20) NOT NULL,
      st DATE NOT NULL,
      et DATE NOT NULL,
      id_calendar_cat INT(5) DEFAULT NULL,
      consulenza INT(20) NOT NULL,
      incasso_data DATE NOT NULL,
      incasso_mod VARCHAR(255) NOT NULL,
      pagato INT(20) NOT NULL,
      broker INT(20) DEFAULT NULL);
      ";

$parent_table=[['link'=>'allCollaboratori',
                  'label'=>'Collaboratori',
                  'icon'=>'person-vcard'],
            ['link'=>'allCompagnie',
                  'label'=>'Compagnie',
                  'icon'=>'building'],
            ['link'=>'allPolizze',
                  'label'=>'Polizze',
                  'icon'=>'file-post'],
            ['link'=>'allContraenti',
                  'label'=>'Contraenti',
                  'icon'=>'person-fill-down'],
            ['link'=>'allBeneficiari',
                  'label'=>'Beneficiari',
                  'icon'=>'person-fill-up'],
            ['link'=>'allUtili',
                  'label'=>'Utili',
                  'icon'=>'bank'],];

$query_drop_table = "DROP TABLE  ".$prefix."collaboratori, ".$prefix."compagnie, ".$prefix."contraente, ".$prefix."beneficiario, ".$prefix."polizze";

?>