<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__."/coreConfig.php";
require __DIR__."/exportSettings.php";
// Include XLSX generator library 
require_once '../class/PhpXlsxGenerator.php'; 

// Excel file name for download 
if(filter_input(INPUT_POST,'export'))
{
    $exclude_post = ['export','filename','class','table','origin','submit_export'] ;
    
    $file_post = filter_input(INPUT_POST,"filename") ;
    $class_post = filter_input(INPUT_POST,"class") ;
    $origin = filter_input(INPUT_POST,'origin') ;
    $$class_post->table = filter_input(INPUT_POST,'table') ;
    
    $fileName = $file_post . date('Y-m-d') . ".xlsx"; 
    $fields_var = $class_post.'_export_fields';
    
    // Define column names 
    $excelData[] = $$fields_var ; 
    $searchKeys = [] ;
    
    foreach($_POST as $key=>$value)
    {
        if(!in_array($key,$exclude_post))
        {
            // get all the keys and set all the class properties
            $searchKeys[] = $key ;
            $$class_post->$key = $value ;
        }
    }
        
    // query based on post data
    $stmt = $$class_post->showAllWhere('id',$searchKeys) ;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row) ;

        $linedata = [] ;
        
        // get all the column of the record
        foreach($row as $item)
        {
            $linedata[] = $item;
        }
        
        // push the array with the data of this record in the excelData array
        $excelData[] = $linedata; 
    
    }

    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    
    $xlsx->downloadAs($fileName);


}

?>