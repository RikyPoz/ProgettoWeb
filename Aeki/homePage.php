<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "Aeki - HomePage";
$templateParams["nome"] = "homePage_main.php";

//Home Template
$templateParams['categorie'] = [];
foreach ($db->getCategorie() as $categoria) {
    $immagine = $db->getImmagineCategoria($categoria['NomeCategoria']);
    $templateParams['categorie'][] = [
        'nome' => $categoria['NomeCategoria'],
        'immagine' => $immagine ? $immagine['ImmagineCategoria'] : 'upload/default/default-category.jpg' // Immagine predefinita
    ];
}

$templateParams['ambienti'] = [];
foreach ($db->getAmbienti() as $ambiente) {
    $immagine = $db->getImmagineAmbiente($ambiente['NomeAmbiente']);
    $templateParams['ambienti'][] = [
        'nome' => $ambiente['NomeAmbiente'],
        'immagine' => $immagine ? $immagine['ImgAmbiente'] : 'upload/default/default-ambient.jpg' // Immagine predefinita
    ];
}

var_dump($templateParams['categorie']);
var_dump($templateParams['ambienti']);

require 'template/base.php';
?>