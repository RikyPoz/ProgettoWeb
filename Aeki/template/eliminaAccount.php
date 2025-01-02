<?php
include 'db_connection.php';

// Verifica che l'utente sia autenticato
session_start();
if (!isset($_SESSION['utente_id'])) {
    die('Utente non autenticato');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepara la query per eliminare l'account
    $query = "DELETE FROM utenti WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $_SESSION['utente_id']);

    if ($stmt->execute()) {
        // Distrugge la sessione dell'utente per disconnetterlo
        session_destroy();
        echo "Account eliminato con successo!";
        // Rimanda l'utente alla pagina home
        header("Location: homePage.php");
    } else {
        echo "Errore nell'eliminazione dell'account.";
    }
}
?>
