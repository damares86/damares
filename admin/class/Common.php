<?php

class Common{


public function showError($stmt){
    echo "<pre>";
        print_r($stmt->errorInfo());
    echo "</pre>";
}

// show_all

// delete



}

?>