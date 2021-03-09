<?php
include_once "DBLoader.php";
session_start();

$database = new Database();
$db = $database->getConnection();

session_unset();
session_destroy();
header("Location: ../index.php");
?>