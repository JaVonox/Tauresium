<?php
include_once "DBLoader.php";
session_start();

$database = new Database();
$db = $database->getConnection();
$database->KillSession(session_id());

$_SESSION = array();
session_destroy();
header("Location: ../index.php");
?>