<?php
session_start();
include_once "DBLoader.php";

//Needs value verification
//Needs modifying to form so it can use POST. Though hopefully the code should be robust enough to stop erroneous GET inputs anyway.
$invalidParams = False;
$player = "";
$provinceID = "";
$worldCode = "";
$provinceType = "";
isset($_SESSION['Country']) ? $player = $_SESSION['Country'] : $invalidParams=True;
isset($_GET['Province']) ? $provinceID = $_GET['Province'] : $invalidParams=True;
isset($_GET['WorldCode']) ? $worldCode = $_GET['WorldCode'] : $invalidParams=True;
isset($_GET['Type']) ? $provinceType = $_GET['Type'] : $invalidParams=True; // We can use this to calculate the expected next building - stopping players for buildings out of order.

$database = new Database();
$db = $database->getConnection();
$database->CanConstructBuilding($player,$provinceID,$worldCode,$provinceType);
	
if($invalidParams == False)
{	
	$canConstruct = $database->CanConstructBuilding($player,$provinceID,$worldCode,$provinceType); //Check for if build can be completed
	if($canConstruct[0] != "1")
	{
		$database->ConstructNewBuilding($player,$provinceID,$worldCode,$provinceType);
		header("Location: ../provinces.php?ProvinceView=" . $provinceID);
	}
	else
	{
		header("Location: ../provinces.php?ProvinceView=" . $provinceID . "&Errors=" . $canConstruct[1]);
	}
}
else
{
	header("Location: ../ErrorPage.php"); //For missing parameters - to be changed to include bad parameters.
}
?>