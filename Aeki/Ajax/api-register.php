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

// Verifica che l'username non esista già nel database
$existingUsername = $dbh->getUtente($username);
if ($existingUsername) {
    echo json_encode(['success' => false, 'message' => 'Username già in uso.']);
    exit;
}

// Inserisci i nuovi dati nel database
$insertSuccess = $dbh->newUtente($firstName, $lastName, $username, $email, $password, $phone);

if ($insertSuccess) {
    // Crea il carrello per il nuovo utente
    $cartCreated = $dbh->createCart($username);
    // Crea la wishlist per il nuovo utente
    $wishlistCreated = $dbh->createWishlist($username);

    if ($cartCreated && $wishlistCreated) {
        echo json_encode(['success' => true, 'message' => 'Registrazione completata con successo!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore durante la creazione del carrello o della wishlist.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Errore durante la registrazione.']);
}

?>
