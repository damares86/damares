<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


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

        require "../plugins/$name[0]/config.php";

        $plugin->pluginname = $link_parent ;
        $plugin->description = $description ;

        if($plugin->insert(['pluginname','description'])){
          header("Location: ../index.php?p=allPlugins&msg=pluginUploadSucc");
          exit;
        }else{
          header("Location: ../index.php?p=allPlugins&err=pluginDbErr");
          exit;   
        }
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
  if($query_create_table){
    if(!$db->query($query_create_table)){
      $error++ ;
    }
  }

  if($parent_table){
    for($i=0;$i<count($parent_table);$i++){
      $section->link=$parent_table[$i]['link'];
      $section->label=$parent_table[$i]['label'];
      $section->icon=$parent_table[$i]['icon'];
      
      if(!$section->insertParent()){
        $error++;
      }
      
    }
  }


  if($child_table){
    
    $row = $section->showByLink($link_parent,"sectionParent");

    for($i=0;$i<count($child_table);$i++){
      $section->parent_id = $row['id'] ;
      
      $section->link=$child_table[$i]['link'];
      $section->label=$child_table[$i]['label'];
      $section->icon=$child_table[$i]['icon'];

      if(!$section->insertChild()){
        $error++;
      }

    }
    
  }
  
  if(!$db->query("UPDATE ".$prefix."plugins 
    SET 
    installed = 1,
    active = 1 WHERE pluginname = '".$row['link']."'")){
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
  foreach (glob("$path/settings/*") as $row) {
    $item=pathinfo($row);

    if(copy($path.'/settings/'.$item['basename'].'', '../inc/func/'.$item['basename'].'')){
        chmod('../inc/func/'.$item['basename'].'',0777);
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

  
  // copy manual files
  foreach (glob("$path/manual/*") as $row) {
    $item=pathinfo($row);
    
    if(copy($path.'/manual/'.$item['basename'].'', '../manual/'.$item['basename'].'')){
      chmod('../manual/'.$item['basename'].'',0777);
    }else{
      $error++;
    }
  }

    // copy frontend files
    foreach (glob("$path/frontend/*") as $row) {
      $item=pathinfo($row);
      
      if(copy($path.'/frontend/'.$item['basename'].'', '../../'.$item['basename'].'')){
        chmod('../../'.$item['basename'].'',0777);
      }else{
        $error++;
      }
    }

    // copy uploads files
    foreach (glob("$path/uploads/*") as $row) {
      $item=pathinfo($row);
      
      if(copy($path.'/uploads/'.$item['basename'].'', '../uploads/'.$item['basename'].'')){
        chmod('../uploads/'.$item['basename'].'',0777);
      }else{
        $error++;
      }
    }
    
  
  unlink("../inc/class_initialize.php") ;
  if($error==0){
    header("Location: ../index.php?p=allPlugins&msg=pluginAdd");
    exit;
  }else{
    header("Location: ../index.php?p=allPlugins&err=pluginAddErr");
    exit;
  }

} else if($op == "dis"){

  $error = 0 ;

  $pluginId = filter_input(INPUT_GET,'idPlugin');
  $plugin->id = $pluginId ;
  $stmt = $plugin-> showAllWhere('id',['id']);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  extract($row);
  $pluginname = $row['pluginname'];

  if(!$db->query("UPDATE ".$prefix."plugins SET active = 0 WHERE pluginname = '$pluginname'")){
    $error++;
  }
  
  if($child_table){
    for($i=0;$i<count($child_table);$i++){
  
      $section->link=$child_table[$i]['link'];
   
      if(!$section->deleteByLink("sectionChild")){
        $error++;
      }
  
    }
    
  }
  
  if($parent_table){
    for($i=0;$i<count($parent_table);$i++){
      $section->link=$parent_table[$i]['link'];
  
      if(!$section->deleteByLink("sectionParent")){
        $error++;
      }
  
    }
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
if($query_drop_table){
  if(!$db->query($query_drop_table)){
    $error++;
  }
}

if($child_table){
  for($i=0;$i<count($child_table);$i++){

    $section->link=$child_table[$i]['link'];
 
    if(!$section->deleteByLink("sectionChild")){
      $error++;
    }
    
  }
  
}

if($parent_table){
  for($i=0;$i<count($parent_table);$i++){
    $section->link=$parent_table[$i]['link'];
    
    if(!$section->deleteByLink("sectionParent")){
      $error++;
    }

  }
}


$plugin->id = filter_input(INPUT_GET,'idPlugin');
$plugin->installed = 0 ;
$plugin->active = 0 ;

if(!$plugin->update(['installed','active'],'id')){
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

  // remove inc/func files
  foreach (glob("$path/inc/func/*") as $row) {
    $item=pathinfo($row);

    if(!unlink('../inc/func/'.$item['basename'].'')){
        $error++;
    }

  }

    // remove setting files
    foreach (glob("$path/settings/*") as $row) {
      $item=pathinfo($row);
  
      if(!unlink('../inc/func/'.$item['basename'].'')){
          $error++;
      }
    }
  

    // remove manual files
    foreach (glob("$path/manual/*") as $row) {
      $item=pathinfo($row);
  
      if(!unlink('../manual/'.$item['basename'].'')){
          $error++;
      }
    }

  $scan = scandir($path.'/locale');
  $exclude = array('..', '.');
  foreach($scan as $folder) {
     if (is_dir("$path/locale/$folder") && !in_array($folder,$exclude)) {
          // copy locale files
        foreach (glob("$path/locale/$folder/*") as $row) {
          $item=pathinfo($row);
          
          if(!unlink('../locale/'.$folder.'/'.$item['basename'].'')){
            
              $error++;
          }
        }
     }
  }

  // remove frontend files
  foreach (glob("$path/frontend/*") as $row) {
    $item=pathinfo($row);

    if(!unlink('../../'.$item['basename'].'')){
        $error++;
    }
  }

    // remove uploads files
    foreach (glob("$path/uploads/*") as $row) {
      $item=pathinfo($row);
  
      if(!unlink('../uploads/'.$item['basename'].'')){
          $error++;
      }
    }


  unlink("../inc/class_initialize.php") ;
  
  if($error==0){
    header("Location: ../index.php?p=allPlugins&msg=pluginRm");
    exit;
  }else{
    header("Location: ../index.php?p=allPlugins&err=pluginRmErr");
    exit;
  }

}

?>