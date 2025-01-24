<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Archive extends Common
{

    // public $table = "home";
    public $archive_year_id;
    public $year;
    public $file_name;
    public $title;
    public $year_id;
    public $month;
    public $filename_orig ;
    public $label ;
    public $inputFileName ;
    public $path ;

    public function uploadFile(){

        if($this->file_name){
            $target_directory = $this->path ;
            $target_file = $target_directory . $this->file_name;
            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
            $file_upload_error_messages="";
            
            $allowed_file_types=array("png","jpg","jpeg","JPG","gif","pdf", "doc", "docx", "zip","mp3");
            if(!in_array($file_type, $allowed_file_types)){
                header("Location: ../index.php?p=".$this->origin."&err=formatErr");
		        exit;
            }
            
            if(file_exists($target_file)){
                rename($target_file,$target_file.'_old');
               // $file_upload_error_messages.="File already exists";
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
                
				if(move_uploaded_file($file, $target_file)) {
                    
                    $oldmask = umask(0);
                    chmod($target_file, 0777);
                    umask($oldmask);
                    $query="";
                    if($this->operation=="add"){
            
                    $query = "INSERT INTO
                                " .$this->prx. $this->table . "
                            SET
                            file_name = :file_name,
                            title = :title,
                            archive_year_id = :archive_year_id,
                            month = :month";
                            
                        }else if($this->operation=="edit"){
                            $query = "UPDATE
                            " .$this->prx. $this->table . "
                            SET
                            file_name = :file_name,
                            title = :title,
                            archive_year_id = :archive_year_id,
                            month = :month
                            WHERE 
                            id = :id";
                        }
                        // prepare the query
                        $stmt = $this->conn->prepare($query);
                        // bind the values
                        $stmt->bindParam(':file_name', $this->file_name);
                        $stmt->bindParam(':title', $this->title);
                        $stmt->bindParam(':archive_year_id', $this->archive_year_id);
                        $stmt->bindParam(':month', $this->month);
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


}
