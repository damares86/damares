<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Common{

    public $conn ;
    public $stmt ;
    public $table ;
    public $where ;
    public $fields  ;
    public $id ;
    public $prx ;
    public $operation ;


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


// insert

// $fields must be an array
function insert($fields){
    
    $i = 1;
    foreach($fields as $item){
        $this->fields.="$item = :$item" ;
        if($i<count($fields)){
            $this->fields.=", ";            
        }
        $i++;
    }
    
    $query = "INSERT INTO " .$this->prx. $this->table."
    SET ".$this->fields.""; 
    
    $stmt = $this->conn->prepare( $query );

    foreach($fields as $item){
        $stmt->bindParam(":$item", $this->$item);
    }

    if($stmt->execute()){
        return true ;
    }else{
        return false ;
    }
    
}

function insertIntoTable($fields,$table){
    
    $i = 1;
    foreach($fields as $item){
        $this->fields.="$item = :$item" ;
        if($i<count($fields)){
            $this->fields.=", ";            
        }
        $i++;
    }
    
    $query = "INSERT INTO " .$this->prx. $table."
    SET ".$this->fields.""; 
    $stmt = $this->conn->prepare( $query );
    
    foreach($fields as $item){
        $stmt->bindParam(":$item", $this->$item);
    }
   
    if($stmt->execute()){
        return true ;
    }else{
        return false ;
    }
    
}



// update

// $fields must be an array
function update($fields,$where){

    $this->where = "" ;

    $i = 1;
    foreach($fields as $item){
        $this->fields.="$item = :$item" ;
        if($i<count($fields)){
            $this->fields.=", ";            
        }
        $i++;
    }
    
    $query = "UPDATE " .$this->prx. $this->table."
        SET ".$this->fields." WHERE $where = :$where"; 

        $stmt = $this->conn->prepare( $query );
        
        foreach($fields as $item){
            $stmt->bindParam(":$item", $this->$item);
        }
        
    $stmt->bindParam(":$where",$this->$where);

    if($stmt->execute()){
        return true ;
    }else{
        return false ;
    }
    
}


// $fields must be an array
function updateTable($fields,$where,$table){

    $this->where = "" ;

    $i = 1;
    foreach($fields as $item){
        $this->fields.="$item = :$item" ;
        if($i<count($fields)){
            $this->fields.=", ";            
        }
        $i++;
    }
    
    $query = "UPDATE " .$this->prx. $table."
        SET ".$this->fields." WHERE $where = :$where"; 

        
        $stmt = $this->conn->prepare( $query );
        
        foreach($fields as $item){
        $stmt->bindParam(":$item", $this->$item);
        }
    $stmt->bindParam(":$where",$this->$where);

    if($stmt->execute()){
        return true ;
    }else{
        return false ;
    }
    
}
    
// show_all

function showAll($orderBy){
    $query = "SELECT *
    FROM " .$this->prx. $this->table."
    ORDER BY ".$orderBy." ASC";   
    
    $stmt = $this->conn->prepare( $query );

    $stmt->execute();

    return $stmt ;
}

function showAllTable($orderBy,$table){

    $query = "SELECT *
        FROM " .$this->prx. $table."
        ORDER BY ".$orderBy." ASC";   

    $stmt = $this->conn->prepare( $query );

    $stmt->execute();

    return $stmt ;
}

// $where must be an array
function showAllWhere($orderBy,$where){
    
    $this->where="";

    $i = 1;
    foreach($where as $item){
        $this->where.="$item = :$item" ;
        if($i<count($where)){
            $this->where.=" AND ";            
        }
        $i++;
    }
    
    $query = "SELECT *
        FROM " .$this->prx. $this->table."
        WHERE ".$this->where."
        ORDER BY ".$orderBy." ASC"; 
        
    $stmt = $this->conn->prepare( $query );
    
    foreach($where as $item){
        
        $stmt->bindParam(":$item", $this->$item);
    }
    
    $stmt->execute();
    return $stmt;
}

function showAllWhereTable($orderBy,$table,$where){
    
    $this->where="";
    
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


public function itemExists($item){
        
    // query to check if email exists
    $query = "SELECT *
    FROM " .$this->prx. $this->table . "
    WHERE ".$item." = :".$item."
    LIMIT 0,1";

    $stmt = $this->conn->prepare( $query );

    $stmt->bindParam(":".$item."", $this->$item);

    // execute the query
    $stmt->execute();

    // get number of rows
    $num = $stmt->rowCount();

    if($num>0){
        return true;
    }else{
        return false;
    }
}



// delete

    function delete($field){
        
        $query = "DELETE FROM " .$this->prx. $this->table. " WHERE ".$field." = :".$field."";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":$field", $this->$field);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }


    function deleteFromTable($field,$table){
        
        $query = "DELETE FROM " .$this->prx. $table. " WHERE ".$field." = :".$field."";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":$field", $this->$field);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }




}

?>