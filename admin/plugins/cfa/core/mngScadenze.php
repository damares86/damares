<?php

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

spl_autoload_register('autoloader');

function autoloader($class){
	include("../class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

include "../inc/class_initialize.php";

$setting->name = "debug" ;
$dbg = $setting->showAllWhere('id',['name']);
$row_debug = $dbg->fetch(PDO::FETCH_ASSOC);
extract($row_debug);

if($row_debug['value']==1){
	require '../vendor/autoload.php';		// If installed via composer
	$debug = new \bdk\Debug(array(
		'collect' => true,
		'output' => true,
	));
}

    $error = 0 ;

    // calcolo differenza date
    $cfa->et = date("Y-m-d",strtotime("+30 days"));
    $cfa->table = "polizze" ;
    $stmt = $cfa->showAllWhere('id',['et']);

    $from="info@dmweblab.com";
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        // email collaboratore
        $cfa->id = $row['id_collaboratore'] ;
        $cfa->table = 'collaboratori' ;
        $stmt1 = $cfa->showAllWhere('id',['id']) ;
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ;
        extract($row1) ;
        
        $to=$row1['email'];

        // dati compagnia
        $cfa->id = $row['id_compagnia'] ;
        $cfa->table = 'compagnie' ;
        $stmt2 = $cfa->showAllWhere('id',['id']) ;
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC) ;
        extract($row2) ;

        $subject = 'Scadenza polizza numero '.$row['numero'].' - '.$row2['nome'] ; 
        echo $subject ;
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        // Create email headers
        $headers .= 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();

        $output='<html><body>';
        $output.='<p>Polizza numero <b>'.$row['numero'].'</b></p>';
        $output.='<br>';
        $output.='Compagnia: <b>'.$row2['nome'].'</b><br>' ;
        $output.= 'Scadenza: <b>'.$row['et'].'</b><br>' ;
        $output.='<a href="http://minicms.altervista.org/admin/index.php?p=editPolizza&idToMod='.$row['id'].'">Link polizza</a>';
        $output.='<br>';
        $output.='</body></html>';
        

        if (!mail ($to, $subject, $output, $headers)) {
            $error++;
        } 

    }

    if( $error>0 )
    {
        $from = "info@dmweblab.com" ;
        $to = "davidemasera@gmail.com" ;
        $subject = "Errore nell'invio delle email delle scadenze" ;

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        // Create email headers
        $headers .= 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();

        $output='<html><body>';
        $output.='<p>errore</p>';
        $output.='<br>';
        $output.='</body></html>';

    }
exit;


	
