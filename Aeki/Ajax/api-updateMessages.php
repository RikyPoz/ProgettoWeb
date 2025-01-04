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

// Verifica se la data è nel formato corretto (opzionale)
if (!preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $ultimaData)) {
    echo json_encode(["error" => "Formato data non valido"]);
    exit;
}

try {
    // Query per ottenere i messaggi più recenti
    $stmt = $dbh->prepare("SELECT Testo, Data FROM Notifiche WHERE Data > ? ORDER BY Data DESC");
    $stmt->execute([$ultimaData]);
    $messaggi = $stmt->fetchAll();

    // Se non ci sono messaggi, restituisce un array vuoto
    if (empty($messaggi)) {
        echo json_encode([]);
    } else {
        // Restituisce i messaggi in formato JSON
        echo json_encode($messaggi);
    }
} catch (Exception $e) {
    // Gestisce eventuali errori e restituisce il messaggio di errore in formato JSON
    echo json_encode(["error" => $e->getMessage()]);
}
?>
