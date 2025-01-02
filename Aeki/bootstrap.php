<?php
session_start();
define("UPLOAD_DIR", "./upload/");
require_once("utils/functions.php");
require_once("db/databasePoz.php");
require_once("db/databaseGaia.php");

//database instance
$dbh = new DatabaseHelper("localhost", "root", "", "aekiDb");
?>