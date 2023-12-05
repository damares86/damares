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
    $exclude_post = ['export','filename','fields','table','origin','submit_export'] ;

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
            $searchKeys[] = $key ;
            $$class_post->$key = $value ;
        }
    }

    // query based on post data
    $stmt = $$class_post->showAllWhere('id',$searchKeys) ;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        
    }


    // Fetch records from database and store in an array 
    $query = $db->query("SELECT * FROM members ORDER BY id ASC"); 
    if($query->num_rows > 0){ 
        while($row = $query->fetch_assoc()){ 
            $status = ($row['status'] == 1)?'Active':'Inactive'; 
            $lineData = array($row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['gender'], $row['country'], $row['created'], $status);  
            $excelData[] = $lineData; 
        } 
    } 

    // Export data to excel and download as xlsx file 
    $xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
    $xlsx->downloadAs($fileName); 

    header("Location: ../index.php?p=$origin&msg=expOk") ;
    exit;

}

?>