<?php

$template_dir = '../template/';
$frontend_dir = '../../';
$json_dir = '../inc/pages/';

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
	if ($common->copyDirectory('../plugins/mini_cms/template/', $template_dir)) {
		$common->chmod_R($template_dir, 0777);
	} else {
		$error++;
	}

	// copy template files
	if ($common->copyDirectory('../plugins/mini_cms/frontend/assets/', $frontend_dir)) {
		$common->chmod_R($frontend_dir, 0777);
	} else {
		$error++;
	}

	// copy template files
	if ($common->copyDirectory('../plugins/mini_cms/frontend/uploads/', $frontend_dir)) {
		$common->chmod_R($frontend_dir, 0777);
	} else {
		$error++;
	}

}else if($op == 'rm'){

	$luna->rmdir_recursive($template_dir) ;
	$luna->rmdir_recursive($json_dir) ;
	

}
require "config.php";