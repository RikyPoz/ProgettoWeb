<?php
require_once '../bootstrap.php';

header('Content-Type: application/json');

// Verifica se l'utente è loggato
if (isset($_SESSION['user_id'])) {
    // Leggi i dati JSON dalla richiesta
    $data = json_decode(file_get_contents('php://input'), true);

    // Recupera l'ID del messaggio
    $idNotifica = $data['idNotifica'] ?? null;

    if (!$idNotifica) {
        echo json_encode(["error" => "ID del messaggio mancante"]);
        exit;
    }

    try {
        // Aggiorna lo stato del messaggio come 'Letta' = 'Y'
        $update = $dbh->updateLettaNotifica($idNotifica);

        if ($update) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Messaggio non trovato o già letto']);
        }
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Utente non loggato"]);
}
