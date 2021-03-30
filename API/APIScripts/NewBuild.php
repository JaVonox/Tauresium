<?php
function _CreateNewBuild($_country,$_provinceID,$_buildType)
{
	$database = new Database();
	$db = $database->getConnection();
	
	$player = $_country;
	$provinceID = $_provinceID;
	$worldCode = $database->ReturnWorld($player);
	$buildType = $_buildType;
	
	$canConstruct = $database->CanConstructBuilding($player,$provinceID,$worldCode,$buildType); //Check for if build can be completed
	if($canConstruct[0] != "1")
	{
		$buildSuccess = $database->ConstructNewBuilding($player,$provinceID,$worldCode,$buildType);
		
		if($buildSuccess != "BAD")
		{
			return array(False,"OK");
		}
		else
		{
			return array(True,$canConstruct[1]);
		}
	}
	else
	{
		return array(True,$canConstruct[1]);
	}
}
?>