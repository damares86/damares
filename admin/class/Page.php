<?php

class Page{

    private $conn ;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    function showError($stmt){
        echo "<pre>";
            print_r($stmt->errorInfo());
        echo "</pre>";
    }

    
}

?>