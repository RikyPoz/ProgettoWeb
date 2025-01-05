<?php
require_once '../bootstrap.php'; 

header('Content-Type: application/json');

// Riceve i dati dal client
//$username = $_GET['username'] ?? null;
$username='user1';
$ultimaData = $_POST['ultimaData'] ?? '2000-01-01 00:00:00';

// Verifica se il nome utente è fornito
if (empty($username)) {
    echo json_encode(["error" => "Username non fornito"]);
    exit;
}

// Verifica il formato della data
if (!preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $ultimaData)) {
    echo json_encode(["error" => "Formato data non valido"]);
    exit;
}

try {
    // Chiama il metodo per ottenere i messaggi più recenti
    $messaggi = $dbh->getMessaggiByData($username, $ultimaData);
    // Verifica se sono stati trovati messaggi
    if (count($messaggi) > 0) {
        echo json_encode(['success' => true, 'messages' => $messaggi]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Nessun messaggio trovato']);
    }
} catch (Exception $e) {
    // Gestisce eventuali errori e restituisce il messaggio di errore in formato JSON
    echo json_encode(["error" => $e->getMessage()]);
}
?>
