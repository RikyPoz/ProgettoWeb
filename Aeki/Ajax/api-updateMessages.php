<?php
require_once '../bootstrap.php';

header('Content-Type: application/json');

// Verifica se l'utente è loggato
if (isset($_SESSION['user_id'])) {
    // Recupera l'username dalla sessione
    $username = $dbh->getUtente($_SESSION['user_id']);
    $ultimaData = $_POST['ultimaData'] ?? '2000-01-01 00:00:00';

    // Verifica se il formato della data è valido
    if (!preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $ultimaData)) {
        echo json_encode(["error" => "Formato data non valido"]);
        exit;
    }

    try {
        // Ottieni i messaggi più recenti
        $messaggi = $dbh->getMessaggiByData($username['Username'], $ultimaData);
        if (count($messaggi) > 0) {
            echo json_encode(['success' => true, 'messages' => $messaggi]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Nessun messaggio trovato']);
        }
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Utente non loggato"]);
}
?>
