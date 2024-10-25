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
	
}else if($op == 'rm'){
	
	
	foreach (glob($plugin_dir . 'frontend/*') as $row) {
		$item = pathinfo($row);

		if (!unlink($frontend_dir . $item['basename'])) {
			$error++;
		}
	}
	
}

require "config.php";
