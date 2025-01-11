<?php
require_once 'bootstrap.php';

// Base Template
$templateParams["titolo"] = "Aeki - Utente";
$templateParams["nome"] = "profile_main.php";
$templateParams["js"] = array(
    "js/viewPasswordProfile.js",
    "js/updateMessages.js",
    "js/updateProfile.js",
    "js/deleteProfile.js",
    "js/changePassword.js"
);

// Gestione dei messaggi di stato (successo, nessuna modifica, errore)
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        echo "<div class='alert alert-success'>Profilo aggiornato con successo!</div>";
    } elseif ($_GET['status'] == 'no_change') {
        echo "<div class='alert alert-info'>Nessuna modifica effettuata.</div>";
    } elseif ($_GET['status'] == 'error') {
        echo "<div class='alert alert-danger'>Errore durante l'aggiornamento del profilo.</div>";
    }
}

// Verifica se l'utente è loggato
if (isset($_SESSION['user_id'])) {
    // Recupera i dati dell'utente loggato
    $templateParams["utente"] = $dbh->getUtente($_SESSION['user_id']);  
    $templateParams["recensioni"] = $dbh->getRecensioniByUtente($_SESSION['user_id']);
    $templateParams["messaggi"] = $dbh->getMessaggiByUtente($_SESSION['user_id']);
} else {
    // Se l'utente non è loggato, reindirizza alla pagina di login
    header('Location: login.php');
    exit();  // Ferma l'esecuzione del codice dopo il reindirizzamento
}

require 'template/base.php';
?>
