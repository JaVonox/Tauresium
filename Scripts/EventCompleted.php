<?php
require "CallAPICurl.php";

if(!isset($_SESSION))
{
	session_start();
}

$selectedOption = "";

if(isset($_POST['Option1'])){
	$selectedOption = "1";
}
else if(isset($_POST['Option2'])){
	$selectedOption = "2";
}
else if(isset($_POST['Option3'])){
	$selectedOption = "3";
}
else{
	header("Location: ../ErrorPage.php?Error=BadEventOption"); 
}	

$curlResponse = json_decode(CurlCustPOSTRequest("Event/" . $_SESSION['APIKEY'] . "/" . $selectedOption),true); 

$paramModifiers = "?MilInfluenceChanges=" . $curlResponse['Military_Gen_Modifier'] . "&EcoInfluenceChanges=" . $curlResponse['Economic_Gen_Modifier'] . "&CultInfluenceChanges=" . $curlResponse['Culture_Gen_Modifier'];
$paramModifiers = $paramModifiers . "&EventTitle=" . $curlResponse['Event_Title'] . "&OptionTitle=" . $curlResponse['Option_Desc'] . "&AddMil=" . $curlResponse['Added_Military_Influence'] . "&AddEco=" . $curlResponse['Added_Economic_Influence'] . "&AddCult=" . $curlResponse['Added_Culture_Influence'];
header("Location: ../EventResults.php" . $paramModifiers); 

?>