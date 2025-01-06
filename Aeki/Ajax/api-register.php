<?php

require_once '../bootstrap.php';

header('Content-Type: application/json');

// Ricevi i dati JSON inviati dal client
$data = json_decode(file_get_contents('php://input'), true);

// Estrai i dati
$firstName = $data['first_name'];
$lastName = $data['last_name'];
$username = $data['username'];
$email = $data['email'];
$phone = $data['phone'];
$password = $data['password'];

// Verifica che l'email non esista già nel database
$existingUser = $dbh->getUtenteByEmail($email);

if ($existingUser) {
    echo json_encode(['success' => false, 'message' => 'Email già in uso.']);
    exit;
}

// Inserisci i nuovi dati nel database
$insertSuccess = $dbh->newUtente($firstName, $lastName, $username, $email, $password, $phone);

if ($insertSuccess) {
    echo json_encode(['success' => true, 'message' => 'Registrazione completata con successo!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Errore durante la registrazione.']);
}

?>
