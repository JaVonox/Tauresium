<?php
include_once "MapConnections.php"; 

$database = new Database();
$db = $database->getConnection();

if($_POST['invisible-provID'] == ""){
	header("Location: ../ErrorPage.php");
}

$validHidden = $database->ReturnExists($_POST['invisible-provID']);


if(!$validHidden)
{
	header("Location: ../ErrorPage.php");
}

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
	MilAnnex();
}

function CultAnnex()
{
	$mapConnect = new MapConnections();
	$mapConnect->init();
	$adjacent = $mapConnect->CheckCulture($_POST['invisible-provID']); 
	
	$database = new Database();
	$db = $database->getConnection();
	if($adjacent[0]) //Last check to ensure that this is valid. Check includes cost+adjacency
	{
		$database->AnnexLocationPeaceful($_SESSION['Country'],$_POST['invisible-provID'],"Culture_Influence", $database->getProvinceDetail($_POST['invisible-provID'])[0]['Culture_Cost']);
		header("Location: ../Main.php");
	}
	else
	{
		header("Location: ../ErrorPage.php?HeyGuy=You_cheated_not_only_the_game_but_yourself"); //Probably noone will ever see this but its funny to me
	}
}

function EcoAnnex()
{
	$mapConnect = new MapConnections();
	$mapConnect->init();
	$coastalConnection = $mapConnect->CheckEconomic($_POST['invisible-provID']); 

	$database = new Database();
	$db = $database->getConnection();
	if($coastalConnection[0]) 
	{
		$database->AnnexLocationPeaceful($_SESSION['Country'],$_POST['invisible-provID'],"Economic_Influence", intval($database->getProvinceDetail($_POST['invisible-provID'])[0]['Economic_Cost']) + intval($directCoastalConnection[2]));
		header("Location: ../Main.php");
	}
	else
	{
		header("Location: ../ErrorPage.php?HeyGuy=You_cheated_not_only_the_game_but_yourself");
	}
}

function MilAnnex()
{
	$mapConnect = new MapConnections();
	$mapConnect->init();
	$milConnection = $mapConnect->CheckMilitary($_POST['invisible-provID']); 

	$database = new Database();
	$db = $database->getConnection();
	if($milConnection[0]) 
	{
		if($milConnection[3])
		{
			$database->AnnexLocationPeaceful($_SESSION['Country'],$_POST['invisible-provID'],"Military_Influence", $milConnection[2]); 
			header("Location: ../Main.php");
		}
		else
		{
			$database->AnnexLocationForceful($_SESSION['Country'],$_POST['invisible-provID'],"Military_Influence", $milConnection[2]);
			header("Location: ../Main.php");
		}
	}
	else
	{
		header("Location: ../ErrorPage.php?HeyGuy=You_cheated_not_only_the_game_but_yourself");
	}
}
?>