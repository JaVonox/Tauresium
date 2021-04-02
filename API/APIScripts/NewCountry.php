<?php

function _CreateNewCountry($_worldCode,$_countryName,$_password,$_governmentType,$_countryColour)
{
	$newAccountDB = new Database();
	$newAccountConn = $newAccountDB->getConnection();

	$countryName = "";
	$countryPass = "";
	$worldCode = "";
	$governmentType = "";
	$countryColour = "";
	$errorCode = "?";

	$errorsOccured = False; //If this is false by the end no errors occured
	$possibleGovernmentTypes = ['Sultanate','Horde','ElectoralMonarchy','Theocracy','Monarchy','Libertarian','Colonial','Democracy','MerchantRepublic','ClassicRepublic','Dictatorship','CommunistRepublic','Oligarchy','Anarchy','Tribe'];
	$possibleColours = ['ff0000','e67800','008000','1a88ff','ee82ee','5725c7'];

	$validWorldCode = False;
	$occupiedColours = ['DUMMY'];

	if($_worldCode != "NULL")
	{
		$worldCode = $_worldCode;
		
		if(strlen($worldCode) != 16 || !ctype_alnum($worldCode))
		{
			$errorCode = $errorCode . "WorldCodeInput=INVALID" . $worldCode  . "&";
			$errorsOccured = True;
		}
		else
		{		
			//Check if world code is valid
			$validWorldCode = $newAccountDB->getValidWorldCode($worldCode);
			
			if(!$validWorldCode) //add checksum here to stop breakin attempts
			{
				$errorCode = $errorCode . "WorldCodeInput=OCCUPIED" . $worldCode  . "&";
				$errorsOccured = True;
			}
			else
			{
				$errorCode = $errorCode . "WorldCodeInput=" . $worldCode  . "&";
				$occupiedColours = $newAccountDB->getColoursInWorld($worldCode);
			}
			
		}
		
	}
	else
	{
		$errorCode = $errorCode . "WorldCodeInput=MISSING&";
		$errorsOccured = True;
	}

	if($_countryName != "NULL")
	{
		$countryName = $_countryName;
		
		if(strlen($countryName) > 20 || !ctype_alpha($countryName))
		{
			$errorCode = $errorCode . "NationName=INVALID" . $countryName  . "&";
			$errorsOccured = True;
		}
		else 
		{
			
			if(!$newAccountDB->getDuplicatePlayers($countryName))
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

	if($_password != "NULL")
	{
		$countryPass = $_password;
		
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

	if($_governmentType != "NULL")
	{
		$governmentType = $_governmentType;
		
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

	if($_countryColour != "NULL")
	{
		$countryColour = $_countryColour;
		
		if(!in_array($countryColour,$possibleColours)) 
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

	//Return array = parameter - True/False (Success/Failure) - None/ErrorParams
	
	if($errorsOccured == True)
	{
		$errorCode = rtrim($errorCode,"&"); 
		return(array(True,$errorCode));
	}
	else
	{
		$accountSuccess = $newAccountDB->addNewCountry($countryName,$countryPass,$governmentType,$countryColour,$worldCode);
		if($accountSuccess)
		{
			return(array(False,"null"));
		}
		else
		{
			return(array(True,"EtcFail"));
		}
		
	}
}

?>