<?php
include_once "DBLoader.php";

$database = new Database();
$db = $database->getConnection();
$returnedValue = $database->ReturnLogin(session_id());

if($returnedValue == "")
{
	header("Location: ./ErrorPage.php"); //this should be changed to a custom page
}
?>