<?php

require_once '../../bootstrap.php';

header('Content-Type: application/json');

// Ricezione dei dati JSON
$data = json_decode(file_get_contents('php://input'), true);

// Estrazione dei dati
$firstName = $data['first_name'] ?? null;
$lastName = $data['last_name'] ?? null;
$username = $data['username'] ?? null;
$email = $data['email'] ?? null;
$phone = $data['phone'] ?? null;
$password = $data['password'] ?? null;

// Verifica che i dati obbligatori siano presenti
if (!$firstName || !$lastName || !$username || !$email || !$phone || !$password) {
    echo json_encode(['success' => false, 'message' => 'Tutti i campi sono obbligatori.']);
    exit;
}

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

// Hash della password
$hashedPassword = hash('sha256', $password);

// Inserimento dei dati nel database
$insertSuccess = $dbh->newUtente($firstName, $lastName, $username, $email, $hashedPassword, $phone);

if ($insertSuccess) {
    // Creazione carrello e wishlist per il nuovo utente
    $cartCreated = $dbh->createCart($username);
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
