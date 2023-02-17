<?php

class Plugin extends Common{

    private $conn ;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    
}

?>