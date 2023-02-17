<?php

// require '../vendor/autoload.php';		// If installed via composer
// $debug = new \bdk\Debug(array(
// 	'collect' => true,
// 	'output' => true,
// ));

// create Database class

if(!is_file('../class/Database.php')){
  $db_name=filter_input(INPUT_POST,"dbname");
  $username=filter_input(INPUT_POST,"username");
  $db_password=filter_input(INPUT_POST,"db_password");
  $host=filter_input(INPUT_POST,"host");
  $file_handle = fopen('../class/Database.php', 'w');
  fwrite($file_handle, '<?php');
  fwrite($file_handle, "\n");
  fwrite($file_handle, "class Database{");
  fwrite($file_handle, "\n");
  fwrite($file_handle, 'public $db_name="'.$db_name.'";');
  fwrite($file_handle, "\n");
  fwrite($file_handle, 'public $username="'.$username.'";');
  fwrite($file_handle, "\n");
  fwrite($file_handle, 'public $password="'.$db_password.'";');
  fwrite($file_handle, "\n");
  fwrite($file_handle, 'public $host="'.$host.'";');
  fwrite($file_handle, "\n");
  fwrite($file_handle, 'public $conn;');
  fwrite($file_handle, "\n");
  fwrite($file_handle, 'public $prx;');
  fwrite($file_handle, "\n");
  fwrite($file_handle, "\n");
  fwrite($file_handle, "public function getConnection(){");
  fwrite($file_handle, "\n");
  fwrite($file_handle, '$this->conn = null;');
  fwrite($file_handle, "\n");
  fwrite($file_handle, 'try{');
  fwrite($file_handle, "\n");
  fwrite($file_handle, '$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);');
  fwrite($file_handle, "\n");
  fwrite($file_handle, '}catch(PDOException $exception){');
  fwrite($file_handle, "\n");
  fwrite($file_handle, 'echo "Connection error: " . $exception->getMessage();');
  fwrite($file_handle, "\n");
  fwrite($file_handle, '}');
  fwrite($file_handle, "\n");
  fwrite($file_handle, 'return $this->conn;');
  fwrite($file_handle, "\n");
  fwrite($file_handle, '}');
  fwrite($file_handle, "\n");
  fwrite($file_handle, '}');
  fwrite($file_handle, "\n");
  fwrite($file_handle, '?>');
  
}

chmod('../class/Database.php',0777);

include("../class/Database.php");

$database = new Database();
$db = $database->getConnection();

// store the data given by user

$user_email=$_POST['email'];
$password=$_POST['password'];
$password_hash = password_hash($password, PASSWORD_DEFAULT);


// prefix optionally given by user
// and save it in a file

$prefix="";
if($_POST['prefix']){
  $prefix=$_POST['prefix']."_";
}

$file_handle = fopen('../core/prefix.php', 'w');
fwrite($file_handle, '<?php');
fwrite($file_handle, "\n");
fwrite($file_handle, '$prefix="'.$prefix.'";');
fwrite($file_handle, "\n");
fwrite($file_handle, '?>');

chmod('../core/prefix.php',0777);


// TODO: check on URL in order to avoid multiple use of an istance of cms


/////////////////////////////////////////////////////////////

// create the db tables if not exists

/////////////////////////////////////////////////////////////

// creating role's table
// $db->query("CREATE TABLE IF NOT EXISTS ".$prefix."roles
//                            ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
//                              rolename VARCHAR(255) NOT NULL)");

// $db->query("INSERT INTO ".$prefix."roles
//                             (id, rolename)
//                             VALUES ('1','Admin')
//                             ");

// $db->query("INSERT INTO ".$prefix."roles
//                             (id, rolename)
//                             VALUES ('2','Manager')
//                             ");
// $db->query("INSERT INTO ".$prefix."roles
//                             (id, rolename)
//                             VALUES ('3','Editor')
//                             ");

                            
header("Location: ../index.php");
