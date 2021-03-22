<?php
include_once "Scripts/MapConnections.php"; //This includes databases
$database = new Database();
$db = $database->getConnection();

$selectedProvince = $_GET["ProvinceView"];

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
$mapConnect->init();
$sessionID = session_id();
$playerCountry = $_SESSION['Country'];

$provCountry = $mapConnect->CheckOwner($selectedProvince); //This could be modified to add title + json stuff

$cultureAccess = $mapConnect->CheckCulture($selectedProvince); //For culture
$economicAccess = $mapConnect->CheckEconomic($selectedProvince); //For economic 
$milAccess = $mapConnect->CheckMilitary($selectedProvince);
?>
<div id="BackgroundImage" style=";width:100%;overflow:auto;margin-left:auto;margin-right:auto;background-color:lightgrey;min-height:570px;background-color:white;background-image:linear-gradient(to bottom, rgba(255, 255, 255, 0.70), rgba(255, 255, 255, 0.70)),url('Backgroundimages/Ocean.png');background-repeat: no-repeat;background-position:center;background-size:120%;position:relative;">
<div id="MainDiv" style="background-color:lightgrey;width:70%;min-height:570px;overflow:auto;border:5px solid lightgrey;;margin-left:auto;margin-right:auto;float:center;border-left:5px solid black;border-right:5px solid black;" class="InformationText">
<button id="BackButton" style="background-color:#c0392b;color: white;text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';float:center;" onclick="document.location='Main.php'">< Back</button>
<table style="width:60%;margin-left:auto;margin-right:auto;">
<tr style="border-bottom:5px solid black;">
<td style="text-align:center;" colspan="2">
<font id="ProvCapital" style="font-family: Romanus;font-size:72px;"> Loading...</font>
	<i id="ProvRegion" style="font-family: Romanus;font-size:48px;"></i>
	<br>
	<font id="ProvType" style="font-family: Romanus;font-size:32px;">PROVINCE TYPE</font>
	<br><br>
	<i id="ProvOwner" style="font-family: Romanus;font-size:32px;">No Owner</i>
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
<table id="DetailsTable" style="margin-left:auto;margin-right:auto;">
</table>
</form>
</div>
</div>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
var provNameGet = "<?php echo $selectedProvince; ?>";
var provType = "<?php echo $provinceType; ?>";
var pageErrors = "<?php echo $buildError; ?>";

var ajaxProvInfo;
var playerName;

document.getElementById("ProvErrors").textContent = pageErrors;

BIGetProvViaID(provNameGet).then((value => {
	ajaxProvInfo = value; //Get value from ajax HTTP call and then store value. (as this uses the API it is already in JSON form)
	_loadAjax();
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
	
	if(playerName == "<?php echo $provCountry; ?>") //If the player is the owner
	{
		document.getElementById("ProvOwner").textContent = "Owned By: " + playerName;
	}
	else
	{
		var iconStyle = "width:64px;height:64px;vertical-align:middle;float:center;"
		var buttonStyle = "color: black;text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';float:center;";
		document.getElementById("DetailsForm").action = "Scripts/AttemptAnnex.php";
		
		document.getElementById("CultureIcon").setAttribute("style",iconStyle + "<?php echo $cultureAccess[0] ? '' : 'filter:grayscale(1);'?>");
		document.getElementById("EconomicIcon").setAttribute("style",iconStyle + "<?php echo $economicAccess[0] ? '' : 'filter:grayscale(1);'?>");
		document.getElementById("MilitaryIcon").setAttribute("style",iconStyle + "<?php echo $milAccess[0] ? '' : 'filter:grayscale(1);'?>");
		document.getElementById("CultureModDyn").innerHTML  = '<?php echo $cultureAccess[1];?>';
		document.getElementById("EconomicModDyn").innerHTML  = '<?php echo $economicAccess[1] . (": +" . $economicAccess[2] . "<br>")?>';
		document.getElementById("MilitaryModDyn").innerHTML  = '<?php echo "<br>" .$milAccess[1];?>';
		document.getElementById("CultureAnnex").setAttribute("style",buttonStyle + "<?php echo $cultureAccess[0] ? 'background-color:lightblue;' : 'background-color:#383838;pointer-events:none;'?>");
		document.getElementById("EconomicAnnex").setAttribute("style",buttonStyle +"<?php echo $economicAccess[0] ? 'background-color:lightgreen;' : 'background-color:#383838;pointer-events:none;'?>");
		document.getElementById("MilitaryAnnex").setAttribute("style",buttonStyle +"<?php echo $milAccess[0] ? 'background-color:pink;' : 'background-color:#383838;pointer-events:none;'?>");
		document.getElementById("invisible-provID").value = ajaxProvInfo.Province_ID;
		
		document.getElementById("ProvCulture").textContent = <?php echo $cultureAccess[2] ? 'ajaxProvInfo.Base_Culture_Cost' : '"Infinite"';?>;
		document.getElementById("ProvEconomic").textContent = (parseInt(ajaxProvInfo.Base_Economic_Cost) + parseInt(<?php echo $economicAccess[2]; ?>))<1000 ? parseInt(ajaxProvInfo.Base_Economic_Cost) + parseInt(<?php echo $economicAccess[2]; ?>) : "Infinite";
		document.getElementById("ProvMilitary").textContent = "<?php echo $milAccess[2] ?>";
		document.getElementById("CultureModSig").textContent = (ajaxProvInfo.Culture_Modifier * 100) + "%";
		document.getElementById("EconomicModEnv").textContent = (ajaxProvInfo.Economic_Enviroment_Modifier * 100) + "%";
		document.getElementById("MilitaryModEnv").textContent = (ajaxProvInfo.Military_Enviroment_Modifier * 100) + "%";

	}
}
</script>

<?php include "PageElements/Disclaimer.html" ?>
</body>
</html>