<?php

class Plugin extends Common{

    public $table = "plugins";
    
    public function showPluginnameById(){
        $query = "SELECT pluginname
                FROM ".$this->table."
                WHERE id = :id";

       $stmt = $this->conn->prepare($query);

       $stmt->bindParam(":id",$this->id) ;

       $stmt->execute() ;
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
       
       if($row){
           return $this->id = $row['pluginname'];
       } else {
           return false ;
       }
    
    }


}

?>