<?php
	$url = explode(".", $_SERVER['SERVER_NAME']);

	$website = "";
	$new_url = "";

	if ($url[0] == "www") {
		$website = implode(".", $url);
		array_shift($url);
		$new_url = implode(".", $url);
	} else {
		$new_url = implode(".", $url);
		array_unshift($url, "www");
		$website = implode(".", $url);
	}

	if (!is_file('core/site.php')) {
		$file_handle = fopen('core/site.php', 'w');
		fwrite($file_handle, '<?php');
		fwrite($file_handle, "\n");
		fwrite($file_handle, '$site=array("' . $website . '","' . $new_url . '");');
		fwrite($file_handle, "\n");
		fwrite($file_handle, '?>');
	}

	chmod('core/site.php', 0777);