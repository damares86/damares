<?php

class Role extends Common{

    public $table = "roles" ;
    public $rolename ;

    public function showRolenameById(){
        $query = "SELECT rolename
                FROM ".$this->table."
                WHERE id = :id";

       $stmt = $this->conn->prepare($query);

       $stmt->bindParam(":id",$this->id) ;

       $stmt->execute() ;
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
       
       if($stmt){
           return $this->rolename = $row['rolename'];
       } else {
           return false ;
       }
    
    }
    
}

?>