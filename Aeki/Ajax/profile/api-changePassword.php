<?php

include '../../bootstrap.php';

// Controlla se l'utente è autenticato
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Utente non autenticato"]);
    exit;
}

// Recupera i dati 
$data = json_decode(file_get_contents('php://input'), true);
$username = $_SESSION['user_id'];
$passwordAttuale = $data['passwordAttuale'];
$nuovaPassword = $data['nuovaPassword'];

// Hash della password attuale e della nuova password
$hashedPasswordAttuale = hash('sha256', $passwordAttuale);
$hashedNuovaPassword = hash('sha256', $nuovaPassword);

// Chiama la funzione per aggiornare la password
$result = $dbh->updatePassword($username, $hashedPasswordAttuale, $hashedNuovaPassword);

// Verifica il risultato e invia una risposta al client
if ($result) {
    echo json_encode(["success" => true, "message" => "Password cambiata con successo! Reindirizzamento in corso..."]);
} else {
    echo json_encode(["success" => false, "message" => "La password attuale non è corretta."]);
}
?>
