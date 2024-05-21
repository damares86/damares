<?php
// Connessione al database
$conn = new mysqli("localhost", "root", "admin", "test");

// Controlla la connessione
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

// Recupera la provincia dalla richiesta POST
$value = explode('_',$_POST['comune']) ;
$comune = $value[1];
$provincia = strtolower($value[0]);
$table_name = 'db_provincia_'.$provincia ;

// Esegui la query per recuperare gli indirizzi in base al comune
$sql = "SELECT des_particella_toponomastica, des_indirizzo, des_num_civico FROM $table_name WHERE COMUNE = ? ORDER BY des_particella_toponomastica ASC, des_indirizzo ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $comune);
$stmt->execute();
$result = $stmt->get_result();

// Costruisci le opzioni per il select dei comuni
$options = '<option value="">Seleziona una via</option>';
while ($row = $result->fetch_assoc()) {
    $options .= '<option value="' . $row['des_indirizzo'] . '">' .$row['des_particella_toponomastica'].' '. $row['des_indirizzo'] . ' '.$row['des_num_civico'].' </option>';
}

echo $options;

// Chiudi la connessione al database
$stmt->close();
$conn->close();
?>
