<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "Aeki - SingleProduct";
$templateParams["nome"] = "singleProduct_main.php";
//Home Template

/*$idprodotto = -1;
if(isset($_GET["id"])){
    $idprodotto = $_GET["id"];
}
$templateParams["prodotto"] = $dbh->getProductbyId($idprodotto);*/


$prodotto = [
    [
        "nome" => "Prodotto 1",
        "prezzo"=>"10$",
        "descrizione" => "divano bellissimo,comodo, perfetto per il salotto mentre si guarda un film",
        "disponibilità" => "12",
        "recensioniTotali" => "37",
        "img"=>"upload/img1.jpg"
    ]
    ];
$templateParams["prodotto"] = $prodotto;

require 'template/base.php';
?>