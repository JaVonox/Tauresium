<?php
$countryName = "";
$worldCode = "";
$governmentType = "";
$countryColour = "";
$errorCode = "?";
$errorOccured = False; //If this is false by the end no errors occured
if($_POST['NationName'] != "" && isset($_POST['NationName']))
{
	$countryName = $_POST['NationName'];
	$errorCode = $errorCode . "NationName=" . $countryName  . "&";
}
else
{
	$errorCode = $errorCode . "NationName=MISSING&";
	$errorsOccured = True;
}

if($_POST['WorldCodeInput'] != "" && isset($_POST['WorldCodeInput']))
{
	$worldCode = $_POST['WorldCodeInput'];
	$errorCode = $errorCode . "WorldCodeInput=" . $worldCode  . "&";
}
else
{
	$errorCode = $errorCode . "WorldCodeInput=MISSING&";
	$errorsOccured = True;
}

if(isset($_POST['GovernmentType']))
{
	$governmentType = $_POST['GovernmentType'];
	$errorCode = $errorCode . "GovernmentType=" . $governmentType  . "&";
}
else
{
	$errorCode = $errorCode . "GovernmentType=MISSING&";
	$errorsOccured = True;
}

if(isset($_POST['CountryColour']))
{
	$countryColour = $_POST['CountryColour'];
	$errorCode = $errorCode . "CountryColour=" . $countryColour  . "&";
}
else
{
	$errorCode = $errorCode . "CountryColour=MISSING&";
	$errorsOccured = True;
}

$errorCode = rtrim($errorCode,"&"); 

if($errorsOccured == True)
{
	header("Location: ../JoinSession.php" . $errorCode); //redirects to the joinsession page with the arguments
}
?>