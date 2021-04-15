<?php
require "CallAPICurl.php";

$worldCode = (!ctype_alnum($_POST['WorldCodeInput']) ? "NULL" : $_POST['WorldCodeInput'] );
$countryName = (!ctype_alnum($_POST['CountryNameInput']) ? "NULL" : $_POST['CountryNameInput'] );
$countryPass = (!isset($_POST['CountryPassInput']) ? "NULL" : $_POST['CountryPassInput'] );
$countryColour = (!isset($_POST['CountryColour']) ? "NULL" : $_POST['CountryColour'] );
$governmentType = (!isset($_POST['GovernmentType']) ? "NULL" : $_POST['GovernmentType'] );

$curlResponse = json_decode(CurlCustPOSTRequest("Country/" . $countryName . "/" . $countryPass . "/" . $worldCode . "/" . $governmentType . "/" . $countryColour)); 

$errorsOccured = $curlResponse[0];
$errorCode = $curlResponse[1];

if($errorsOccured == True && $errorCode !=  "EtcFail")
{
	$errorCode = rtrim($errorCode,"&"); 
	header("Location: ../JoinSession.php" . $errorCode); //redirects to the joinsession page with the arguments
}
else if($errorsOccured == True && $errorCode == "EtcFail")
{
	header("Location: ../ErrorPage.php?Error=CountryCreationFail"); 
}
else if($errorsOccured == False)
{
	header("Location: ../SessionSuccess.php?Type=Country"); 	
}
else
{
	header("Location: ../ErrorPage.php?Error=CountryCreationFail"); 
}
?>
