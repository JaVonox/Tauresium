<?php
include_once "DBLoader.php";
$database = new Database();
$db = $database->getConnection();

$errorCode = "?";
$worldName = "";
$mapType = "";
$speed = "";

$errorsOccured = False; //If this is false by the end no errors occured
$possibleMaps = ['Earth'];
$possibleSpeeds = ['Normal'];

if($_POST['WorldName'] != "" && isset($_POST['WorldName']))
{
	$worldName = $_POST['WorldName'];
	
	if(strlen($worldName) > 13 || !ctype_alpha($worldName))
	{
		$errorCode = $errorCode . "WorldName=INVALID" . $worldName  . "&";
		$errorsOccured = True;
	}
	else 
	{
		//There doesnt need to be any checking for if world names exist - primary key is the code so that needs to be checked for duplicates.
		$errorCode = $errorCode . "WorldName=" . $worldName  . "&";
	}
}
else
{
	$errorCode = $errorCode . "WorldName=MISSING&";
	$errorsOccured = True;
}

if(isset($_POST['MapType']))
{
	$mapType = $_POST['MapType'];
	
	if(!in_array($mapType,$possibleMaps)) 
	{
		$errorCode = $errorCode . "MapType=INVALID&"; //only should occur if user has been messing with the source code
		$errorsOccured = True;
	}
	else
	{
		$errorCode = $errorCode . "MapType=" . $mapType  . "&";
	}
	
}
else
{
	$errorCode = $errorCode . "MapType=MISSING&";
	$errorsOccured = True;
}

if(isset($_POST['GameSpeed']))
{
	$speed = $_POST['GameSpeed'];
	
	if(!in_array($speed,$possibleSpeeds)) 
	{
		$errorCode = $errorCode . "GameSpeed=INVALID&"; //only should occur if user has been messing with the source code
		$errorsOccured = True;
	}
	else
	{
		$errorCode = $errorCode . "GameSpeed=" . $speed  . "&";
	}
	
}
else
{
	$errorCode = $errorCode . "GameSpeed=MISSING&";
	$errorsOccured = True;
}

if($errorsOccured == True)
{
	$errorCode = rtrim($errorCode,"&"); 
	header("Location: ../NewSession" . $errorCode); //redirects to the new session page with the arguments
}
else
{
	$worldSuccess = $database->addNewWorld($worldName,$mapType,$speed);
	if($worldSuccess != False)
	{
		header("Location: ../SessionSuccess?Type=World&Code=" . $worldSuccess); 
	}
	else
	{
		header("Location: ../ErrorPage"); 
	}
	
}
?>