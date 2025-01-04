<?php
require_once '../bootstrap.php';
header('Content-Type: application/json');

$data = [
    'materials' => $dbh->getMateriali1(),
    'colors' => $dbh->getColori1(),
    'environments' => $dbh->getAmbienti1(),
    'categories' => $dbh->getCategorie1()
];

if ($data && !empty($data['materials']) && !empty($data['colors']) && !empty($data['environments']) && !empty($data['categories'])) {
    echo json_encode(["success" => true, "data" => $data]);
} else {
    echo json_encode(["success" => false, "message" => "Errore nel recupero dei dati."]);
}
?>

