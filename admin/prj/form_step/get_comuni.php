<?php
// Connessione al database
$conn = new mysqli("localhost", "root", "admin", "test");

// Controlla la connessione
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

// Recupera la provincia dalla richiesta POST
$provincia = $_POST['provincia'];

$provincia = strtolower($provincia);
$table_name = 'db_provincia_'.$provincia ;

// Esegui la query per recuperare i comuni in base alla provincia
$sql = "SELECT DISTINCT COMUNE FROM $table_name WHERE PROVINCIA = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $provincia);
$stmt->execute();
$result = $stmt->get_result();

// Costruisci le opzioni per il select dei comuni
$options = '<option value="">Seleziona un comune</option>';
while ($row = $result->fetch_assoc()) {
    $options .= '<option value="'.$provincia .'_' . $row['COMUNE'] . '">' . $row['COMUNE'] . '</option>';
}

echo $options;

// Chiudi la connessione al database
$stmt->close();
$conn->close();
?>
