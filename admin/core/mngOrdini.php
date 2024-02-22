<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__."/coreConfig.php";

$rsa->table = 'farmaci' ;
$stmt = $rsa->showAll('id') ;

$ordine = [] ;

$array_month = [
    '01' => 31,
    '02' => 28,
    '03' => 31,
    '04' => 30,
    '05' => 31,
    '06' => 30,
    '07' => 31,
    '08' => 31,
    '09' => 30,
    '10' => 31,
    '11' => 30,
    '12' => 31
];

$mese = filter_input(INPUT_POST,'mese');
$giorni = $array_month[$mese] ;

$anno = date('Y');
$bisestile = $rsa->is_leap_year($anno);
if($mese=='02' && $bisestile )
{
    $giorni = 29 ;
}

while( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
{

    extract($row);

    $nome_farmaco = $row['principio'] ;

    $rsa->table = 'pazientiFarmaci' ;
    $rsa->id_farmaci = $row['id'] ;

    
    $stmt1 = $rsa->showAllWhere('id',['id_farmaci']) ;
    
    $cpr_tot = 0 ;

    while( $row1 = $stmt1->fetch(PDO::FETCH_ASSOC) )
    {
        extract($row1);

        $cpr_giorno += $row1['cpr'] ;
    }

    $cpr_mese = $cpr_giorno * $giorni ;
    echo 'die '.$cpr_giorno.'<br>' ;
    echo 'mese '.$cpr_mese.'<br>' ;
    
    $scatole = ceil($cpr_mese/$row['cpr_box'] ) ;
    echo 'scatole necessarie '.$scatole.'<br>' ;
    
    $scatole_mag = $scatole - $row['magazzino'] ;
    echo 'scatole magazzino '.$row['magazzino'].'<br>' ;
    echo 'scatole da ordinare '.$scatole_mag.'<br>' ;
    
    if($scatole_mag>0)
    {
        $ordine[] = array( $nome_farmaco => $scatole_mag  ) ;
    }
    
    
}

$folder = '../inc/ordini';
if(!is_dir($folder)){
    $oldmask = umask(0);
    mkdir($folder, 0777, true);
    umask($oldmask);
}else{
    $oldmask = umask(0);
    chmod($folder, 0777);
    umask($oldmask);
}

$file = "$folder/ordine.json" ;

unlink($file);

$json=json_encode($ordine);

if(file_put_contents($file, $json, FILE_APPEND))
{
    header("Location: ../index.php?p=allOrdini&msg=ordiniAddSucc&mese=$mese");
    exit;
}
else
{
    header("Location: ../index.php?p=addOrdini&err=ordiniFail");
    exit;
}