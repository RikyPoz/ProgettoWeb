<?php
require_once '../bootstrap.php';
session_start();

// Imposta il tipo di contenuto come JSON
header('Content-Type: application/json');

try {
    // Leggi il corpo della richiesta
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        throw new Exception('Richiesta non valida.');
    }

    // Estrai i dati dal JSON
    $nome = isset($data['nome']) ? trim($data['nome']) : null;
    $cognome = isset($data['cognome']) ? trim($data['cognome']) : null;
    $email = isset($data['email']) ? trim($data['email']) : null;
    $telefono = isset($data['telefono']) ? trim($data['telefono']) : null;

    // Verifica che almeno un campo sia stato inviato
    if (empty($nome) && empty($cognome) && empty($email) && empty($telefono)) {
        throw new Exception('Almeno uno dei campi deve essere modificato.');
    }

    // Ottieni l'username dalla sessione
    $username = $_SESSION['user_id'];

    // Aggiorna i dati nel database
    $rowsUpdated = $dbh->updateUtente($nome, $cognome, $email, $telefono, $username);

    // Restituisci il risultato
    if ($rowsUpdated > 0) {
        echo json_encode(['success' => true, 'message' => 'Profilo aggiornato con successo.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Nessuna modifica apportata.']);
    }
} catch (Exception $e) {
    // Gestisci eventuali errori
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
