<?php
require "../API/APIScripts/AnnexScript.php"; 
require "DBLoader.php";
require "MapConnections.php"; 

if(!isset($_SESSION)) 
{ 
   session_start(); 
} 

$database = new Database();
$db = $database->getConnection();

$countryName = (!isset($_SESSION['Country']) ? "" : $_SESSION['Country'] ); //This should never be an invalid country
$provID = (!isset($_POST['invisible-provID']) ? "" : $_POST['invisible-provID']);

if($_POST['invisible-provID'] == ""){
	header("Location: ../ErrorPage.php?Error=NoProvince");
}

$validHidden = $database->ReturnExists($_POST['invisible-provID']);

if(!$validHidden && $countryName != "")
{
	header("Location: ../ErrorPage.php?Error=InvalidProvinceID");
}

$returnArgs = "";
if (isset($_POST['CultureAnnex']))
{
	$returnArgs = _AnnexLocation($provID,$countryName,"C");
}
else if(isset($_POST['EcoAnnex']))
{
	$returnArgs = _AnnexLocation($provID,$countryName,"E");
}
else if(isset($_POST['MilAnnex']))
{
	$returnArgs = _AnnexLocation($provID,$countryName,"M");
}
else
{
	header("Location: ../ErrorPage.php?Error=InvalidPointType");
}

if($returnArgs == "SUCCESS")
{
	$returnCode = rtrim($returnCode,"&"); 
	header("Location: ../Main.php");
}
else
{
	header("Location: ../ErrorPage.php?HeyGuy=You_cheated_not_only_the_game_but_yourself"); //Probably noone will ever see this but its funny to me
}
?>
