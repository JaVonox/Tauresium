<?php

function _AnnexLocation($provinceID,$playerCountry,$pointType)
{
	$annexDB = new Database();
	$annexDBconn = $annexDB->getConnection();

	if(!isset($_SESSION)) 
	{ 
	   session_start(); 
	} 

	$database = new Database();
	$db = $database->getConnection();

	$validHidden = $database->ReturnExists($provinceID);

	if(!$validHidden)
	{
		return "BAD";
	}

	if ($pointType == "C")
	{
		return CultAnnex($provinceID,$playerCountry);
	}
	else if($pointType == "E")
	{
		return EcoAnnex($provinceID,$playerCountry);
	}
	else if($pointType == "M")
	{
		return MilAnnex($provinceID,$playerCountry);
	}
	else
	{
		return "BAD";
	}

}
function CultAnnex($provinceID,$countryName)
{
	$mapConnect = new MapConnections();
	$mapConnect->init($countryName);
	$adjacent = $mapConnect->CheckCulture($provinceID); 
	
	$database = new Database();
	$db = $database->getConnection();
	
	if($adjacent[0]) //Last check to ensure that this is valid. Check includes cost+adjacency
	{
		$database->AnnexLocationPeaceful($countryName,$provinceID,"Culture_Influence", $database->getProvinceDetail($provinceID)[0]['Culture_Cost']);
		return "SUCCESS";
	}
	else
	{
		return "INVALID";
	}
}

function EcoAnnex($provinceID,$countryName)
{
	$mapConnect = new MapConnections();
	$mapConnect->init($countryName);
	$coastalConnection = $mapConnect->CheckEconomic($provinceID); 

	$database = new Database();
	$db = $database->getConnection();
	if($coastalConnection[0]) 
	{
		$database->AnnexLocationPeaceful($countryName,$provinceID,"Economic_Influence", intval($database->getProvinceDetail($provinceID)[0]['Economic_Cost']) + intval($coastalConnection[2]));
		return "SUCCESS";
	}
	else
	{
		return "INVALID";
	}
}

function MilAnnex($provinceID,$countryName)
{
	$mapConnect = new MapConnections();
	$mapConnect->init($countryName);
	$milConnection = $mapConnect->CheckMilitary($provinceID); 

	$database = new Database();
	$db = $database->getConnection();
	if($milConnection[0]) 
	{
		if($milConnection[3])
		{
			$database->AnnexLocationPeaceful($countryName,$provinceID,"Military_Influence", $milConnection[2]); 
			return "SUCCESS";
		}
		else
		{
			$database->AnnexLocationForceful($countryName,$provinceID,"Military_Influence", $milConnection[2]);
			return "SUCCESS";
		}
	}
	else
	{
		return "INVALID";
	}
}
?>