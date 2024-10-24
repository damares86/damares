<?php

$plugin_dir = '../plugins/mini_cms/';
$template_dir = '../template/';
$frontend_dir = '../../';
$json_dir = '../inc/pages/';
$menu_dir = '../inc/menu/';

if ($op == 'add') {

	if (!is_dir($template_dir)) {
		$oldmask = umask(0);
		mkdir($template_dir, 0777, true);
		umask($oldmask);
	}


	if (!is_dir($json_dir)) {
		$oldmask = umask(0);
		mkdir($json_dir, 0777, true);
		umask($oldmask);
	}

	// copy template files
	if ($common->copyDirectory($plugin_dir . 'template/', $template_dir)) {
		$common->chmod_R($template_dir, 0777);
	} else {
		$error++;
	}

	// copy frontend files
	if ($common->copyDirectory($plugin_dir . 'frontend/assets/', $frontend_dir)) {
		$common->chmod_R($frontend_dir, 0777);
	} else {
		$error++;
	}

	// copy frontend files
	if ($common->copyDirectory($plugin_dir . 'frontend/uploads/', $frontend_dir)) {
		$common->chmod_R($frontend_dir, 0777);
	} else {
		$error++;
	}

	if (copy($plugin_dir . 'misc/menu/menu.json', $menu_dir . 'menu.json')) {
		chmod($menu_dir . 'menu.json', 0777);
	} else {
		$error++;
	}

	foreach (glob($plugin_dir . 'misc/pages_file/') as $row) {
		$item = pathinfo($row);

		if (copy($plugin_dir . 'misc/pages_file/' . $item['basename'] . '', $frontend_dir . $item['basename'])) {
			chmod($frontend_dir . $item['basename'], 0777);
		} else {
			$error++;
		}
	}

	foreach (glob($plugin_dir . 'misc/pages_json/') as $row) {
		$item = pathinfo($row);

		if (copy($plugin_dir . 'misc/pages_json/' . $item['basename'] . '', $json_dir . $item['basename'])) {
			chmod($json_dir . $item['basename'], 0777);
		} else {
			$error++;
		}
	}
	
} else if ($op == 'rm') {

	$luna->rmdir_recursive($template_dir);
	$luna->rmdir_recursive($json_dir);
	$luna->rmdir_recursive($menu_dir);
	$luna->rmdir_recursive($frontend_dir . 'assets/');
	$luna->rmdir_recursive($frontend_dir . 'uploads/');
}
require "config.php";
