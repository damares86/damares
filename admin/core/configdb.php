<?php

require '../vendor/autoload.php';		// If installed via composer
$debug = new \bdk\Debug(array(
	'collect' => true,
	'output' => true,
));

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
$password_hash = password_hash($password, PASSWORD_BCRYPT);


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


$db->query("CREATE TABLE IF NOT EXISTS ".$prefix."files
              ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                filename VARCHAR(255) NOT NULL,
                label VARCHAR(255) NOT NULL)");


$db->query("CREATE TABLE IF NOT EXISTS ".$prefix."accounts
              ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                avatar_id INT (5),
                last_login datetime DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY(avatar_id) REFERENCES files(id))");


$db->query("CREATE TABLE IF NOT EXISTS ".$prefix."roles
              ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                rolename VARCHAR(255) NOT NULL)");


$db->query("CREATE TABLE IF NOT EXISTS ".$prefix."accountsRoles
              ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                accounts_id INT ( 5 ) NOT NULL,
                role_id INT (5) NOT NULL,
                redirect VARCHAR ( 255 ) DEFAULT 'none',
                FOREIGN KEY (accounts_id) REFERENCES accounts(id),
                FOREIGN KEY (role_id) REFERENCES roles(id))");


$db->query("CREATE TABLE IF NOT EXISTS ".$prefix."sectionParent
              ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                link VARCHAR(255) NOT NULL,
                label VARCHAR(255) NOT NULL,
                icon VARCHAR ( 255 ) NOT NULL)");


$db->query("CREATE TABLE IF NOT EXISTS ".$prefix."sectionChild
                ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                  link VARCHAR(255) NOT NULL,
                  label VARCHAR(255) NOT NULL,
                  icon VARCHAR ( 255 ) NOT NULL,
                  parent_id INT ( 5 ) NOT NULL,
                  FOREIGN KEY (parent_id) REFERENCES sectionParent(id))");


$db->query("CREATE TABLE IF NOT EXISTS ".$prefix."rolesSection
                  ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    section_id INT ( 5 ) NOT NULL,
                    role_id INT (5) NOT NULL,
                    FOREIGN KEY (section_id) REFERENCES sectionParent(id),
                    FOREIGN KEY (role_id) REFERENCES roles(id))");

                 
$db->query("CREATE TABLE ".$prefix."password_reset_temp (
                    email varchar(250) NOT NULL PRIMARY KEY,
                    token varchar(250) NOT NULL,
                    expDate datetime NOT NULL)");
              
              
$db->query("CREATE TABLE IF NOT EXISTS ".$prefix."settings
                  ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    value VARCHAR(255) NOT NULL)");


$db->query("CREATE TABLE ".$prefix."verify (
                    id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    public varchar(250) NOT NULL,
                    secret varchar(250) NOT NULL,
                    active INT ( 5 ) DEFAULT 0)");


$db->query("CREATE TABLE IF NOT EXISTS ".$prefix."plugins
                  ( id INT ( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    pluginname VARCHAR(255) NOT NULL,                       
                    active INT(1) NOT NULL)");


/////////////////////////////////////////////////////////////

// insert data in the db tables

/////////////////////////////////////////////////////////////

$db->query("INSERT INTO ".$prefix."files
                            (id, filename, label)
                            VALUES ('1','default.jpg','default_avatar')");

$db->query("INSERT INTO ".$prefix."accounts
(id, username, password,email,avatar_id)
VALUES ('1','admin', '". $password_hash ."','". $user_email ."','1')");

$db->query("INSERT INTO ".$prefix."roles
                            (id, rolename)
                            VALUES ('1','Admin')");

$db->query("INSERT INTO ".$prefix."roles
                            (id, rolename)
                            VALUES ('2','Manager')");

$db->query("INSERT INTO ".$prefix."roles
                            (id, rolename)
                            VALUES ('3','User')");

$db->query("INSERT INTO ".$prefix."accountsRoles
                            (id, accounts_id,role_id)
                            VALUES ('1','1','1')");

$db->query("INSERT INTO ".$prefix."settings
                            (id, name,value)
                            VALUES ('1','locale','en')");

$db->query("INSERT INTO ".$prefix."settings
                            (id, name,value)
                            VALUES ('2','license','none')");

       
$db->query("INSERT INTO ".$prefix."verify
                            (id, public, secret, active) 
                            VALUES ('1','PUBLIC_KEY', 'SECRET_KEY', '0')");           

// scan the plugin directory and insert the plugin by folder's name

$plugins = scandir('../plugin');
$exclude = array('..', '.');
$plugin_id = 1 ;

foreach ($plugins as $key => $value){
    if(!in_array($value,$exclude)){
        $db->query("INSERT INTO ".$prefix."plugins
                              (id, pluginname,active)
                              VALUES ('".$plugin_id."','".$value."','0')");
        $plugin_id++ ;
  }
}


                            
header("Location: ../index.php");
