<?php

require_once '../../bootstrap.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controlla se l'username è presente nella sessione
    if (isset($_SESSION['user_id'])) {
        $username = $_SESSION['user_id'];

        // Elimina l'account
        $deletedRows = $dbh->deleteUtente($username);

        if ($deletedRows > 0) {
            // Distrugge la sessione dell'utente per disconnetterlo
            session_destroy();

            // Elimina i cookie relativi all'utente
            if (isset($_COOKIE['userEmail'])) {
                setcookie('userEmail', '', time() - 3600, '/'); 
            }
            if (isset($_COOKIE['userPassword'])) {
                setcookie('userPassword', '', time() - 3600, '/'); 
            }

            echo json_encode(['success' => true, 'message' => 'Account eliminato con successo!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Errore nell\'eliminazione dell\'account.']);
        }
    } else {
        // Se l'username non è trovato nella sessione
        echo json_encode(['success' => false, 'message' => 'L\'utente non è autenticato.']);
    }
}
?>
