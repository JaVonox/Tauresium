<?php
include_once "DBLoader.php";
session_start();
$database = new Database();
$db = $database->getConnection();
$userInfo = $database->GetLoadedEvent(session_id());

$selectedOption = "";
if(isset($_GET['Option1'])){
	$selectedOption = "Option1";

}
else if(isset($_GET['Option2'])){
	$selectedOption = "Option2";
}
else if(isset($_GET['Option3'])){
	$selectedOption = "Option3";
}
else{
	header("Location: ../ErrorPage.php"); 
}

$eventChanges = $database->EventResults($userInfo['Country'],$userInfo['LoadedEvent'],$selectedOption);
$paramModifiers = "?MilInfluenceChanges=" . $eventChanges['Military_Gen_Modifier'] . "&EcoInfluenceChanges=" . $eventChanges['Economic_Gen_Modifier'] . "&CultInfluenceChanges=" . $eventChanges['Culture_Gen_Modifier'];
$paramModifiers = $paramModifiers . "&EventTitle=" . $eventChanges['Title'] . "&OptionTitle=" . $eventChanges['Option_Description'] . "&AddMil=" . $eventChanges['AddMil'] . "&AddEco=" . $eventChanges['AddEco'] . "&AddCult=" . $eventChanges['AddCult'];
header("Location: ../EventResults.php" . $paramModifiers); 

?>