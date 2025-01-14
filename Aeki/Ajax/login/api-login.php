<?php

require_once '../../bootstrap.php';

header('Content-Type: application/json');

// Ricezione dati JSON
$data = json_decode(file_get_contents('php://input'), true);

$email = isset($data['email']) ? trim($data['email']) : null;
$password = isset($data['password']) ? trim($data['password']) : null;

// Verifica che email e password non siano vuoti
if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Email o password non possono essere vuoti.']);
    exit();
}

// Verifica se l'utente esiste
$user = $dbh->getUtenteByEmail($email);

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Utente non trovato.']);
    exit();
}

// Hash della password inserita
$hashedPassword = hash('sha256', $password);

// Confronto tra la password inserita e quella hashata
if ($hashedPassword !== $user['Password']) {
    echo json_encode(['success' => false, 'message' => 'Password errata.']);
    exit();
}

// Imposta una sessione con l'ID utente
$_SESSION['user_id'] = $user['Username'];

// Controlla il tipo di utente
$userType = $user['Tipo'];

switch ($userType) {
    case 'Cliente':
        echo json_encode(['success' => true, 'redirect' => './profile.php', 'message' => 'Login effettuato con successo!']);
        break;
    case 'Venditore':
        echo json_encode(['success' => true, 'redirect' => './seller.php', 'message' => 'Login effettuato con successo!']);
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Tipo di utente non valido.']);
        break;
}
?>
