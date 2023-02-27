<?php

class File extends Common{

    public $table = "files" ;
    public $filename ;
    public $filename_orig ;
    public $label ;
    public $inputFileName ;
    public $path ;
    public $origin ;

    public function uploadFile(){

        if($this->filename){

            $target_directory = $this->path ;
            $target_file = $target_directory . $this->filename;
            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
            $file_upload_error_messages="";
            
            $allowed_file_types=array("png","jpg","JPG","gif","pdf", "doc", "docx", "zip");
            if(!in_array($file_type, $allowed_file_types)){
                header("Location: ../index.php?p=".$this->origin."&err=formatErr");
		        exit;
            }
            
            if(file_exists($target_file)){
                $file_upload_error_messages.="File already exists";
            }
            
            // make sure the 'uploads' folder exists
            // if not, create it
            if(!is_dir($target_directory)){
                $oldmask = umask(0);
                mkdir($target_directory, 0777, true);
                umask($oldmask);
            }else{
                $oldmask = umask(0);
                chmod($target_directory, 0777);
                umask($oldmask);
            }
            

            if(empty($file_upload_error_messages)){  
                
                // the physical file on a temporary uploads directory on the server
                $file = $this->inputFileName;
				if (move_uploaded_file($file, $target_file)) {
                    

                    $oldmask = umask(0);
                    chmod($target_file, 0777);
                    umask($oldmask);
                    $query="";
                    if($this->operation=="add"){
                    $query = "INSERT INTO
                                " .$this->prx. $this->table . "
                            SET
                            filename = :filename,
                            label = :label";
                        }else if($this->operation=="edit"){
                            $query = "UPDATE
                            " .$this->prx. $this->table . "
                            SET
                            filename = :filename,
                            label = :label
                            WHERE 
                            id = :id";
                        }
                            // prepare the query
                            $stmt = $this->conn->prepare($query);
                            
                    // bind the values
                    $stmt->bindParam(':filename', $this->filename);
                    $stmt->bindParam(':label', $this->label);
                    if($this->operation=="edit"){
                        $stmt->bindParam(':id', $this->id);
                    }
                   
                    // execute the query, also check if query was successful
                    if($stmt->execute()){
                        return true;
                    }else{
                        $this->showError($stmt);
                        return false;
                    }
				
				
                } else {
                    echo "Failed to upload file.";
                    return false;
                }   
        	}
        }
 
    }

    public function showIdByFilename(){
        $query = "SELECT id
                FROM ".$this->table."
                WHERE filename = :filename";

       $stmt = $this->conn->prepare($query);

       $stmt->bindParam(":filename",$this->filename_orig) ;

       $stmt->execute() ;
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
       
       if($row){
           return $this->id = $row['id'];
       } else {
           return false ;
       }
    
    }
    
}

?>