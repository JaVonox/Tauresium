<?php
//this is a very temporary login system. There are 100% better ways to do this, plus this might be insecure because it uses a GET
include_once "DBLoader.php";
$loginRequest = $_POST['LoginInput'];
$passwordRequest = hash('sha256',$_POST['PasswordInput'],false); //hash algorithm also used in account creation.

$database = new Database();
$db = $database->getConnection();
$returnBool = $database->verifyIdentity($loginRequest,$passwordRequest);

if($returnBool == True)
{
	session_start();
	$_SESSION['Country'] = $loginRequest; //Session variables are serverside
	header("Location: ../Main.php");
}
else
{
	header("Location: ../LoginFail.php");
}
?>