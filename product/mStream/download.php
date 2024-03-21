<?php 

// require '../admin/phpDebug/src/Debug/Debug.php';   			// if not using composer

// $debug = new \bdk\Debug(array(
//     'collect' => true,
//     'output' => true,
// ));

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../../login.php?msg=noLog');
    exit;
}

$type=filter_input(INPUT_GET,"type");
$product=filter_input(INPUT_GET,"product");
$file=filter_input(INPUT_GET,"filename");
$product=strtolower($product);
$user=filter_input(INPUT_GET,"user");


  // download dei documenti

  if($file){
    $fileList = glob($product.'/'.$type.'/'.$file);
    foreach($fileList as $filename){

      if(is_file($filename)){
        $doc = $filename;
        $fp=fopen('download.log','a');
        fwrite($fp,"\n");
        fwrite($fp,$user." ".$product." ".$file." ".date("d/m/Y-H:i:s"));
        fclose($fp);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($doc).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($doc));
        readfile($doc);

      }   
    }
  } else{
    //$fileList = glob($product.'/*.txt'); //per test in locale
    $fileList = glob($product.'/'.$type.'/*.'.$type.'');
    foreach($fileList as $filename){
      if(is_file($filename)){
        $file = $filename;
        $deb=basename($file);
        $fp=fopen('download.log','a');
        fwrite($fp,"\n");
        fwrite($fp,$user." ".$product." ".$file." ".date("d/m/Y-H:i:s"));
        fclose($fp);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
      }   
    }
  }

  // download dei software
  
//   } else if($type=='software'){
//     //$fileList = glob($product.'/*.txt'); //per test in locale
//     $fileList = glob($product.'/*.deb');
//     foreach($fileList as $filename){
//       if(is_file($filename)){
//         $file = $filename;
//         $deb=basename($file);
//         $fp=fopen('download.log','a');
//         fwrite($fp,"\n");
//         fwrite($fp,$user." ".$deb." ".date("d/m/Y-H:i:s"));
//         fclose($fp);
//         header('Content-Description: File Transfer');
//         header('Content-Type: application/octet-stream');
//         header('Content-Disposition: attachment; filename="'.basename($file).'"');
//         header('Expires: 0');
//         header('Cache-Control: must-revalidate');
//         header('Pragma: public');
//         header('Content-Length: ' . filesize($file));
//         readfile($file);
//       }   
//     }
//   } else if($type=='ova'){
//     if($product=="dstream"){
//         $fileList = glob(''.$product.'/ova/*.ova');
//         foreach($fileList as $filename){
//           if(is_file($filename)){
//             $file = $filename;
//             $ova=basename($file);
//             $fp=fopen('download.log','a');
//             fwrite($fp,"\n");
//             fwrite($fp,$user." ".$ova." ".date("d/m/Y-H:i:s"));
//             fclose($fp);
//             header('Content-Description: File Transfer');
//             header('Content-Type: application/octet-stream');
//             header('Content-Disposition: attachment; filename="'.basename($file).'"');
//             header('Expires: 0');
//             header('Cache-Control: must-revalidate');
//             header('Pragma: public');
//             header('Content-Length: ' . filesize($file));
//             readfile($file);
//           }   
//       }
//     }else{
//       //$fileList = glob($product.'/*.txt'); //per test in locale
//         $fileList = glob('ova/*.ova');
//         foreach($fileList as $filename){
//           if(is_file($filename)){
//             $file = $filename;
//             $ova=basename($file);
//             $fp=fopen('download.log','a');
//             fwrite($fp,"\n");
//             fwrite($fp,$user." ".$ova." ".date("d/m/Y-H:i:s"));
//             fclose($fp);
//             header('Content-Description: File Transfer');
//             header('Content-Type: application/octet-stream');
//             header('Content-Disposition: attachment; filename="'.basename($file).'"');
//             header('Expires: 0');
//             header('Cache-Control: must-revalidate');
//             header('Pragma: public');
//             header('Content-Length: ' . filesize($file));
//             readfile($file);
//           }   
//       }
//     }
//   } else if($type=='mainframe'){

//     //$fileList = glob($product.'/*.txt'); //per test in locale
//     $fileList = glob($product.'/mainframe/'.$file);
//     foreach($fileList as $filename){
//       if(is_file($filename)){
//         $file = $filename;
//         $xmit=basename($file);
//         $fp=fopen('download.log','a');
//         fwrite($fp,"\n");
//         fwrite($fp,$user." ".$product."-".$xmit." ".date("d/m/Y-H:i:s"));
//         fclose($fp);
//         header('Content-Description: File Transfer');
//         // header('Content-Type: application/octet-stream');
//         header('Content-Disposition: attachment; filename="'.basename($file).'"');
//         header('Expires: 0');
//         header('Cache-Control: must-revalidate');
//         header('Pragma: public');
//         header('Content-Length: ' . filesize($file));
//         readfile($file);
//       }   
//     }
//   } else if($type=='fatpack'){

//     //$fileList = glob($product.'/*.txt'); //per test in locale
//     $fileList = glob($product.'/fatpack/*.bin');
//     foreach($fileList as $filename){
//       if(is_file($filename)){
//         $file = $filename;
//         $fatpack=basename($file);
//         $fp=fopen('download.log','a');
//         fwrite($fp,"\n");
//         fwrite($fp,$user." ".$fatpack." ".date("d/m/Y-H:i:s"));
//         fclose($fp);
//         header('Content-Description: File Transfer');
//         // header('Content-Type: application/octet-stream');
//         header('Content-Disposition: attachment; filename="'.basename($file).'"');
//         header('Expires: 0');
//         header('Cache-Control: must-revalidate');
//         header('Pragma: public');
//         header('Content-Length: ' . filesize($file));
//         readfile($file);
//       }   
//     }
//   } else if($type=='jar'){

//     //$fileList = glob($product.'/*.txt'); //per test in locale
//     $fileList = glob($product.'/jar/'.$file);
//     foreach($fileList as $filename){
//       if(is_file($filename)){
//         $file = $filename;
//         $jar=basename($file);
//         $fp=fopen('download.log','a');
//         fwrite($fp,"\n");
//         fwrite($fp,$user." ".$jar." ".date("d/m/Y-H:i:s"));
//         fclose($fp);
//         header('Content-Description: File Transfer');
//         // header('Content-Type: application/octet-stream');
//         header('Content-Disposition: attachment; filename="'.basename($file).'"');
//         header('Expires: 0');
//         header('Cache-Control: must-revalidate');
//         header('Pragma: public');
//         header('Content-Length: ' . filesize($file));
//         readfile($file);
//       }   
//     }
//   }
//   // else if($type=='patch'){

//   //   //$fileList = glob($product.'/*.txt'); //per test in locale
//   //   $fileList = glob($product.'/patch/'.$file);
//   //   foreach($fileList as $filename){
//   //     if(is_file($filename)){
//   //       $file = $filename;
//   //       header('Content-Description: File Transfer');
//   //       // header('Content-Type: application/octet-stream');
//   //       header('Content-Disposition: attachment; filename="'.basename($file).'"');
//   //       header('Expires: 0');
//   //       header('Cache-Control: must-revalidate');
//   //       header('Pragma: public');
//   //       header('Content-Length: ' . filesize($file));
//   //       readfile($file);
//   //     }   
//   //   }
//   // }


// ?>