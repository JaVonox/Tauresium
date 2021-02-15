<?php
//this is a very temporary login system. There are 100% better ways to do this, plus this might be insecure because it uses a GET
include_once "DBLoader.php";
$loginRequest = $_GET['LoginInput'];

$database = new Database();
$db = $database->getConnection();
$returnBool = $database->verifyIdentity($loginRequest);

if($returnBool == True)
{
	header("Location: ../Main.php");
}
else
{
	header("Location: ../Index.php");
}
?>