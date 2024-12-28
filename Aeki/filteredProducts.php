<?php

require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "Aeki - FilteredProducts";
$templateParams["nome"] = "filteredProducts_main.php";

// Template
$templateParams["lista_prodotti"] = [
    [
        "image" => "https://via.placeholder.com/150",
        "name" => "Scrivania Minimal",
        "price" => 199.99,
        "rating" => 4,
        "reviews" => 38,
    ],
    [
        "image" => "https://via.placeholder.com/150",
        "name" => "Scrivania Classica",
        "price" => 149.99,
        "rating" => 5,
        "reviews" => 12,
    ],
    [
        "image" => "https://via.placeholder.com/150",
        "name" => "Scrivania Moderna",
        "price" => 249.99,
        "rating" => 3,
        "reviews" => 54,
    ],
    [
        "image" => "https://via.placeholder.com/150",
        "name" => "Scrivania Compatta",
        "price" => 99.99,
        "rating" => 4,
        "reviews" => 22,
    ],
    [
        "image" => "https://via.placeholder.com/150",
        "name" => "Scrivania Elegante",
        "price" => 299.99,
        "rating" => 5,
        "reviews" => 44,
    ],
    [
        "image" => "https://via.placeholder.com/150",
        "name" => "Scrivania per Studio",
        "price" => 179.99,
        "rating" => 3,
        "reviews" => 19,
    ],
];

$templateParams["colors"] = ["rosso", "bianco", "marrone", "nero", "blu", "grigio", "verde"];

require 'template/base.php';

?>