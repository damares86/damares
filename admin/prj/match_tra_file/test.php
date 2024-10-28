<?php

$file_apache = 'apache.txt' ;
$file_rocky = 'rockynew.txt' ;

$apache_arr = [] ;
$rocky_arr = [] ;

// Apri il file in modalità di lettura
if ($handle = fopen($file_apache, 'r')) {
    // Leggi il file riga per riga
    while (($line = fgets($handle)) !== false) {
        // Usa preg_match per trovare il primo blocco di testo prima di uno spazio
        if (preg_match('/^\S+/', $line, $matches)) {
            // Aggiungi il pacchetto al nostro array
            $apache_arr[] = $matches[0];
        }
    }
    // Chiudi il file
    fclose($handle);
}

// Apri il file in modalità di lettura
if ($handle = fopen($file_rocky, 'r')) {
    // Leggi il file riga per riga
    while (($line = fgets($handle)) !== false) {
        // Usa preg_match per trovare il primo blocco di testo prima di uno spazio
        if (preg_match('/^\S+/', $line, $matches)) {
            // Aggiungi il pacchetto al nostro array
            $rocky_arr[] = $matches[0];
        }
    }
    // Chiudi il file
    fclose($handle);
}

$install_arr = [] ;

foreach($apache_arr as $item){
    if(!in_array($item, $rocky_arr)){
        $install_arr[] = $item ;
    }

}

?>
<pre>
<?php
print_r($install_arr);
?>
<pre>