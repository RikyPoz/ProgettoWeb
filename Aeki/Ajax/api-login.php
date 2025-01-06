<?php

require_once '../bootstrap.php'; // Includi la configurazione e la connessione al database

header('Content-Type: application/json');

// Ricezione dati JSON
$data = json_decode(file_get_contents('php://input'), true);

$email = isset($data['email']) ? trim($data['email']) : null;
$password = isset($data['password']) ? trim($data['password']) : null;

if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Email o password non possono essere vuoti.']);
    exit();
}

// Verifica credenziali
$user = $dbh->getUtenteByEmail($email);

if ($user) { // Se l'utente esiste
    // Confronto password 
    if ($password === $user['Password']) {
        // Imposta una sessione 
        session_start();
        $_SESSION['user_id'] = $user['Username'];
        echo json_encode(['success' => true, 'message' => 'Login effettuato con successo!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Password errata.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Utente non trovato.']);
}
?>
