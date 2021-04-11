<?php
require "CallAPICurl.php";

if(!isset($_SESSION)) 
{ 
   session_start(); 
} 

$provID = (!isset($_POST['invisible-provID']) ? "" : $_POST['invisible-provID']);
$pointType = "";

if (isset($_POST['CultureAnnex']))
{
	$pointType = "C";
}
else if(isset($_POST['EcoAnnex']))
{
	$pointType = "E";
}
else if(isset($_POST['MilAnnex']))
{
	$pointType = "M";
}

$curlResponse = json_decode(CurlCustPOSTRequest("Province/" . $provID . "/" . $_SESSION['APIKEY'] . "/" . $pointType)); 

$responseCode = $curlResponse;

if($responseCode == "SUCCESS")
{
	header("Location: ../Main.php");
}
else
{
	header("Location: ../ErrorPage.php?Error=InvalidAnnexRequest");
}
?>
