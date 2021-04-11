<?php
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
	$_SESSION['APIKEY'] = $database->ReturnAPIKey($_SESSION['Country']); //This API key will be used when sending any requests via the API.  
	header("Location: ../Main.php");
}
else
{
	header("Location: ../LoginFail.php");
}
?>