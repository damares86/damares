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

// error->TENERE?
    public function showError($stmt){
        echo "<pre>";
            print_r($stmt->errorInfo());
        echo "</pre>";
    }

    
// show_all

function showAll($orderBy,$table){

    $query = "SELECT *
        FROM " .$this->prx. $table."
        ORDER BY ".$orderBy." ASC";   

    $stmt = $this->conn->prepare( $query );

    $stmt->execute();

    return $stmt ;
}


///////////////////////////
// TO FIX
///////////////////////////
function showAllWhere($orderBy,$table,$where){

    $i = 1;
    foreach($where as $item){
        $this->where.="$item = :$item" ;
        if($i<count($where)){
            $this->where.=", ";            
        }
        $i++;
    }
    
    $query = "SELECT *
        FROM " .$this->prx. $table."
        WHERE ".$this->where."
        ORDER BY ".$orderBy." ASC"; 

    $stmt = $this->conn->prepare( $query );

    foreach($where as $item){
        $stmt->bindParam(":$item", $this->$item);
    }

    $stmt->execute();

    return $stmt;
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