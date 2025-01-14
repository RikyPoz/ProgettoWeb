<?php
include '../../bootstrap.php';  

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    // Prende il numero delle notifiche da leggere
    $unread_count = $dbh->getNumeroNotifiche($user_id);  
    echo json_encode(['unread_count' => $unread_count]);
} else {
    echo json_encode(['unread_count' => 0]);
}
?>
