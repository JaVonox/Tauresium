<?php
include_once "DBLoader.php";
$database = new Database();
$db = $database->getConnection();

$countryName = "";
$countryPass = "";
$worldCode = "";
$governmentType = "";
$countryColour = "";
$errorCode = "?";

$errorsOccured = False; //If this is false by the end no errors occured
$possibleGovernmentTypes = ['Sultanate','Horde','ElectoralMonarchy','Theocracy','Monarchy','Libertarian','Colonial','Democracy','MerchantRepublic','ClassicRepublic','Dictatorship','CommunistRepublic','Oligarchy','Anarchy','Tribe'];
$possibleColours = ['D66B67','DE965D','ECE788','B5DB7F','8ECDD2','8F97CF'];

$validWorldCode = False;
$occupiedColours = ['DUMMY'];

if($_POST['WorldCodeInput'] != "" && isset($_POST['WorldCodeInput']))
{
	$worldCode = $_POST['WorldCodeInput'];
	
	if(strlen($worldCode) != 16 || !ctype_alnum($worldCode))
	{
		$errorCode = $errorCode . "WorldCodeInput=INVALID" . $worldCode  . "&";
		$errorsOccured = True;
	}
	else
	{		
		//Check if world code is valid
		$validWorldCode = $database->getValidWorldCode($worldCode);
		
		if(!$validWorldCode) //add checksum here to stop breakin attempts
		{
			$errorCode = $errorCode . "WorldCodeInput=OCCUPIED" . $worldCode  . "&";
			$errorsOccured = True;
		}
		else
		{
			$errorCode = $errorCode . "WorldCodeInput=" . $worldCode  . "&";
			$occupiedColours = $database->getColoursInWorld($worldCode);
		}
		
	}
	
}
else
{
	$errorCode = $errorCode . "WorldCodeInput=MISSING&";
	$errorsOccured = True;
}

if($_POST['CountryNameInput'] != "" && isset($_POST['CountryNameInput']))
{
	$countryName = $_POST['CountryNameInput'];
	
	if(strlen($countryName) > 20 || !ctype_alpha($countryName))
	{
		$errorCode = $errorCode . "NationName=INVALID" . $countryName  . "&";
		$errorsOccured = True;
	}
	else 
	{
		
		if(!$database->getPlayersInWorld($countryName))
		{
			$errorCode = $errorCode . "NationName=" . $countryName  . "&";
		}
		else
		{
			$errorCode = $errorCode . "NationName=OCCUPIED" . $countryName  . "&";
			$errorsOccured = True;
		}
	}
}
else
{
	$errorCode = $errorCode . "NationName=MISSING&";
	$errorsOccured = True;
}

if(isset($_POST['CountryPassInput']) && $_POST['CountryPassInput'] != "")
{
	$countryPass = $_POST['CountryPassInput'];
	
	if(strlen($countryPass) > 25)
	{
		$errorCode = $errorCode . "Password=INVALID&";
		$errorsOccured = True;
	}
}
else
{
	$errorCode = $errorCode . "Password=INVALID&";
	$errorsOccured = True;
}

if(isset($_POST['GovernmentType']))
{
	$governmentType = $_POST['GovernmentType'];
	
	if(!in_array($governmentType,$possibleGovernmentTypes)) //this needs to be not for some reason??
	{
		$errorCode = $errorCode . "GovernmentType=INVALID&"; //only should occur if user has been messing with the source code
		$errorsOccured = True;
	}
	else
	{
		$errorCode = $errorCode . "GovernmentType=" . $governmentType  . "&";
	}
}
else
{
	$errorCode = $errorCode . "GovernmentType=MISSING&";
	$errorsOccured = True;
}

if(isset($_POST['CountryColour']))
{
	$countryColour = $_POST['CountryColour'];
	
	if(!in_array($countryColour,$possibleColours)) //this needs to be not for some reason??
	{
		$errorCode = $errorCode . "CountryColour=INVALID&"; //only should occur if user has been messing with the source code
		$errorsOccured = True;
	}
	else if($validWorldCode)
	{
		if(!in_array($countryColour,$occupiedColours))
		{
			$errorCode = $errorCode . "CountryColour=" . $countryColour  . "&";
		}
		else
		{
			$errorCode = $errorCode . "CountryColour=OCCUPIED" . $countryColour  . "&";
			$errorsOccured = True;
		}
	}
	else
	{
		$errorCode = $errorCode . "CountryColour=" . $countryColour  . "&";
	}
	
}
else
{
	$errorCode = $errorCode . "CountryColour=MISSING&";
	$errorsOccured = True;
}


if($errorsOccured == True)
{
	$errorCode = rtrim($errorCode,"&"); 
	header("Location: ../JoinSession.php" . $errorCode); //redirects to the joinsession page with the arguments
}
else
{
	$accountSuccess = $database->addNewCountry($countryName,$countryPass,$governmentType,$countryColour,$worldCode);
	if($accountSuccess)
	{
		echo "Temporary Page. Account creation successful.";
	}
	else
	{
		echo "Something went wrong during account creation. Please try again.";
	}
	
}
?>