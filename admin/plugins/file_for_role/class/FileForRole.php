<?php

class FileForRole extends Common {

    public $table = "filesRoles" ;
    public $role_id ;
    public $file_id ;

    public function showRoleFile(){

        $query = "SELECT *
            FROM " .$this->prx. $this->table."
            WHERE role_id = :role_id AND file_id = :file_id
            ORDER BY id ASC"; 
    // print_r($query);
    // exit;
        $stmt = $this->conn->prepare( $query );
    
        $stmt->bindParam(":role_id", $this->role_id);
        $stmt->bindParam(":file_id", $this->file_id);
    
        $stmt->execute();
    
        return $stmt;
    }
    


}

?>