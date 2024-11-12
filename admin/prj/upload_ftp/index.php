<?php
// Parametri di accesso al server remoto tramite FTP
$ftp_host = "ftp://apache.xstream.priv";
$ftp_username = "nome_utente";
$ftp_password = "password_di_accesso";
// Stabilisce la connessione al server remoto tramite FTP
$ftp = ftp_connect( $ftp_host );
// Controlla se la connessione è andata a buon fine
if ( ! $ftp ) {
    echo "Connessione FTP fallita.";
    exit;
}
// Effettua il login al server remoto tramite FTP
$ftp_login = @ftp_login( $ftp_stream, $ftp_username, $ftp_password );
// Controlla se il tentativo di login è andato a buon fine
if ( ! $ftp_login ) {
    echo "Login FTP fallito.";
    exit;
}
// Imposta le variabili relative al file da gestire
$remote_file = "uploads/remote_test.txt";
$local_file = "local_test.txt";
// Tenta di caricare il file su server remoto FTP
$ftp_put_response = ftp_put( $ftp_stream, $remote_file, $local_file );
// Controlla se il tentativo di upload è andato a buon fine
if ( $ftp_put_response ) {
    echo "Upload completato con successo";
} else {
    echo "Si è verificato un errore nell'upload del file";
}
// Chiude la connessione FTP
ftp_close( $ftp_stream );
