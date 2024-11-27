<?php

// here it's possibile to add some extra operations for the installation

if ($op == 'add') {

	// operations during the installation
    $setting->name = 'role_redirect' ;
    $setting->value = 1 ;
    if($setting->updateValue()){
        $plugin->id = $idPlugin ;
        $plugin->installed = 1 ;
        $plugin->active = 1 ;
        $plugin->update(['installed','active'],'id');
        header("Location: ../index.php?p=allPlugins&msg=pluginAdd");
        exit;
    }else{
        header("Location: ../index.php?p=allPlugins&err=pluginAddErr");
        exit;
    }
	
}else if($op == 'rm'){
	
	// operations during the remove
    $setting->name = 'role_redirect' ;
    $setting->value = 0 ;
    if ($setting->updateValue()) {
        $plugin->id = $idPlugin ;
        $plugin->installed = 0 ;
        $plugin->active = 0 ;
        $plugin->update(['installed','active'],'id');
        header("Location: ../index.php?p=allPlugins&msg=pluginRm");
        exit;
      } else {
        header("Location: ../index.php?p=allPlugins&err=pluginRmErr");
        exit;
      }
}

require "config.php";
