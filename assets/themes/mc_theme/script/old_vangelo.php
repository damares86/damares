<?php
// URL del feed RSS con il Vangelo del giorno
$url = 'https://rss.evangelizo.org/rss/v2/evangelizo_rss-it.xml';

// Carica il contenuto del feed RSS
$rss = simplexml_load_file($url);

// Controlla se il feed è stato caricato correttamente
if ($rss === FALSE) {
    die("Errore nel caricamento del feed RSS del Vangelo.");
}

// Inizializza le variabili per memorizzare il Vangelo e il titolo
$vangelo = null;
$titolo = null;

// Scorri gli elementi del feed RSS
foreach ($rss->channel->item as $item) {
    // Trova l'elemento che contiene "Vangelo" nel titolo
    if (stripos($item->title, 'Vangelo') !== false) {
        $vangelo = $item->description; // Descrizione contiene il testo del Vangelo
        $titolo = $item->title; // Salva il titolo
        break; // Interrompe il ciclo una volta trovato il Vangelo
    }
}

// Controlla se è stato trovato il Vangelo
if ($vangelo) {
    // Debug: Stampa il titolo per verificare che sia corretto
    // echo "Titolo: $titolo<br>";

    // Estrai solo l'evangelista e la citazione di capitolo e versetti
    if (preg_match("/secondo\s+(\w+\s+\d+,\d+(?:-\d+)?)/", $titolo, $matches)) {
        $riferimento = trim($matches[1]); // Usa il riferimento trovato
    } else {
        $riferimento = 'Riferimento non disponibile'; // Messaggio di default se non trovato
    }



    $link_vangelo = '<a href="#" data-bs-toggle="modal" data-bs-target="#popup_vangelo">Continua a leggere -></a>';

    // Limita il testo a un massimo di 300 caratteri per mostrare un'anteprima
    $maxCaratteri = 350;
    if (strlen($vangelo) > $maxCaratteri) {
        $vangelo_short = substr($vangelo, 0, $maxCaratteri) . '...<br>'. $link_vangelo;
    }


    // Stampa il Vangelo e il riferimento
    echo "<h2>Vangelo del Giorno</h2>";
    echo "<div><strong>Dal Vangelo secondo $riferimento</strong></div>"; // Stampa il riferimento
    echo "<div>$vangelo_short</div>"; // Stampa il testo del Vangelo
} else {
    echo "Impossibile trovare il Vangelo nel feed RSS.";
}

?>
<!--Danger theme Modal -->
<div class="modal fade text-left" id="popup_vangelo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title white" id="myModalLabel120">
                    Dal Vangelo secondo <?= $riferimento ?>
                </h5>
            </div>
            <div class="modal-body text-dark">
                <?= $vangelo ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <span>Chiudi</span>
                </button>
            </div>

        </div>
    </div>
</div>

<?php
?>