<?php

ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php-error.log');

session_start();  // Avvia la sessione

require_once 'bootstrap.php';
/*
// Controllo: se l'utente è già loggato, reindirizza al profilo
if (isset($_SESSION['user_id'])) {
    header('Location: profile.php');  // Reindirizza alla pagina personale
    exit();  // Ferma l'esecuzione del codice
}
*/
// Template di login
$templateParams["titolo"] = "Aeki - Login";
$templateParams["nome"] = "login_main.php";  

require 'template/base.php';
?>
