<?php
include 'db_connection.php';

// Verifica se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];

    // Controlla che l'utente sia autenticato
    session_start();
    if (!isset($_SESSION['utente_id'])) {
        die('Utente non autenticato');
    }

    // Prepara la query di aggiornamento
    $query = "UPDATE utenti SET nome = ?, cognome = ?, email = ?, telefono = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssi', $nome, $cognome, $email, $telefono, $_SESSION['utente_id']);

    if ($stmt->execute()) {
        echo "Profilo aggiornato con successo!";
        // Rimanda l'utente alla pagina del profilo
        header("Location: profile.php");
    } else {
        echo "Errore nell'aggiornamento del profilo: " . $stmt->error;
    }
}

?>
