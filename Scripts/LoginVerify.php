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
	$database->AddNewSession(session_id(),$loginRequest);
	$_SESSION['Active'] = "T";
	header("Location: ../Main");
}
else
{
	header("Location: ../LoginFail");
}
?>