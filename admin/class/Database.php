<?php
class Database{
public $db_name="damares";
public $username="root";
public $password="admin";
public $host="localhost";
public $conn;
public $prx;

public function getConnection(){
$this->conn = null;
try{
$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
}catch(PDOException $exception){
echo "Connection error: " . $exception->getMessage();
}
return $this->conn;
}
}
?>