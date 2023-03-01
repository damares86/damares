<?php

class Section extends Common{

    public $table_parent = "sectionParent";
    public $table_child = "sectionChild";
    public $parent_id ;

    public function countChild($id){
    
        $query = "SELECT id FROM ".$this->prx.$this->table_child."
                 WHERE parent_id = :id";
    
        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(":id",$id);
        $stmt->execute();
    
        $num = $stmt->rowCount();
    
        return $num;
    }
    
    function showByLink($link, $table){

        $query = "SELECT *
            FROM " .$this->prx. $table."
            WHERE link = :link";   
    
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":link",$link);
    
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ;
    }
    
    function showById($table){

        $query = "SELECT *
            FROM " .$this->prx. $table."
            WHERE id = :id";   
    
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":id",$this->id);
    
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ;
    }

    function showAllChild(){

        $query = "SELECT *
            FROM " .$this->prx. $this->table_child."
            WHERE parent_id = :parent_id
            ORDER BY id ASC"; 

        $stmt = $this->conn->prepare( $query );
    
        $stmt->bindParam(":parent_id", $this->parent_id);
    
        $stmt->execute();
    
        return $stmt;
    }
    

    
}

?>