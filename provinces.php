<?php
include_once "Scripts/DBLoader.php";

$selectedProvince = $_GET["ProvinceView"];
if($selectedProvince == Null)
{
	header("Location: ErrorPage.php"); //if no variables were passed.
}

$database = new Database();
$db = $database->getConnection();
$loadedProvince = json_encode($database->getProvinceDetail($selectedProvince));

if($loadedProvince == "[]") //if the province does not exist
{
	header("Location: ErrorPage.php"); 
}

?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
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

<div id="BackgroundImage" style=";width:100%;overflow:auto;margin-left:auto;margin-right:auto;background-color:lightgrey;min-height:570px;background-color:white;background-image:linear-gradient(to bottom, rgba(255, 255, 255, 0.70), rgba(255, 255, 255, 0.70)),url('Backgroundimages/Ocean.png');background-repeat: no-repeat;background-position:center;background-size:120%;position:relative;">
<div style="background-color:lightgrey;width:70%;min-height:570px;overflow:auto;border:5px solid lightgrey;;margin-left:auto;margin-right:auto;float:center;border-left:5px solid black;border-right:5px solid black;" class="InformationText">
<button id="BackButton" style="background-color:#c0392b;color: white;text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';float:center;" onclick="document.location='Main.php'">< Back</button>
<table style="width:60%;margin-left:auto;margin-right:auto;">
<tr style="border-bottom:5px solid black;">
<td style="text-align:center;" colspan="2">
<font id="ProvCapital" style="font-family: Romanus;font-size:72px;"> Null, </font>
	<i id="ProvRegion" style="font-family: Romanus;font-size:48px;">Null</i>
	<br>
	<i id="ProvClimate">Marine</i>
	<br><br><br>
</td>
</tr>
<tr>
<td style="text-align:center;border-bottom:3px solid black;">
	<font id="ProvPopulation" style="font-size:16px;">City Population: Zero</font>
	<br>
	<font id="ProvHDI" style="font-size:16px;">HDI: Zero</font>
	<br>
	<font id="ProvGDP" style="font-size:16px;">Nominal GDP per Capita: Zero</font>
</td>	
</tr>
<tr style="border-bottom:3px solid black;">
<td style="text-align:center;">
	<br><br>
	<font id="ProvInfo" style="font-size:18px;">Description</font>
</td>
</tr>
</table>
<br><br>
<table style="width:25%;margin-left:auto;margin-right:auto;">
<tr style="border-bottom:1px solid black;">
<td ></td>
<td align="center"><img src="Assets/CultureIcon.png" style="width:64px;height:64px;vertical-align:middle;float:center;"/> </td>
<td align="center"><img src="Assets/EconomicIcon.png" style="width:64px;height:64px;vertical-align:middle;float:center;"/> </td>
<td align="center"><img src="Assets/MilitaryIcon.png" style="width:64px;height:64px;vertical-align:middle;float:center;"/> </td>
</tr>
<tr id="EnviromentalModifier" style="text-align:center;">
<td>Enviroment:</td>
<td><font id="CultureModEnv"> 0% </font></td>
<td><font id="EconomicModEnv"> 0% </font></td>
<td><font id="MilitaryModEnv"> 0% </font></td>
</tr>
<tr id="SignificanceModifer" style="text-align:center;">
<td>Significance:</td>
<td> <font id="CultureModSig"> 0% </font></td>
<td><font id="EconomicModSig"> 0% </font></td>
<td><font id="MilitaryModSig"> 0% </font></td>
</tr>
<tr id="DynamicModifier" style="text-align:center;">
<td>Other:</td>
<td><font id="CultureModDyn"> 0% </font></td>
<td><font id="EconomicModDyn"> 0% </font></td>
<td><font id="MilitaryModDyn"> 0% </font></td>
</tr>
<tr style="border-top:1px solid black;">
<td></td>
<td align="center"><b id="ProvCulture" style="font-size:42px"> Infinite</b></td>
<td align="center"><b id="ProvEconomic" style="font-size:42px"> Infinite</b></td>
<td align="center"><b id="ProvMilitary" style="font-size:42px">Infinite</b></td>
</tr>
<tr>
<td></td>
<td> <button id="CultureAnnex" style="background-color:lightblue;color: black;text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';float:center;" onclick="">Annex Diplomatically</button> </td>
<td> <button id="EconomicAnnex" style="background-color:lightgreen;color: black;text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';float:center;" onclick="">Annex Economically</button>  </td>
<td><button id="MilitaryAnnex" style="background-color:pink;color: black;text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';float:center;" onclick="">Annex Militarily</button> </td>
</tr>
</table>
</div>
</div>
<script>
var phpArray = <?php echo $loadedProvince ?>;
var selectedProvince = phpArray[0];

document.getElementById("ProvCapital").textContent = selectedProvince.Capital;
document.getElementById("ProvRegion").textContent = "," + selectedProvince.Region;
document.getElementById("ProvClimate").textContent = selectedProvince.Climate + " - " + (selectedProvince.Coastal == 1 ? "Coastal - " + selectedProvince.Coastal_Region : "Landlocked");
document.getElementById("ProvPopulation").textContent = "Population: " + selectedProvince.City_Population_Total;
document.getElementById("ProvHDI").textContent = "HDI: " + selectedProvince.National_HDI;
document.getElementById("ProvGDP").textContent = "Nominal GDP per Capita: " +selectedProvince.National_Nominal_GDP_per_capita;
document.getElementById("ProvCulture").textContent = selectedProvince.Culture_Cost;
document.getElementById("ProvEconomic").textContent = selectedProvince.Economic_Cost;
document.getElementById("ProvMilitary").textContent = selectedProvince.Military_Cost;
document.getElementById("ProvInfo").textContent = selectedProvince.Description;
document.getElementById("ProvMilitary").textContent = selectedProvince.Military_Cost;

document.getElementById("CultureModSig").textContent = (selectedProvince.Culture_Modifier * 100) + "%";
document.getElementById("EconomicModEnv").textContent = (selectedProvince.Economic_Enviroment_Modifier * 100) + "%";
document.getElementById("MilitaryModEnv").textContent = (selectedProvince.Military_Enviroment_Modifier * 100) + "%";
document.getElementById("BackgroundImage").style.backgroundImage = "linear-gradient(to bottom, rgba(255, 255, 255, 0.20), rgba(255, 255, 255, 0.20)),url('Backgroundimages/" + selectedProvince.Climate + ".png')";

</script>

<?php include "PageElements/Disclaimer.html" ?>
</body>
</html>