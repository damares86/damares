<pre>
    <?php 
    print_r($_POST); 
    exit;
?>
</pre>
<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__ . "/coreConfig.php";




// check if there's an account to delete

if (filter_input(INPUT_GET, "idToDel")) {

    $idToDel = filter_input(INPUT_GET,"idToDel");

    // TODO

}

$operation = filter_input(INPUT_POST, "operation");

// check if there's an account to edit or add

if (filter_input(INPUT_POST, "idToMod")) {



} else if ($operation == "add") {

    $mc->page_name = filter_input(INPUT_POST,'page_name') ;
    $mc->layout = filter_input(INPUT_POST,'layout') ;

    $query_str = '' ;
    $err_file = '' ;
    
    // controllo se è spuntato use header
    if(filter_input(INPUT_POST,'use_header')){

        $mc->header = 1 ;

        // verifico se è stata scelta immagine o galleria
        if(filter_input(INPUT_POST,'header') == 'image'){

            if($_FILES['myfile']['size'] > 0){
                $file->filename = $_FILES['myfile']['name'] ;
                $filename = $_FILES['myfile']['name'] ;
        
                if($file->countFile()>0){
                    header("Location: ../index.php?p=allFiles&err=fileExists");
                    exit;
                }
                // set data for file uploading
                $file->inputFileName = $_FILES['myfile']['tmp_name'] ;
                $file->label = $_FILES['myfile']['name'] ;
                $file->path = "../../uploads/" ;
                $file->origin = filter_input(INPUT_POST,"origin");
                
                $file->operation = "add" ;  
                if($file->uploadFile()){
                    //success
                    $mc->header_media = $_FILES['myfile']['name'] ;
                }else{
                    $mc->header_media = filter_input(INPUT_POST,'visual.jpg') ;
                    $err_file = "&err=headerImgFail";
                }
                
            }else{
                $mc->header_media = filter_input(INPUT_POST,'visual.jpg') ;
            }
            
        }else if(filter_input(INPUT_POST,'header') == 'gallery'){
            
            $mc->header_media = filter_input(INPUT_POST,'gallery') ;

        }
        
        $query_str =', header_media';
        
    }else{
        
        $mc->header = 0 ;

    }
    
    $counter = filter_input(INPUT_POST,'counter') ;
    $mc->counter = $counter ;

    for($i=1; $i<=$counter; $i++){




    }










    

} else {
    header("Location: ../index.php?p=allAccounts&err=noPost");
    exit;
}
