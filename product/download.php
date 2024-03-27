<?php 

// require '../admin/phpDebug/src/Debug/Debug.php';   			// if not using composer

// $debug = new \bdk\Debug(array(
//     'collect' => true,
//     'output' => true,
// ));

session_start();

if (!isset($_SESSION['customer_loggedin'])) {
    header('Location: ../login.php?msg=noLog');
    exit;
}

$user=filter_input(INPUT_GET,"user");
$cat=filter_input(INPUT_GET,"cat");
$product=filter_input(INPUT_GET,"product");
$file=filter_input(INPUT_GET,"filename");
$product=strtolower($product);

$filename = $product.'/'.$cat.'/'.$file ;


if(is_file($filename))
{
  $fp=fopen($product.'/download.log','a');
  fwrite($fp,"\n");
  fwrite($fp,$user." ".$product." ".$file." ".date("d/m/Y-H:i:s"));
  fclose($fp);
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename="'.basename($filename).'"');
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  header('Content-Length: ' . filesize($filename));
  readfile($filename);

} 
else
{
  header('Location: ../index_xs.php?err=noFilePresent');
  exit;
}


?>