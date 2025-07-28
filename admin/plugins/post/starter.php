<?php

// here it's possibile to add some extra operations for the installation
$plugin_dir = '../plugins/post/';
$frontend_dir = '../../';

require '../inc/class_initialize.php' ;

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

		$mc->table = 'mc_pages';
		$mc->page_name = 'blog';
		$mc->no_del = 1;
		$mc->layout = 'default';
		$mc->header = 1;
		$mc->header_media = 'visual.jpg';
		$mc->use_name = 1;
		$mc->use_desc = 1;
		$mc->counter = 1;

		if (!$mc->insert(['page_name', 'no_del', 'layout', 'header', 'header_media', 'use_name', 'use_desc', 'counter'])) {
			$error++;
		} else {
			$mc->table = "mc_pages";
			$stmt = $mc->showAllLimitDesc('id', 1);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			extract($row);

			$pages_json = file_get_contents('../inc/menu/menu.json');
			$pages_data = json_decode($pages_json, true);
			$pages_data['nomenu'][] = "" . $row['id'] . "";
			$newpages_data = json_encode($pages_data, JSON_PRETTY_PRINT);
			file_put_contents('../inc/menu/menu.json', $newpages_data);
		}
	}
} else if ($op == 'rm') {


	foreach (glob($plugin_dir . 'frontend/*') as $row) {
		$item = pathinfo($row);

		if (!unlink($frontend_dir . $item['basename'])) {
			$error++;
		}
	}

	$plugin->pluginname = "mini_cms";

	if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {
		$mc->table = 'mc_pages';
		$mc->page_name = 'blog';
		if(!$mc->delete('page_name')){
			$error++;
		}else{
			// rimozione id da menu
			// e se ha child?
			
		}


	}
}

require "config.php";
