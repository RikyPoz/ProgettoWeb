<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "Aeki - SingleProduct";
$templateParams["nome"] = "singleProduct_main.php";
//Home Template

$idprodotto = -1;

if(isset($_GET["id"])){
    $idprodotto = $_GET["id"];
}
$templateParams["prodotto"] = $dbh->getProdotto($idprodotto);

// manca l attributo disponibilità e immagine (multipla?) di un prodotto nel database
/*
$prodotto = [
    [
        "nome" => "Scrivania",
        "prezzo"=>"135",
        "descrizione" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque nisi nisl, lobortis sit amet vestibulum a, viverra sed nibh. Pellentesque euismod tempor massa, ac ullamcorper dolor vehicula tincidunt. Proin consectetur lectus quis orci tristique dictum. Suspendisse cursus elementum purus, vitae eleifend ante.",
        "disponibilità" => "12",
        "altezza" => "10",
        "lunghezza" => "40",
        "profondità" => "32",
        "peso" => "100",
        "colore" => "verde",
        "materiale" => "cotone",
        "ValutazioneMedia" => "3",
        "NumeroRecensioni" => "100"
    ]
    ];
$templateParams["prodotto"] = $prodotto;

$immagini = [
    [
        "img"=>"upload/poz/img2.png"
    ],
    [
        "img"=>"upload/poz/img3.png"
    ]
    ];
$templateParams["immagini"] = $immagini;*/


require 'template/base.php';
?>