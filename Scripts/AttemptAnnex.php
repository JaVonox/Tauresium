<?php
include_once "MapConnections.php"; 

$database = new Database();
$db = $database->getConnection();

//Need to add verification of entered provID and sessionID since they are in hidden fields.
if (isset($_POST['CultureAnnex']))
{
	CultAnnex();
}
else if(isset($_POST['EcoAnnex']))
{
	EcoAnnex();
}
else if(isset($_POST['MilAnnex']))
{
	//milHandle
}

function CultAnnex()
{
	$mapConnect = new MapConnections();
	$mapConnect->init($_POST['invisible-playerSession']);
	$adjacent = $mapConnect->CheckCulture($_POST['invisible-provID']); 
	
	$database = new Database();
	$db = $database->getConnection();
	if($adjacent[0]) //Last check to ensure that this is valid. Check includes cost+adjacency
	{
		$database->AnnexLocationPeaceful($database->ReturnLogin($_POST['invisible-playerSession']),$_POST['invisible-provID'],"Culture_Influence", $database->getProvinceDetail($_POST['invisible-provID'])[0]['Culture_Cost']);
		header("Location: ../Main.php");
	}
}

function EcoAnnex()
{
	$mapConnect = new MapConnections();
	$mapConnect->init($_POST['invisible-playerSession']);
	$directCoastalConnection = $mapConnect->CheckEconomic($_POST['invisible-provID']); 

	$database = new Database();
	$db = $database->getConnection();
	if($directCoastalConnection[0]) 
	{
		$database->AnnexLocationPeaceful($database->ReturnLogin($_POST['invisible-playerSession']),$_POST['invisible-provID'],"Economic_Influence", intval($database->getProvinceDetail($_POST['invisible-provID'])[0]['Economic_Cost']) + intval($directCoastalConnection[2])); //Eco cost seems not to be working?
		header("Location: ../Main.php");
	}
}
?>