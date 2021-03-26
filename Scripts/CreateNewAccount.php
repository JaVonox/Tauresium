<?php
require "../API/APIScripts/NewCountry.php"; //runs API POST script directly.
require "DBLoader.php";


$worldCode = (!isset($_POST['WorldCodeInput']) ? "" : $_POST['WorldCodeInput'] );
$countryName = (!isset($_POST['CountryNameInput']) ? "" : $_POST['CountryNameInput'] );
$countryPass = (!isset($_POST['CountryPassInput']) ? "" : $_POST['CountryPassInput'] );
$countryColour = (!isset($_POST['CountryColour']) ? "" : $_POST['CountryColour'] );
$governmentType = (!isset($_POST['GovernmentType']) ? "" : $_POST['GovernmentType'] );

$parameters = _CreateNewCountry($worldCode,$countryName,$countryPass,$governmentType,$countryColour);

$errorsOccured = $parameters[0];
$errorCode = $parameters[1];

if($errorsOccured == True && $errorCode !=  "EtcFail")
{
	$errorCode = rtrim($errorCode,"&"); 
	header("Location: ../JoinSession.php" . $errorCode); //redirects to the joinsession page with the arguments
}
else if($errorsOccured == True && $errorCode == "EtcFail")
{
	header("Location: ../ErrorPage.php?Error=CountryCreationFail"); 
}
else //TODO reorder to place this condition first and unknown error last.
{
	header("Location: ../SessionSuccess.php?Type=Country"); 	
}
?>