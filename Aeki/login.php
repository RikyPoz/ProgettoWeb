<?php

require_once 'bootstrap.php';

// Template di login
$templateParams["titolo"] = "Aeki - Login";
$templateParams["nome"] = "login_main.php"; 
$templateParams["js"] = array(
    "js/loginModal.js",
    "js/login.js",
    "js/remember.js",
    "js/register.js",
    "js/viewPassword.js"
);

require 'template/base.php';

?>
