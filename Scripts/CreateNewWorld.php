<?php
require "../API/APIScripts/NewWorld.php"; //runs API POST script directly.
require "DBLoader.php";


$worldName = (!isset($_POST['WorldName']) ? "" : $_POST['WorldName'] );
$mapType = (!isset($_POST['MapType']) ? "" : $_POST['MapType']);
$speedType = (!isset($_POST['GameSpeed']) ? "" : $_POST['GameSpeed'] );

$parameters = _CreateNewWorld($worldName,$mapType,$speedType);

$errorsOccured = $parameters[0];
$returnCode = $parameters[1];

if($errorsOccured == True && $returnCode !=  "EtcFail")
{
	$returnCode = rtrim($returnCode,"&"); 
	header("Location: ../NewSession.php" . $returnCode); //redirects to the worldCreate page with the arguments
}
else if($errorsOccured == True && $returnCode == "EtcFail")
{
	header("Location: ../ErrorPage.php?Error=WorldCreateFail"); 
}
else //TODO reorder to place this condition first and unknown error last.
{
	header("Location: ../SessionSuccess.php?Type=World&Code=" . $returnCode); //Errorcode in this context refers to the w	
}
?>