<?php
// Connessione al database
$conn = new mysqli("localhost", "root", "admin", "wp");

// Controlla la connessione
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

// Recupera la provincia dalla richiesta POST
$comune = $_POST['comune'];

$provincia = strtolower($provincia);
$table_name = 'provincia_cuneo' ;

// Esegui la query per recuperare gli indirizzi in base al comune
$sql = "SELECT des_particella_toponomastica, des_indirizzo, des_num_civico FROM $table_name WHERE COMUNE = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $comune);
$stmt->execute();
$result = $stmt->get_result();

// Costruisci le opzioni per il select dei comuni
$options = '<option value="">Seleziona una via</option>';
while ($row = $result->fetch_assoc()) {
    $options .= '<option value="' . $row['des_indirizzo'] . '">' . $row['des_indirizzo'] . '</option>';
}

echo $options;

// Chiudi la connessione al database
$stmt->close();
$conn->close();
?>
