<?php

class Common{

    public $conn ;
    public $stmt ;
    public $table ;
    public $where = "" ;
    public $fields = [] ;
    public $id ;
    public $prx ;


    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    public function showError($stmt){
        echo "<pre>";
            print_r($stmt->errorInfo());
        echo "</pre>";
    }

    
// show_all

function showAll($items,$orderBy){

    $i = 1;
    foreach($items as $item){
        $this->where.="$item = :$item" ;
        if($i<count($items)){
            $this->where.=", ";            
        }
        $i++;
    }
    
    $query = "SELECT *
        FROM " .$this->prx. $this->table . " 
        WHERE ".$this->where."
        ORDER BY ".$orderBy." ASC";  

    $stmt = $this->conn->prepare( $query );

    foreach($items as $item){
        $stmt->bindParam(":$item", $this->$item);
    }

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row;
}



// delete

    function delete(){
        
        $query = "DELETE FROM " .$this->prx. $this->table. " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);

        if($result = $stmt->execute()){
            return true;
        }else{
            return false;
        }
    }



}

?>