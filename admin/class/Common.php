<?php

class Common{

    public $conn ;
    public $stmt ;
    public $table ;
    public $fields = [] ;
    public $id ;
    public $prx ;


    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    public function showError($stmt){
        echo "<pre>";
            print_r($stmt->errorInfo());
        echo "</pre>";
    }

// show_all

// delete



}

?>