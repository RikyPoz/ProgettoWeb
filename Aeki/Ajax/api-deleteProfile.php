<?php

require_once '../bootstrap.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ottiene l'username dell'utente dalla sessione
    $username = $_SESSION['username'];
    // Usa il metodo deleteUtente per eliminare l'account
    $deletedRows = $dbh->deleteUtente($username);

    if ($deletedRows > 0) {
        // Distrugge la sessione dell'utente per disconnetterlo
        session_destroy();
        echo json_encode(['success' => true, 'message' => 'Account eliminato con successo!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore nell\'eliminazione dell\'account.']);
    }
}
?>
