
<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Aeki - ordini";
$templateParams["nome"] = "orderList_main.php";

/*$nomeUtente = "";
if(isset($_GET["nomeUtente"])){
    $nomeUtente = $_GET["nomeUtente"];
}
$templateParams["ordini"] = $dbh->getOrdiniByUtente($nomeUtente);*/

$ordini = [
[
    "idOrdine" => "abcd",
    "dataOrdine"=>"20/10/2024",
    "costoTotale"=>"150$"
],
[
    "idOrdine"=>"1234",
    "dataOrdine"=>"5/12/2024",
    "costoTotale"=>"10$"
]
];
$templateParams["ordini"] = $ordini;

$prodotti = [
    [
        "nome" => "Prodotto 1",
        "prezzo"=>"10$",
        "img"=>"upload/img1.jpg"
    ],
    [
        "nome"=>"Prodotto 2",
        "prezzo"=>"60$",
        "img"=>"upload/img2.jpg"
    ]
    ];
    $templateParams["prodotti"] = $prodotti;


require 'template/base.php';
?>