<?php 

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Rate extends Common{

    public $table = "rate" ;
    public $table_cat = "rate_cat" ;
    public $pivot_cat = "fileCat" ;
    public $pivot_file = "fileAccountRate" ;
    public $account_id ;
    public $file_id ;
    public $rate ;
    public $percent ;
    public $vote_number ;
    public $cat_name ;
    public $rate_cat_id ;  
    

    function showCat(){
 
        $query = "SELECT rate_cat_id
            FROM " .$this->prx. $this->pivot_cat."
            WHERE file_id = :file_id
            LIMIT 0,1"; 
            
        $stmt = $this->conn->prepare( $query );
        
        $stmt->bindParam(":file_id", $this->file_id);
        
        $stmt->execute();
        
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);

        return $row['rate_cat_id'] ;

    }

    function showCatName(){
 
        $query = "SELECT cat_name
            FROM " .$this->prx. $this->table_cat."
            WHERE id = :id
            LIMIT 0,1"; 
            
        $stmt = $this->conn->prepare( $query );
        
        $stmt->bindParam(":id", $this->id);
        
        $stmt->execute();
        
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);

        return $row['cat_name'] ;
        
    }

    function showStar(){
 
        $query = "SELECT star
            FROM " .$this->prx. $this->table."
            WHERE file_id = :file_id
            LIMIT 0,1"; 
            
        $stmt = $this->conn->prepare( $query );
        
        $stmt->bindParam(":file_id", $this->file_id);
        
        $stmt->execute();
        
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);

        return $row['star'] ;
        
    }

}

?>