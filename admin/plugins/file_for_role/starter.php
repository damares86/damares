<?php

require "config.php" ;

$op = filter_input(INPUT_GET,"op");


if($op=="add"){
  
  // create table

  // $db->query($query_create_table);
                
  // $db->query("UPDATE ".$prefix."plugins
  //             SET installed = 1 WHERE pluginname = $pluginname");
  
  $error = 0 ;


  // copy assets files
  foreach (glob("assets/*") as $row) {
    $item=pathinfo($row);

    if(copy('assets/'.$item['basename'].'', '../../assets/css/'.$item['basename'].'')){
        chmod('../../assets/css/'.$item['basename'].'',0777);
    }else{
        $error++;
    }
  }
  
  // copy class files
  foreach (glob("class/*") as $row) {
    $item=pathinfo($row);

    if(copy('class/'.$item['basename'].'', '../../class/'.$item['basename'].'')){
        chmod('../../class/'.$item['basename'].'',0777);
    }else{
        $error++;
    }
  }

  // copy core files
  foreach (glob("core/*") as $row) {
    $item=pathinfo($row);

    if(copy('core/'.$item['basename'].'', '../../core/'.$item['basename'].'')){
        chmod('../../core/'.$item['basename'].'',0777);
    }else{
        $error++;
    }
  }

  // copy inc files
  foreach (glob("inc/*") as $row) {
    $item=pathinfo($row);

    if(copy('inc/'.$item['basename'].'', '../../inc/'.$item['basename'].'')){
        chmod('../../inc/'.$item['basename'].'',0777);
    }else{
        $error++;
    }
  }

  // copy inc/alert files
  foreach (glob("inc/alert/*") as $row) {
    $item=pathinfo($row);

    if(copy('inc/alert/'.$item['basename'].'', '../../inc/alert/'.$item['basename'].'')){
        chmod('../../inc/alert/'.$item['basename'].'',0777);
    }else{
        $error++;
    }
  }

  // copy inc/func files
  foreach (glob("inc/func/*") as $row) {
    $item=pathinfo($row);

    if(copy('inc/func/'.$item['basename'].'', '../../inc/func/'.$item['basename'].'')){
        chmod('../../inc/func/'.$item['basename'].'',0777);
    }else{
        $error++;
    }
  }

  $scan = scandir('locale');
  $exclude = array('..', '.');
  foreach($scan as $foolder) {
     if (is_dir("locale/$folder") && !in_array($folder,$exclude)) {

          // copy locale files
        foreach (glob("locale/$folder/*") as $row) {
          $item=pathinfo($row);

          if(copy('locale/'.$folder.'/'.$item['basename'].'', '../../locale/'.$folder.'/'.$item['basename'].'')){
              chmod( '../../locale/'.$folder.'/'.$item['basename'].'',0777);
          }else{
              $error++;
          }
        }
     }
  }
  

    // COPY ALL FILES

} else if($op=="remove"){


///////////////////////////////////////////////////////////////
                
// REMOVE

$db->query("DROP TABLE ".$prefix.$table_name."");

$db->query("UPDATE ".$prefix."plugins
                SET installed = 0 WHERE pluginname = $pluginname");

    // DELETE ALL FILES

}
