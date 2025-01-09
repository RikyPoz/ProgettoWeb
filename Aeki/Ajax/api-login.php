<?php

require_once '../bootstrap.php'; 

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
        $_SESSION['user_id'] = $user['Username'];
        
        // Controlla il tipo di utente
        $userType = $user['Tipo']; // Il campo Tipo contiene "Cliente" o "Venditore" in base al ruolo dell'utente
    
        // Redirige l'utente in base al tipo
        if ($userType === 'Cliente') {
            echo json_encode(['success' => true, 'redirect' => './profile.php', 'message' => 'Login effettuato con successo!']);
        } elseif ($userType === 'Venditore') {
            echo json_encode(['success' => true, 'redirect' => './seller.php', 'message' => 'Login effettuato con successo!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Tipo di utente non valido.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Password errata.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Utente non trovato.']);
}
?>
