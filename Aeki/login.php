<?php
session_start();  // Avvia la sessione

require_once 'bootstrap.php';

// Template di login
$templateParams["titolo"] = "Aeki - Login";
$templateParams["nome"] = "login_main.php";  

// Verifica se la richiesta è di tipo POST 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recupera i dati del form
    $email = $_POST['email'];
    $password = $_POST['password']; 

    // Recupera i dati dell'utente usando l'email
    $user = $dbh->getUtenteByEmail($email);

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

            // Reindirizza alla homePage
            header('Location: homePage.php');  
            exit();  // Ferma l'esecuzione del codice dopo il reindirizzamento
        } else {
            // Password errata
            $response = ['status' => 'error', 'message' => 'Password errata'];
        }
    } else {
        // Utente non trovato
        $response = ['status' => 'error', 'message' => 'Utente non trovato'];
    }

    // Restituisce la risposta JSON in caso di errore
    if (!isset($response)) {
        $response = ['status' => 'error', 'message' => 'Si è verificato un errore.'];
    }
    echo json_encode($response);
    exit();
}

require 'template/base.php';
?>
