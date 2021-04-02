<?php

function _CreateNewWorld($_worldName,$_mapType,$_speed)
{
	$newWorldDB = new Database();
	$newWorldConn = $newWorldDB->getConnection();
	
	$errorCode = "?";
	$worldName = "";
	$mapType = "";
	$speed = "";

	$errorsOccured = False; //If this is false by the end no errors occured
	$possibleMaps = ['Earth'];
	$possibleSpeeds = ['VeryQuick','Quick','Normal','Slow'];

	if($_worldName != "NULL" && isset($_worldName))
	{
		$worldName = $_worldName;
		
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

	if($_mapType != "NULL" && isset($_mapType))
	{
		$mapType = $_mapType;
		
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

	if($_speed != "NULL")
	{
		$speed = $_speed;
		
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
		return(array(True,$errorCode));
	}
	else
	{
		$worldSuccess = $newWorldDB->addNewWorld($worldName,$mapType,$speed);
		if($worldSuccess)
		{
			return(array(False,$worldSuccess)); //Pass back Code
		}
		else
		{
			return(array(True,"EtcFail"));
		}
		
	}
}
?>