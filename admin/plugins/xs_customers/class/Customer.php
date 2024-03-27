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
    public $username ;
    public $email ;
    public $company ;
    public $details ;
    public $details_opt ;
    public $auth_token ;
    public $last_login ;

    public function customerExists(){
        
        // query to check if email exists
        $query = "SELECT *
        FROM " .$this->prx. $this->table . "
        WHERE username = :username AND
              email = :email
        LIMIT 0,1";
    
        $stmt = $this->conn->prepare( $query );
    
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
    
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

    public function checkCookie(){
        $query="SELECT * FROM ".$this->table."
        WHERE id = :id AND auth_token = :auth_token";
        

        $stmt=$this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':auth_token', $this->auth_token);
        
        $stmt->execute();

        $num = $stmt->rowCount();
    
        return $num;
        
    }
    



}

?>