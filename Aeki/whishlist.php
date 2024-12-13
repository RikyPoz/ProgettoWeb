
<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Aeki - whishlist";
$templateParams["nome"] = "whishList_main.php";

/*$nomeUtente = "";
if(isset($_GET["nomeUtente"])){
    $nomeUtente = $_GET["nomeUtente"];
}
$templateParams["prodotti"] = $dbh->getwhishlistByUtente($nomeUtente);*/



$prodotti = [
    [
        "nome" => "Piantina Verde",
        "prezzo"=>"10",
        "img"=>"upload/images.png",
        "recensioniTotali" => "10"
    ],
    [
        "nome" => "Scrivania",
        "prezzo"=>"135",
        "img"=>"upload/img1.png",
        "recensioniTotali" => "233"
    ],
    [
        "nome" => "Lampada da tavolo",
        "prezzo"=>"24",
        "img"=>"upload/imgLampada.png",
        "recensioniTotali" => "7"
    ],
    [
        "nome" => "Scrivania",
        "prezzo"=>"135",
        "img"=>"upload/img1.png",
        "recensioniTotali" => "233"
    ],
    [
        "nome" => "Piantina Verde",
        "prezzo"=>"10",
        "img"=>"upload/images.png",
        "recensioniTotali" => "10"
    ],
    
    
    ];
    $templateParams["prodotti"] = $prodotti;

    $categorie = [
        [
            "nome" => "Mobili",
        ],
        [
            "nome" => "Letti",
        ],
        [
            "nome" => "Armadi",
        ],
        [
            "nome" => "Decorazioni",
        ],
        [
            "nome" => "Illuminazione",
        ],
        [
            "nome" => "Giardinaggio",
        ],
       
        
        ];
    $templateParams["categorie"] = $categorie;


require 'template/base.php';
?>