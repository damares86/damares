<?php 

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Session extends Common{

    public $table ;
    public $name ;
    public $avatar ;
    public $description ;
    public $details ;
    public $details_opt ;
    public $sessions_name ;
    public $date ;
    public $start_time ;
    public $end_time ;
    public $location ;
    public $session_id ;
    public $speaker_id ;
    public $speaker_doc_id ;
    public $speakers_doc_name ;
    public $inputFileName ;
    public $path ;
    public $origin ;
    public $label ;
    public $active ;
    public $people_name ;
    public $people_cat ;
    public $cat_id ;
    public $people_id ;
    public $location_name ;
    public $location_id ;
    public $relations_id ;

    public function uploadFile(){
        if($this->speakers_doc_name){
            $target_directory = $this->path ;
            $target_file = $target_directory . $this->speakers_doc_name;
            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
            $file_upload_error_messages="";
            
            $allowed_file_types=array("pdf");
            if(!in_array($file_type, $allowed_file_types)){
                header("Location: ../index.php?p=".$this->origin."&idToMod=".$this->id."&err=formatErr");
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
                
				if(move_uploaded_file($file, $target_file)) {

                    $oldmask = umask(0);
                    chmod($target_file, 0777);
                    umask($oldmask);

                    $query="";
            
                    $query = "INSERT INTO
                                " .$this->prx. $this->table . "
                            SET
                            speakers_doc_name = :speakers_doc_name,
                            label = :label,
                            speaker_id = :speaker_id";
                    // prepare the query
                    $stmt = $this->conn->prepare($query);
                    // bind the values
                    $stmt->bindParam(':speakers_doc_name', $this->speakers_doc_name);
                    $stmt->bindParam(':label', $this->label);
                    $stmt->bindParam(':speaker_id', $this->speaker_id);

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

?>