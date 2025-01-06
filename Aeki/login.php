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

// Verifica se la richiesta è di tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recupera i dati dal form
    $email = $_POST['email'];
    $password = $_POST['password']; 

    // Debug: stampa un messaggio di debug nella console
    function console_log($message) {
        echo "<script>console.log('PHP Debug: " . addslashes($message) . "');</script>";
    }

    console_log('Inizio processo di login');
    console_log('Email inserita: ' . $email);

    // Cerca l'utente nel database
    $user = $dbh->getUtenteByEmail($email);

    if ($user) {
        console_log('Utente trovato: ' . $user['Email']);
        if (password_verify($password, $user['Password'])) {
            console_log('Password corretta');
        } else {
            console_log('Password errata');
        }
    } else {
        console_log('Utente non trovato');
    }

    // Controlla se l'utente esiste
    if ($user) {
        // Verifica la password
        if (password_verify($password, $user['Password'])) {
            // Login riuscito: imposta le variabili di sessione
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['Email'];
            $_SESSION['first_name'] = $user['Nome'];

            // Messaggio di successo nella sessione
            $_SESSION['success_message'] = 'Login effettuato con successo';

            // Reindirizza al profilo
            //header('Location: http://localhost/ProgettoWeb/Aeki/profile.php');
;  
            exit();  // Ferma l'esecuzione del codice
        } else {
            // Password errata
            $_SESSION['error_message'] = 'Password errata';
        }
    } else {
        // Utente non trovato
        $_SESSION['error_message'] = 'Utente non trovato';
    }
}
// Se l'utente non è loggato o ci sono errori, carica il template del modulo di login

require 'template/base.php';

?>
