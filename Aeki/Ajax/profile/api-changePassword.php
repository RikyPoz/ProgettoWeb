<?php

include '../../bootstrap.php';

// Controlla se l'utente è autenticato
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Utente non autenticato"]);
    exit;
}

// Recupera i dati POST
$data = json_decode(file_get_contents('php://input'), true);
$username = $_SESSION['user_id']; // Ottiene il nome utente dalla sessione
$passwordAttuale = $data['passwordAttuale'];
$nuovaPassword = $data['nuovaPassword'];

// Chiama la funzione per aggiornare la password
$result = $dbh->updatePassword($username, $passwordAttuale, $nuovaPassword);

// Verifica il risultato e invia una risposta al client
if ($result) {
    echo json_encode(["success" => true, "message" => "Password cambiata con successo! Reindirizzamento in corso..."]);
} else {
    echo json_encode(["success" => false, "message" => "La password attuale non è corretta."]);
}
?>
