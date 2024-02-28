<?php 

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Customer extends Common{

    public $table = 'customers' ;
    public $id ;
    public $name ;
    public $surname ;
    public $details ;
    public $details_opt ;

    public function customerExists(){
        
        // query to check if email exists
        $query = "SELECT *
        FROM " .$this->prx. $this->table . "
        WHERE name = :name AND
              surname = :surname
        LIMIT 0,1";
    
        $stmt = $this->conn->prepare( $query );
    
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":surname", $this->surname);
    
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
    



}

?>