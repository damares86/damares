<?php

require __DIR__."/coreConfig.php";

if(filter_input(INPUT_POST,"new")){
  
  function chmod_R($path, $filemode) {
    if ( !is_dir($path) ) {
     return chmod($path, $filemode);
    }
    $dh = opendir($path);
    while ( $file = readdir($dh) ) {
     if ( $file != '.' && $file != '..' ) {
      $fullpath = $path.'/'.$file;
      if( !is_dir($fullpath) ) {
       if ( !chmod($fullpath, $filemode) ){
        return false;
       }
      } else {
       if ( !chmod_R($fullpath, $filemode) ) {
        return false;
       }
      }
     }
    }
    
    closedir($dh);
    
    if ( chmod($path, $filemode) ) {
     return true;
    } else {
     return false;
    }
   }

if($_FILES["zip_file"]["name"]) {
  $filename = $_FILES["zip_file"]["name"];
  $source = $_FILES["zip_file"]["tmp_name"];
    $type = $_FILES["zip_file"]["type"];
    
    $name = explode(".", $filename);
    $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
    foreach($accepted_types as $mime_type) {
        if($mime_type == $type) {
            $okay = true;
            break;
          } 
        }
        
        $continue = strtolower($name[1]) == 'zip' ? true : false;
        if(!$continue) {
          header("Location: ../index.php?p=allPlugins&msg=pluginUploadFormatErr");
          exit;
        }
        
        $path="../plugins/";
        if(!is_dir($path)){
          mkdir($path);
          chmod($path,0777);
        }

        $target_path = "../plugins/".$filename;  // change this to the correct site path
      if(move_uploaded_file($source, $target_path)) {
        $zip = new ZipArchive();
        $x = $zip->open($target_path);
        $folder="../plugins/";
        if ($x === true) {
          $zip->extractTo($folder); // change this to the correct site path
          $zip->close();
            
            chmod_R($folder,0777);

            unlink($target_path);
        }
        header("Location: ../index.php?p=allPlugins&msg=pluginUploadSucc");
        exit;
    } else {	
        header("Location: ../index.php?p=allPlugins&err=pluginUploadErr");
        exit;
    }
}
}

$op = filter_input(INPUT_GET,"op");

$idPlugin = filter_input(INPUT_GET,"idPlugin") ;
$plugin->id=$idPlugin ;
$pluginFolder = $plugin->showPluginnameById() ;

$path = "../plugins/$pluginFolder" ;

require "$path/starter.php" ;
$exclude = array('..', '.','alert','func','.gitkeep');



if($op=="add"){

  
  // create table

  $error = 0 ;
  
  if(!$db->query($query_create_table)){
    $error++ ;
  }
                
  if(!$db->query("UPDATE ".$prefix."plugins 
    SET 
    installed = 1,
    active = 1 WHERE pluginname = '$pluginname'")){
    $error++ ;
  }
  
  // copy assets files
  foreach (glob("$path/assets/*") as $row) {
    $item=pathinfo($row);

    if(copy($path.'/assets/'.$item['basename'].'', '../assets/css/'.$item['basename'].'')){
      chmod('../assets/css/'.$item['basename'].'',0777);
    }else{
      $error++;
    }
  }
  
  // copy class files
  foreach (glob("$path/class/*") as $row) {
    $item=pathinfo($row);
    
    if(copy($path.'/class/'.$item['basename'].'', '../class/'.$item['basename'].'')){
      chmod('../class/'.$item['basename'].'',0777);
    }else{
      $error++;
    }
  }
  
  // copy core files
  foreach (scandir("$path/core/") as $row) {
    $item=pathinfo($row);
    if(!in_array($item['basename'],$exclude)){
      if(copy($path.'/core/'.$item['basename'].'', ''.$item['basename'].'')){
        chmod(''.$item['basename'].'',0777);
      }else{
        $error++;
      }
    }
  }

  // copy inc files
  $scan = scandir($path.'/inc');

  foreach ($scan as $folder) {
    if(!in_array($folder, $exclude )){
      if(copy($path.'/inc/'.$folder.'', '../inc/'.$folder.'')){
        chmod('../inc/'.$folder.'',0777);
      }else{
        $error++;
      }
    }
  }


  // copy inc/alert files
  foreach (glob("$path/inc/alert/*") as $row) {
    $item=pathinfo($row);

    if(copy($path.'/inc/alert/'.$item['basename'].'', '../inc/alert/'.$item['basename'].'')){
        chmod('../inc/alert/'.$item['basename'].'',0777);
    }else{
        $error++;
    }
  }

  // copy inc/func files
  foreach (glob("$path/inc/func/*") as $row) {
    $item=pathinfo($row);

    if(copy($path.'/inc/func/'.$item['basename'].'', '../inc/func/'.$item['basename'].'')){
        chmod('../inc/func/'.$item['basename'].'',0777);
    }else{
        $error++;
    }
  }

  // copy inc/settings files
  foreach (glob("$path/inc/settings/*") as $row) {
    $item=pathinfo($row);

    if(copy($path.'/inc/settings/'.$item['basename'].'', '../inc/settings/'.$item['basename'].'')){
        chmod('../inc/settings/'.$item['basename'].'',0777);
    }else{
        $error++;
    }
  }
  $scan = scandir($path.'/locale');
  foreach($scan as $folder) {
     if (is_dir("$path/locale/$folder") && !in_array($folder,$exclude)) {

          // copy locale files
        foreach (glob("$path/locale/$folder/*") as $row) {
          $item=pathinfo($row);

          if(copy($path.'/locale/'.$folder.'/'.$item['basename'].'', '../locale/'.$folder.'/'.$item['basename'].'')){
          chmod( '../locale/'.$folder.'/'.$item['basename'].'',0777);
        }else{
              $error++;
          }
        }
     }
  }

  if($error==0){
    header("Location: ../index.php?p=allPlugins&msg=pluginAdd");
    exit;
  }else{
    header("Location: ../index.php?p=allPlugins&err=pluginAddErr");
    exit;
  }

} else if($op == "dis"){

  $error = 0 ;

  if(!$db->query("UPDATE ".$prefix."plugins SET active = 0 WHERE pluginname = '$pluginname'")){
    $error++;
  }
  
  if(!$db->query($query_disable)){
    $error++;
  }

  if($error==0){
    header("Location: ../index.php?p=allPlugins&msg=pluginDis");
    exit;
  }else{
    header("Location: ../index.php?p=allPlugins&err=pluginDisErr");
    exit;
  }

}else if($op=="rm"){
                
// REMOVE

$error=0;

if(!$db->query($query_drop_table)){
  $error++;
}

if(!$db->query("UPDATE ".$prefix."plugins SET installed = 0, active = 0 WHERE pluginname = '$pluginname'")){
  $error++;
}

    // DELETE ALL FILES

  // remove assets files
  foreach (glob("$path/assets/*") as $row) {
    $item=pathinfo($row);

    if(!unlink('../assets/css/'.$item['basename'].'')){
        $error++;
    }
  }

  // remove class files
  foreach (glob("$path/class/*") as $row) {
    $item=pathinfo($row);

    if(!unlink('../class/'.$item['basename'].'')){
        $error++;
    }
  }
  // remove core files
  foreach (glob("$path/core/*") as $row) {
    $item=pathinfo($row);
    
    if(!unlink(''.$item['basename'].'')){
      $error++;
    }
  }
  
  // remove inc files

  $scan = scandir($path.'/inc');

  foreach ($scan as $file) {
    if(!in_array($file, $exclude )){
      if(!unlink('../inc/'.$file.'')){
        $error++;
      }
    }
  }




  // remove inc/alert files
  foreach (glob("$path/inc/alert/*") as $row) {
    $item=pathinfo($row);

    if(!unlink('../inc/alert/'.$item['basename'].'')){
        $error++;
    }
  }

  // remove inc/func files
  foreach (glob("$path/inc/func/*") as $row) {
    $item=pathinfo($row);

    if(!unlink('../inc/func/'.$item['basename'].'')){
        $error++;
    }
  }

  $scan = scandir($path.'/locale');
  $exclude = array('..', '.');
  foreach($scan as $folder) {
     if (is_dir("$path/locale/$folder") && !in_array($folder,$exclude)) {
          print_r("Folder: $path/locale/$folder <br>") ;
          // copy locale files
        foreach (glob("$path/locale/$folder/*") as $row) {
          $item=pathinfo($row);
          print_r("File ".$item['basename']);
          if(!unlink('../locale/'.$folder.'/'.$item['basename'].'')){
              print_r("Error on ".$item['basename']);
              $error++;
          }
        }
     }
  }

  if($error==0){
    header("Location: ../index.php?p=allPlugins&msg=pluginRm");
    exit;
  }else{
    header("Location: ../index.php?p=allPlugins&err=pluginRmErr");
    exit;
  }

}

?>