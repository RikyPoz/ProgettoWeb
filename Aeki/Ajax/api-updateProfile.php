<?php
require_once '../bootstrap.php';
session_start();

// Imposta il tipo di contenuto come JSON
header('Content-Type: application/json');

try {
    // Leggi il corpo della richiesta
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) {
        throw new Exception('Richiesta non valida.');
    }

    // Estrai i dati dal JSON
    $nome = isset($input['nome']) ? trim($input['nome']) : null;
    $cognome = isset($input['cognome']) ? trim($input['cognome']) : null;
    $email = isset($input['email']) ? trim($input['email']) : null;
    $telefono = isset($input['telefono']) ? trim($input['telefono']) : null;

    // Verifica che almeno un campo sia stato inviato
    if (empty($nome) && empty($cognome) && empty($email) && empty($telefono)) {
        throw new Exception('Almeno uno dei campi deve essere modificato.');
    }

    // Ottieni l'username dalla sessione
    $username = $_SESSION['username'];

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
