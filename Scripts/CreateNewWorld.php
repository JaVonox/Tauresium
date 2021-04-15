<?php
require "CallAPICurl.php";

$worldName = (!ctype_alnum($_POST['WorldName']) ? "NULL" : $_POST['WorldName'] );
$mapType = (!isset($_POST['MapType']) ? "NULL" : $_POST['MapType']);
$speedType = (!isset($_POST['GameSpeed']) ? "NULL" : $_POST['GameSpeed'] );

$curlResponse = json_decode(CurlCustPOSTRequest("World/" . $worldName . "/" . $mapType . "/" . $speedType)); 

$errorsOccured = $curlResponse[0];
$returnCode = $curlResponse[1];

if($errorsOccured == True && $returnCode !=  "EtcFail")
{
	$returnCode = rtrim($returnCode,"&"); 
	header("Location: ../NewSession.php" . $returnCode); //redirects to the worldCreate page with the arguments
}
else if($errorsOccured == True && $returnCode == "EtcFail")
{
	header("Location: ../ErrorPage.php?Error=WorldCreateFail"); 
}
else if($errorsOccured == False)
{
	header("Location: ../SessionSuccess.php?Type=World&Code=" . $returnCode); 
}
else
{
	header("Location: ../ErrorPage.php?Error=CountryCreationFail"); 
}
?>