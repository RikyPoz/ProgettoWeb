<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../bootstrap.php';
session_start();

// Imposta il tipo di contenuto della risposta come JSON
header('Content-Type: application/json');

// Simula una risposta di errore per il debug (rimuovi questa parte quando il codice è completo)
$response = ['success' => false, 'message' => 'Errore nel server'];
echo json_encode($response); // Risposta di debug

// Estrae i dati inviati tramite POST
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : null;
$cognome = isset($_POST['cognome']) ? trim($_POST['cognome']) : null;
$email = isset($_POST['email']) ? trim($_POST['email']) : null;
$telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : null;

// Verifica se almeno uno dei campi è stato inviato
if (empty($nome) && empty($cognome) && empty($email) && empty($telefono)) {
    echo json_encode(['success' => false, 'message' => 'Almeno uno dei campi deve essere fornito.']);
    exit;
}

// Ottiene l'ID dell'utente dalla sessione
//$username = $_SESSION['username']; 
$username = 'utente1';
// Chiama il metodo updateUtente
$rowsUpdated = $dbh->updateUtente($nome, $cognome, $email, $telefono, $username);

// Restituisce la risposta in base al numero di righe modificate
if ($rowsUpdated > 0) {
    echo json_encode(['success' => true, 'message' => 'Profilo aggiornato con successo.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Nessuna modifica apportata.']);
}
?>
