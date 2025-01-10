<?php
session_start();
define("UPLOAD_DIR", "./upload/");
require_once("utils/functions.php");
require_once("db/databaseGaia.php");
//require_once("utils/logger.php");

//database instance
$dbh = new DatabaseHelper("localhost", "root", "", "aekiDb");
//$logger = new Logger('app.log');    // loggare su file app.log da qualsiasi file php che richiede bootstrap
//$logger->log('Questo è un messaggio di log.'); //esempio
?>