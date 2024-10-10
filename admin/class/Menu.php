<?php


class Menu{


    private $conn;
    private $table_name = "menu";

    public $id;
    public $pagename;
    public $inmenu;
    public $itemorder;
    public $parent;
    public $childof;
    public $prx;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // create new role record
    function insert(){
        $query="INSERT INTO ".$this->prx."menu SET pagename = :page_name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':page_name', $this->pagename);       
        if($stmt->execute()){
            return true;
        }else{
            $this->showError($stmt);
            return false;
        }
    
    }

    function showError($stmt){
        echo "<pre>";
            print_r($stmt->errorInfo());
        echo "</pre>";
    }


    function update(){
        $query = "UPDATE
                    " .$this->prx.$this->table_name . "
                SET
                inmenu = :inmenu,
                itemorder = :itemorder,
                parent = :parent,
                childof = :childof
                WHERE
                id = :id";
                
                
                // prepare the query
                $stmt = $this->conn->prepare($query);
                
               // bind the values    
                $stmt->bindParam(':inmenu', $this->inmenu);  
                $stmt->bindParam(':itemorder', $this->itemorder);       
                $stmt->bindParam(':parent', $this->parent);  
                // if($this->parent==1){
                //     $this->childof="none";
                // }
                $stmt->bindParam(':childof', $this->childof);       
   
                $stmt->bindParam(':id', $this->id);       
               
      
        //execute the query, also check if query was successful
        if($stmt->execute()){
            return true;

        }else{
            $this->showError($stmt);
            return false;
        }
    
    }

    function showAll(){
        //select all data
        $query = "SELECT
                    *
                FROM
                    " .$this->prx. $this->table_name . "
                ORDER BY
                    itemorder";  
  
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
  
        return $stmt;
    }

    function showAllParent(){
        //select all data
        $query = "SELECT
                    *
                FROM
                    " .$this->prx. $this->table_name . "
                WHERE
                    parent = 1 AND inmenu = 1
                ORDER BY
                    itemorder";  
  
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
  
        return $stmt;
    }

    function showOrder(){
        $query = "SELECT
                    *
                FROM
                    " .$this->prx. $this->table_name . "
                WHERE
                    id = :id";  
                    
                    
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(':id', $this->id);       
        $stmt->execute();
  
        return $stmt;
    }

    function showAllChildInMenu(){
        $query = "SELECT
                    *
                FROM
                    " .$this->prx. $this->table_name . "
                WHERE
                    childof = :childof AND inmenu = 1 AND parent = 0
                ORDER BY
                    itemorder";  
                    
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(':childof', $this->childof);       
        $stmt->execute();
  
        return $stmt;
    }

    function showAllChildNone(){
        $query = "SELECT
                    *
                FROM
                    " .$this->prx. $this->table_name . "
                WHERE
                    childof = 'none' AND inmenu = 1 AND parent = 0
                ORDER BY
                    itemorder";  
                    
                    
        $stmt = $this->conn->prepare( $query );     
        $stmt->execute();
  
        return $stmt;
    }

    public function countChild(){
    
        $query = "SELECT 
            id 
            FROM 
            ".$this->prx."menu
            WHERE childof = :childof";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(':childof', $this->childof);       

        $stmt->execute();
    
        $num = $stmt->rowCount();
    
        return $num;
    }


    public function countChildInMenu(){
    
        $query = "SELECT 
            id 
            FROM 
            ".$this->prx."menu
            WHERE childof = :childof and inmenu = 1";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(':childof', $this->childof);       

        $stmt->execute();
    
        $num = $stmt->rowCount();
    
        return $num;
    }



    function showAllNotInMenu(){
        //select all data
        $query = "SELECT
                    *
                FROM
                    " .$this->prx. $this->table_name . "
                WHERE
                    inmenu = 0
                ORDER BY
                    itemorder";  
  
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
  
        return $stmt;
    }


    function showMenu(){

        ///////////////////////////
        // DA AGGIUSTARE ALLA FINE
        ///////////////////////////

        $query = "SELECT
                    *
                FROM
                    ".$this->prx."menu
                WHERE
                inmenu = 1 ORDER BY itemorder ASC";  
  
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
  
        return $stmt;
    }


    public function countAll(){
    
        $query = "SELECT id FROM ".$this->prx."menu";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
    
        $num = $stmt->rowCount();
    
        return $num;
    }

    function showById(){
        $query = "SELECT *
        FROM " .$this->prx. $this->table_name . "
        WHERE id = ?
        LIMIT 0,1";
  
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $this->id = $row['id'];
        $this->pagename = $row['pagename'];
        $this->inmenu = $row['inmenu'];
        $this->itemorder = $row['itemorder'];
        $this->parent = $row['parent'];
        $this->childof = $row['childof'];
        
    }

    function showByName(){
        $query = "SELECT *
        FROM " .$this->prx. $this->table_name . "
        WHERE pagename = :pagename
        LIMIT 0,1";
        


        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(':page_name', $this->pagename);       
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

     
        $this->id = $row['id'];
        $this->pagename = $row['pagename'];
        $this->inmenu = $row['inmenu'];
        $this->itemorder = $row['itemorder'];
        $this->parent = $row['parent'];
        $this->childof = $row['childof'];


    }
 // delete the post
 function delete(){
    
  
    $query = "DELETE FROM ".$this->prx."menu WHERE pagename = :pagename";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":pagename",$this->pagename);
    if($stmt->execute()){
        return true;
    }else{
        $this->showError($stmt);
        return false;
    }  
    
  
}





}

?>