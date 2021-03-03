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
	//ecoHandle
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
	if($adjacent) //Last check to ensure that this is valid. Check includes cost+adjacency
	{
		$database->AnnexLocationPeaceful($database->ReturnLogin($_POST['invisible-playerSession']),$_POST['invisible-provID'],"Culture_Influence", $database->getProvinceDetail($_POST['invisible-provID'])[0]['Culture_Cost']);
		header("Location: ../Main.php");
	}
}
?>