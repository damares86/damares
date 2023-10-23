<?php
        $arr_tot=array('account' => 15);
        $arr_tot[]=$_POST['total'];
 		$file='test.json';
         $json=json_encode($arr_tot);
 
         file_put_contents($file, $json, FILE_APPEND);
        chmod($file,0777);
         