<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $passwordAttuale = $_POST['passwordAttuale'];
    $nuovaPassword = $_POST['nuovaPassword'];

    // Si assicura che l'utente sia autenticato
    session_start();
    if (!isset($_SESSION['utente_id'])) {
        die('Utente non autenticato');
    }

    // Ottiene la password memorizzata nel database
    $query = "SELECT password FROM utenti WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $_SESSION['utente_id']);
    $stmt->execute();
    $stmt->bind_result($passwordHash);
    $stmt->fetch();

    // Verifica se la password attuale è corretta
    if (password_verify($passwordAttuale, $passwordHash)) {
        // Cifra la nuova password
        $nuovoPasswordHash = password_hash($nuovaPassword, PASSWORD_BCRYPT);

        // Prepara la query di aggiornamento
        $updateQuery = "UPDATE utenti SET password = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param('si', $nuovoPasswordHash, $_SESSION['utente_id']);

        if ($updateStmt->execute()) {
            echo "Password cambiata con successo!";
            // Rimanda l'utente alla pagina di login
            header("Location: login.php");
        } else {
            echo "Errore nel cambio della password.";
        }
    } else {
        echo "La password attuale non è corretta.";
    }
}
?>
