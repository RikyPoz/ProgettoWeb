<?php
require_once '../../bootstrap.php';

// Distrugge tutte le variabili di sessione
session_unset();

// Distrugge la sessione
session_destroy();

// Imposta il tipo di contenuto come JSON
header('Content-Type: application/json');

// Risponde con un messaggio di successo
echo json_encode(['status' => 'success']);
?>
