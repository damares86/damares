<?php

class Section extends Common{

    public $table_parent = "sectionParent";
    public $table_child = "sectionChild";

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


    
}

?>