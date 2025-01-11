<?php

require_once 'bootstrap.php';

// Template di login
$templateParams["titolo"] = "Aeki - Login";
$templateParams["nome"] = "login_main.php"; 
$templateParams["js"] = array(
    "js/viewPasswordLogin.js",
    "js/loginModal.js",
    "js/login.js",
    "js/remember.js",
    "js/register.js"
);

require 'template/base.php';

?>
