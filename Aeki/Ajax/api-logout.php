<?php
require_once '../bootstrap.php';

// Distruggi tutte le variabili di sessione
session_unset();

// Distruggi la sessione
session_destroy();

// Imposta il tipo di contenuto come JSON
header('Content-Type: application/json');

// Rispondi con un messaggio di successo
echo json_encode(['status' => 'success']);
?>
