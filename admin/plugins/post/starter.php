<?php

// here it's possibile to add some extra operations for the installation
$plugin_dir = '../plugins/post/';
$frontend_dir = '../../';

if ($op == 'add') {

	foreach (glob($plugin_dir . 'frontend/*') as $row) {
		$item = pathinfo($row);

		if (copy($plugin_dir . 'frontend/' . $item['basename'] . '', $frontend_dir . $item['basename'])) {
			chmod($frontend_dir . $item['basename'], 0777);
		} else {
			$error++;
		}
	}

	$plugin->pluginname = "mini_cms";

	if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {

		$mc->table = 'mc_pages' ;
		$mc->page_name = 'blog' ;
		$mc->no_del = 1 ;
		$mc->layout = 'default' ;
		$mc->header = 1 ;
		$mc->header_media = 'visual.jpg' ;
		$mc->use_name = 1 ;
		$mc->use_desc = 1 ;
		$mc->counter = 1 ;

		if(!$mc->insert(['page_name', 'no_del', 'layout', 'header', 'header_media', 'use_name', 'use_desc', 'counter'])) {
			$error++ ;
		}
		
	}
	
	// aggiunta pagina nel menu

}else if($op == 'rm'){
	
	
	foreach (glob($plugin_dir . 'frontend/*') as $row) {
		$item = pathinfo($row);

		if (!unlink($frontend_dir . $item['basename'])) {
			$error++;
		}
	}
	
}

require "config.php";
