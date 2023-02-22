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
    


    
}

?>