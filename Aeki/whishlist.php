
<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Aeki - whishlist";
$templateParams["nome"] = "whishList_main.php";

/*$nomeUtente = "";
if(isset($_GET["nomeUtente"])){
    $nomeUtente = $_GET["nomeUtente"];
}
$templateParams["ordini"] = $dbh->getOrdiniByUtente($nomeUtente);*/


$templateParams["ordini"] = $ordini;

$prodotti = [
    [
        "nome" => "Prodotto 1",
        "prezzo"=>"10",
        "img"=>"upload/img1.jpg"
    ],
    [
        "nome"=>"Prodotto 2",
        "prezzo"=>"60",
        "img"=>"upload/img2.jpg"
    ],
    [
        "nome"=>"Prodotto 2",
        "prezzo"=>"60",
        "img"=>"upload/img2.jpg"
    ],
    [
        "nome"=>"Prodotto 2",
        "prezzo"=>"60",
        "img"=>"upload/img2.jpg"
    ],
    [
        "nome"=>"Prodotto 2",
        "prezzo"=>"60",
        "img"=>"upload/img2.jpg"
    ],
    [
        "nome"=>"Prodotto 2",
        "prezzo"=>"60",
        "img"=>"upload/img2.jpg"
    ]
    ];
    $templateParams["prodotti"] = $prodotti;


require 'template/base.php';
?>