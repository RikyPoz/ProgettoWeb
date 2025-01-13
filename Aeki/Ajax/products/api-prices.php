<?php
require_once '../../bootstrap.php';
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$prices = $dbh->getPriceMinMax($data["type"], $data["value"]);
echo json_encode($prices);
?>