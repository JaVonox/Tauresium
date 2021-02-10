<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<link rel="stylesheet" href="MainStyle.css">
<script type="text/javascript" src="Scripts/BackgroundLoader.js"> </script>
<style>
table{
	width:100%;
	border:0px solid black;
	border-collapse:collapse;
}
tr{
	border:0px solid black;
}
td{
	border:0px solid black;
}
</style>

<title>
Tauresium - Index
</title>
</head>
<body style="background-color:white;margin:0px;">

<?php include_once 'PageElements/TopBar.php';?>
<?php include_once "Scripts/DBLoader.php";?>

<?php
$selectedProvince = htmlspecialchars($_GET["ProvinceView"]);
$database = new Database();
$db = $database->getConnection();
$loadedProvince = json_encode($database->getProvinceDetail($selectedProvince));
?>

<div id="MenuBar" style="background-color:#E4E4E4;width:100%;height:40px;border-bottom:4px solid black;"> 
	<button style="float:right;margin-right:20px;" class="menuButton" onclick="document.location='index.php'">Logout</button>
	<button style="margin-left:20px;" class="menuButton">World Information</button>
	<button class="menuButton">My Country</button>
	<button class="menuButton">Events</button>
</div>

<div style="background-color:lightgrey;width:95%;min-height:570px;overflow:auto;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">

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
<table style="width:15%;margin-left:auto;margin-right:auto;">
<tr>
<td align="center"><img src="Assets/CultureIcon.png" style="width:64px;height:64px;vertical-align:middle;float:center;"/> </td>
<td align="center"><img src="Assets/EconomicIcon.png" style="width:64px;height:64px;vertical-align:middle;float:center;"/> </td>
<td align="center"><img src="Assets/MilitaryIcon.png" style="width:64px;height:64px;vertical-align:middle;float:center;"/> </td>
</tr>
<td align="center"><font id="ProvCulture"> Infinite</font></td>
<td align="center"><font id="ProvEconomic"> Infinite</font></td>
<td align="center"><font id="ProvMilitary">Infinite</font></td>
</table>

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

document.getElementById("ProvExamine").onclick = function() { document.location='provinces.php?ProvinceView=' + selectedProvince.Province_ID; } //change from index
document.getElementById("ProvExamine").style.visibility = "visible";
</script>

<div class="Disclaimer">
	<p style="margin-left:10%;margin-right:10%;"> Program by 100505349.
	This web application is not intended to be an accurate representation of political borders or cultural boundaries. The map shown in this production is a rough triangulated map meant to serve as a
	representation - with regions being represented by relevant locations (which may not be placed properly).
	The map constructed in this application was made by hand by 100505349 - using image references to properly plot the coordinates </p>	
</div>
</body>
</html>