<?php
require_once '../bootstrap.php'; 

header('Content-Type: application/json');

// Verifica se la connessione è già presente
if (!$dbh) {
    echo json_encode(["error" => "Connessione al database non disponibile"]);
    exit;
}

// Riceve la data dell'ultimo aggiornamento (se presente)
$ultimaData = $_GET['ultimaData'] ?? '1970-01-01 00:00:00';

try {
    // Query per ottenere i messaggi più recenti
    $stmt = $dbh->prepare("SELECT contenuto, dataMessaggio FROM messaggi WHERE dataMessaggio > ? ORDER BY dataMessaggio DESC");
    $stmt->execute([$ultimaData]);
    $messaggi = $stmt->fetchAll();

    // Restituisce i messaggi in formato JSON
    echo json_encode($messaggi);
} catch (Exception $e) {
    // Gestisce eventuali errori e restituisce il messaggio di errore in formato JSON
    echo json_encode(["error" => $e->getMessage()]);
}
?>
