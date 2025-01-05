<?php
require_once 'bootstrap.php';

// Avvia la sessione per accedere ai dati memorizzati in sessione
//session_start();

//Base Template
$templateParams["titolo"] = "Aeki - Utente";
$templateParams["nome"] = "profile_main.php";
/*
// Verifica se l'utente è loggato
if(isset($_SESSION['user_id'])){
    // User Template
    $templateParams["utente"] = $dbh->getUtenteByEmail($_SESSION['email']);  
    $templateParams["ordini"] = $dbh->getRecensioniByUtente($_SESSION['email']);
    $templateParams["messaggi"] = $dbh->getMessaggiByUtente($_SESSION['email']);
}else {
    // Se l'utente non è loggato, reindirizza alla pagina di login
    header('Location: login.php');
    exit();  // Ferma l'esecuzione del codice dopo il reindirizzamento
}

*/
//PROVA: DA ELIMINARE!
$username = 'user1'; 
// User Template
$templateParams["utente"] = $dbh->getUtente($username);
$templateParams["recensioni"] = $dbh->getRecensioniByUtente($username);
$templateParams["messaggi"] = $dbh->getMessaggiByUtente($username);

// CONTROLLO COSA CONTENGONO I TEMPLATEPARAMS -> DA ELIMINARE!!!
/*echo "<pre>";
var_dump($templateParams["utente"]);
var_dump($templateParams["ordini"]);
var_dump($templateParams["messaggi"]);
echo "</pre>";
*/

require 'template/base.php';
?>


