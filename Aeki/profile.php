<?php
require_once 'bootstrap.php';

// Avvia la sessione per accedere ai dati memorizzati in sessione
session_start();

//Base Template
$templateParams["titolo"] = "Aeki - Utente";
$templateParams["nome"] = "profile_main.php";

// Verifica che l'utente sia loggato
//$username = $_SESSION['username'] ?? ''; 
$username = 'user1'; 

// Se l'utente non è loggato viene reindirizzato alla pagina di login
if (empty($username)) {
    header("Location: login.php");
    exit();
}

// User Template
$templateParams["utente"] = $dbh->getUtente($username);
$templateParams["ordini"] = $dbh->getOrdiniByUtente($username);
$templateParams["messaggi"] = $dbh->getMessaggiByUtente($username);

require 'template/base.php';
?>