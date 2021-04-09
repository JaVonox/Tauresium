<?php
include_once "Scripts/MapConnections.php"; //This includes databases
$database = new Database();
$db = $database->getConnection();

$selectedProvince = $_GET["ProvinceView"]; //Use for API calls.

if($selectedProvince == Null)
{
	header("Location: ErrorPage.php?Error=NoSelectedProvince"); //if no variables were passed.
}

if(empty($database->getProvinceDetail($selectedProvince))) //if the province does not exist. Maybe needs modification. TODO
{
	header("Location: ErrorPage.php?Error=ProvinceDoesNotExist"); 
}

$provinceType = $database->GetProvinceType($selectedProvince)[0];
$buildError = (!isset($_GET["Errors"]) ? "" : $_GET["Errors"] );
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="API/APIScripts/BuiltInAPICalls.js"></script>
<link rel="stylesheet" href="MainStyle.css">
<style>
table{
	width:100%;
}
</style>

<title>
Tauresium - Province
</title>

</head>
<body style="background-color:white;margin:0px;">

<?php include_once 'Scripts/PageUpdate.php'?>
<?php include_once 'Scripts/CheckLogin.php'?>
<?php
$mapConnect = new MapConnections();
$mapConnect->init($_SESSION['Country']);
$sessionID = session_id();
$playerCountry = $_SESSION['Country'];
$playerWorld = $database->ReturnWorld($_SESSION['Country']);
$provBonuses = $database->GetConstructedBonuses($selectedProvince,$playerWorld);

$provCountry = $mapConnect->CheckOwner($selectedProvince);
?>
<div id="BackgroundImage" style=";width:100%;overflow:auto;margin-left:auto;margin-right:auto;background-color:lightgrey;min-height:570px;background-color:white;background-image:linear-gradient(to bottom, rgba(255, 255, 255, 0.70), rgba(255, 255, 255, 0.70)),url('Backgroundimages/Ocean.png');background-repeat: no-repeat;background-position:center;background-size:120%;position:relative;">
<div id="MainDiv" style="background-color:lightgrey;width:70%;min-height:570px;overflow:auto;border:5px solid lightgrey;;margin-left:auto;margin-right:auto;border-left:5px solid black;border-right:5px solid black;" class="InformationText">
<button id="BackButton" style="background-color:#c0392b;color: white;text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';" onclick="document.location='Main.php'">< Back</button>
<table style="width:60%;margin-left:auto;margin-right:auto;">
<tr style="border-bottom:5px solid black;">
<td style="text-align:center;" colspan="2">
<font id="ProvCapital" style="font-family: Romanus;font-size:72px;"> Loading...</font>
	<i id="ProvRegion" style="font-family: Romanus;font-size:48px;"></i>
	<br>
	<font id="ProvType" style="font-family: Romanus;font-size:32px;"></font>
	<br><br>
	<i id="ProvOwner" style="font-family: Romanus;font-size:32px;"></i>
	<br>
	<i id="ProvClimate"></i>
	<br><br><br>
</td>
</tr>
<tr>
<td style="text-align:center;border-bottom:3px solid black;">
	<font id="ProvPopulation" style="font-size:16px;"></font>
	<br>
	<font id="ProvHDI" style="font-size:16px;"></font>
	<br>
	<font id="ProvGDP" style="font-size:16px;"></font>
</td>	
</tr>
<tr style="border-bottom:3px solid black;">
<td style="text-align:center;">
	<br><br>
	<font id="ProvInfo" style="font-size:18px;"></font>
</td>
</tr>
</table>
<br>
<table  style="margin-left:auto;margin-right:auto;text-align:center;">
<tr><td><font id="ProvErrors" style="font-family: Arial;font-size:24px;color:red;">Loading...</font></td></tr>
</table>
<br>
<form id="DetailsForm" method="POST">
<table style="margin-left:auto;margin-right:auto;width:45%;margin-bottom:30px;">
<tr><td></td></tr>
<tr style="text-align:center;font-size:24px;"><td>The infrastructure in this location provides the following bonuses to its owner:</td></tr>
<tr><td><br></td></tr>
<tr style="text-align:center;font-size:20px;"><td id="MilCapMod">+0 Military Capacity</td></tr>
<tr style="text-align:center;font-size:20px;"><td id="DefStrMod">+0% Local Defensive Strength</td></tr>
<tr style="text-align:center;font-size:20px;"><td id="BuildMod">-0% Local Build Cost</td></tr>
</table>
<table id="DetailsTable" style="margin-left:auto;margin-right:auto;">

</table>
</form>
</div>
</div>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

<script>
var provNameGet = "<?php echo $selectedProvince; ?>";
var provType = "<?php echo $provinceType; ?>";
var pageErrors = "<?php echo $buildError; ?>";
var buildingModifiers = <?php echo json_encode($provBonuses); ?>;

var ajaxProvInfo;
var playerName;

document.getElementById("ProvErrors").textContent = pageErrors;

BIGetProvViaID(provNameGet).then((value => {
	ajaxProvInfo = value; //Get value from ajax HTTP call and then store value. (as this uses the API it is already in JSON form)
	_loadAjax();
}))
.fail((value => {
	window.location.href = " ErrorPage.php?Error=BadProvince";
}));

function _loadAjax()
{
	playerName = "<?php echo $playerCountry; ?>";

	if(playerName != "<?php echo $provCountry; ?>") //If the player is the owner
	{
		$(document).ready(function(){
			$("#DetailsTable").load("PageElements/ProvinceViewTables/Annex.php", function(responseTxt, statusTxt, xhr){
			if(statusTxt == "success")
				_loadDetails();
				_loadAnnexButtons();
			});
		});	
	}
	else
	{
		$(document).ready(function(){
			$("#DetailsTable").load("PageElements/ProvinceViewTables/Improve.php?selectedProvince=" + "<?php echo $selectedProvince; ?>", function(responseTxt, statusTxt, xhr){
			if(statusTxt == "success")
				_loadDetails();
			});
		});	
	}
}

function _loadDetails()
{
	document.getElementById("ProvCapital").textContent = ajaxProvInfo.Capital;
	document.getElementById("ProvType").textContent = "Province Focus: " + provType;
	document.getElementById("ProvRegion").textContent = "," + ajaxProvInfo.Region;
	document.getElementById("ProvClimate").textContent = ajaxProvInfo.Climate + " - " + (ajaxProvInfo.Coastal == 1 ? "Coastal - " + ajaxProvInfo.Coastal_Region : "Landlocked");
	document.getElementById("ProvPopulation").textContent = "Population: " + ajaxProvInfo.City_Population_Total;
	document.getElementById("ProvHDI").textContent = "HDI: " + ajaxProvInfo.National_HDI;
	document.getElementById("ProvGDP").textContent = "Nominal GDP per Capita: " +ajaxProvInfo.National_Nominal_GDP_per_capita;
	document.getElementById("ProvInfo").textContent = ajaxProvInfo.Description;
	document.getElementById("BackgroundImage").style.backgroundImage = "linear-gradient(to bottom, rgba(255, 255, 255, 0.20), rgba(255, 255, 255, 0.20)),url('Backgroundimages/" + ajaxProvInfo.Climate + ".png')";
	document.getElementById("ProvOwner").textContent = "Owned By: " + "<?php echo $provCountry; ?>";
	
	document.getElementById("MilCapMod").textContent = "+" + (buildingModifiers.Bonus_Mil_Cap+15) + " Military Capacity";
	document.getElementById("DefStrMod").textContent = "+" + buildingModifiers.Bonus_Def_Strength + "% Local Defensive Strength";
	document.getElementById("BuildMod").textContent = "-" + buildingModifiers.Bonus_Build_Cost + "% Local Build Cost";
}

function _loadAnnexButtons()
{
	var iconStyle = "width:64px;height:64px;vertical-align:middle;"
	var buttonStyle = "color: black;text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';";
		
	BIGetProvCosts(provNameGet,playerName).then((apiReturn => {
		document.getElementById("DetailsForm").action = "Scripts/AttemptAnnex.php";
		
		//Possible property checks if the player has enough points to annex
		document.getElementById("CultureIcon").setAttribute("style",iconStyle + (apiReturn.Culture_Possible==false?"filter:grayscale(1);":""));
		document.getElementById("EconomicIcon").setAttribute("style",iconStyle + (apiReturn.Economic_Possible==false?"filter:grayscale(1);":""));
		document.getElementById("MilitaryIcon").setAttribute("style",iconStyle + (apiReturn.Military_Possible==false?"filter:grayscale(1);":""));
		document.getElementById("CultureModDyn").innerHTML  = apiReturn.Culture_Desc;
		document.getElementById("EconomicModDyn").innerHTML  = apiReturn.Economic_Desc;
		document.getElementById("MilitaryModDyn").innerHTML  = apiReturn.Military_Desc;
		document.getElementById("CultureAnnex").setAttribute("style",buttonStyle + (apiReturn.Culture_Possible!=false?'background-color:lightblue;' : 'background-color:#383838;pointer-events:none;'));
		document.getElementById("EconomicAnnex").setAttribute("style",buttonStyle + (apiReturn.Economic_Possible!=false?'background-color:lightgreen;' : 'background-color:#383838;pointer-events:none;'));
		document.getElementById("MilitaryAnnex").setAttribute("style",buttonStyle +(apiReturn.Military_Possible!=false?'background-color:pink;' : 'background-color:#383838;pointer-events:none;'));
		document.getElementById("invisible-provID").value = ajaxProvInfo.Province_ID;
		
		document.getElementById("ProvCulture").textContent = apiReturn.Culture_Cost;
		document.getElementById("ProvEconomic").textContent = apiReturn.Economic_Cost;
		document.getElementById("ProvMilitary").textContent = apiReturn.Military_Cost;
		document.getElementById("CultureModSig").textContent = (ajaxProvInfo.Culture_Modifier * 100) + "%";
		document.getElementById("EconomicModEnv").textContent = (ajaxProvInfo.Economic_Enviroment_Modifier * 100) + "%";
		document.getElementById("MilitaryModEnv").textContent = (ajaxProvInfo.Military_Enviroment_Modifier * 100) + "%";
	}));
}
</script>

<?php include "PageElements/Disclaimer.html" ?>
</body>
</html>