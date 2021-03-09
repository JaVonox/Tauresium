<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<link rel="stylesheet" href="MainStyle.css">
<style>
polygon{
		fill:#FFE7AB;stroke:black;stroke-width:1;
}
</style>

<title>
Tauresium - Game Page
</title>
</head>
<body style="background-color:white;margin:0px;">

<?php include_once 'Scripts/PageUpdate.php'?>
<?php include_once "Scripts/DBLoader.php";?>
<?php include_once "Scripts/CheckLogin.php";?>
<?php
/* Session already exists */
$database = new Database();
$db = $database->getConnection();
$provinceSet = json_encode($database->getProvinceArray());
$occupiedSet = json_encode($database->GetOccupation($_SESSION['Country']));
$visibilitySet = json_encode($database->GetVisibility($_SESSION['Country']));
?>

<div id="MapBack" style="background-color:lightgrey;min-height:600px;overflow:auto;background-color:white;background-image:linear-gradient(to bottom, rgba(255, 255, 255, 0.70), rgba(255, 255, 255, 0.70)),url('Backgroundimages/Ocean.png');background-repeat: no-repeat;background-position:center;background-size:120%;position:relative;">
	<table style="width:100%;height:100%;table-layout:fixed;overflow:auto;">
	<tr>
	<td style="width:400px;background-color:lightgrey;text-align:center;margin-left:auto;margin-right:auto;border: 5px solid grey;border-radius:15px;vertical-align:top;position:relative;left:30px;">
	<h1 id="ProvCapital" style="font-family: Romanus;font-size:32px;"> Ocean </h2>
	<i id="ProvRegion" style="font-family: Romanus;font-size:20px;">Ocean</i>
	<br>
	<img id="ProvinceImage" src="Assets/Ocean.png" style="border: solid 5px black;margin-left:auto;margin-right:auto;">
	<br>
	<font id="ProvClimate">Marine</font>
	<br><br>
	<font id="ProvOwner">Owned By: Unoccupied</font>
	<br><br>
	<font id="ProvPopulation">City Population: Zero</font>
	<br>
	<font id="ProvHDI">HDI: Zero</font>
	<br>
	<font id="ProvGDP">Nominal GDP per Capita: Zero</font>
	<br><br>
	<button id="ProvExamine" class="gameButton" style="visibility:hidden;text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';float:center;" onclick="document.location='Main.php'">View/Annex Province</button>
	</td>
	<td id="ProvTableRow" style="width:100%;height:100%;"> 
		<?php include_once 'PageElements/Maps/Earth.html'?>
	</td>
	</tr>
	</table>
</div>

<script>
var selectedRegion = "Ocean";
var provinceArray = <?php echo $provinceSet ?>;
var occupiedArray = <?php echo $occupiedSet ?>;
var invisibleProvinces = <?php echo $visibilitySet?>;

_DrawProvinces();

function _clickEvent(evt) 
{
	
	if (selectedRegion != "Ocean")
	{
		document.getElementById(selectedRegion).style.fill = "#FFE7AB";
	}
	
	if(event.target.id == "SvgProvID" || event.target.nodeName == "g")
	{
		selectedRegion = "Ocean";
		document.getElementById("ProvCapital").textContent = "Ocean";
		document.getElementById("ProvRegion").textContent = "Ocean";
		document.getElementById("ProvOwner").textContent = "Owned By: Unoccupied";
		document.getElementById("ProvClimate").textContent = "Marine";
		document.getElementById("ProvPopulation").textContent = "City Population: Zero";
		document.getElementById("ProvHDI").textContent = "HDI: Zero";
		document.getElementById("ProvGDP").textContent = "Nominal GDP per Capita: Zero";
		document.getElementById("ProvExamine").onclick = "";
		document.getElementById("ProvExamine").style.visibility = "hidden";
		
		document.getElementById("ProvinceImage").src = "Assets/Ocean.png";
		document.getElementById("MapBack").style.backgroundImage = "linear-gradient(to bottom, rgba(255, 255, 255, 0.70), rgba(255, 255, 255, 0.70)),url('Backgroundimages/Ocean.png')";
		_DrawProvinces();
	}
	else
	{
		_DrawProvinces();
		selectedRegion = event.target.id;
		var selectedProvince = provinceArray.find(element => element.Province_ID == selectedRegion);
		var selectedProvinceOwner = occupiedArray.find(element => element.Province_ID == selectedRegion);
		
		document.getElementById("ProvCapital").textContent = selectedProvince.Capital;
		document.getElementById("ProvRegion").textContent = selectedProvince.Region;
		
		if(selectedProvinceOwner !== undefined)
		{
			document.getElementById("ProvOwner").textContent = "Owned By: " + selectedProvinceOwner.Title + " " + selectedProvinceOwner.Country_Name;
			var redComponent = ((parseInt(selectedProvinceOwner.Colour[0],16) * 16) + parseInt(selectedProvinceOwner.Colour[1],16));
			var greenComponent = ((parseInt(selectedProvinceOwner.Colour[2],16) * 16) + parseInt(selectedProvinceOwner.Colour[3],16));
			var blueComponent = ((parseInt(selectedProvinceOwner.Colour[4],16) * 16) + parseInt(selectedProvinceOwner.Colour[5],16));
			document.getElementById("MapBack").style.backgroundImage = "linear-gradient(to bottom, rgba(" + redComponent + ", " + greenComponent + ", " + blueComponent + ", 0.30), rgba(" + redComponent + ", " + greenComponent + ", " + blueComponent + ", 0.60)),url('Backgroundimages/" + selectedProvince.Climate + ".png')";
		}
		else
		{
			document.getElementById("ProvOwner").textContent = "Owned By: Unoccupied";
			document.getElementById("MapBack").style.backgroundImage = "linear-gradient(to bottom, rgba(255, 255, 255, 0.70), rgba(255, 255, 255, 0.70)),url('Backgroundimages/" + selectedProvince.Climate + ".png')";
		}
		document.getElementById("ProvClimate").textContent = selectedProvince.Climate + " - " + (selectedProvince.Coastal == 1 ? "Coastal - " + selectedProvince.Coastal_Region : "Landlocked");
		document.getElementById("ProvPopulation").textContent = "City Population: " + selectedProvince.City_Population_Total;
		document.getElementById("ProvHDI").textContent = "HDI: " + selectedProvince.National_HDI;
		document.getElementById("ProvGDP").textContent = "Nominal GDP per Capita: " +selectedProvince.National_Nominal_GDP_per_capita;
		
		document.getElementById("ProvExamine").onclick = function() { document.location='provinces.php?ProvinceView=' + selectedProvince.Province_ID; } //change from index
		document.getElementById("ProvExamine").style.visibility = "visible";
		
		document.getElementById(event.target.id).style.fill = "#abc3ff";
		document.getElementById("ProvinceImage").src = "Assets/" + selectedProvince.Climate + ".png";
	}
}

function _DrawProvinces()
{
	for (i = 0; i < Object.keys(occupiedArray).length; i++)
	{
		document.getElementById(occupiedArray[i].Province_ID).style.fill = "#" + occupiedArray[i].Colour;
	}
	
	for (i = 0; i < Object.keys(invisibleProvinces).length; i++)
	{
		if(occupiedArray.some(occupiedArray => occupiedArray.Province_ID === invisibleProvinces[i].Province_ID)) //This checks if the invisible province is one that is supposed to be invisible, and draws it darkened if it is.
		{
			document.getElementById(invisibleProvinces[i].Province_ID).style.filter = 'brightness(35%)'; 
		}
		else
		{ 
			//This is more or less a "fog of war" system, but mostly serves to show players where they can go.
			document.getElementById(invisibleProvinces[i].Province_ID).style.fill = "#303030";
			document.getElementById(invisibleProvinces[i].Province_ID).style.filter = 'brightness(60%)'; 
		}
	}
	
}
</script>

<script src="Libraries/SvgPanZoom/svg-pan-zoom.js"></script>

<script>

beforePan = function(oldPan, newPan){ //This function is sourced from an example in the svg-pan-zoom documentation. 
  var stopHorizontal = false
	, stopVertical = false
	, gutterWidth = 940
	, gutterHeight = 532
	, sizes = this.getSizes()
	, leftLimit = -((sizes.viewBox.x + sizes.viewBox.width) * sizes.realZoom) + gutterWidth
	, rightLimit = sizes.width - gutterWidth - (sizes.viewBox.x * sizes.realZoom)
	, topLimit = -((sizes.viewBox.y + sizes.viewBox.height) * sizes.realZoom) + gutterHeight
	, bottomLimit = sizes.height - gutterHeight - (sizes.viewBox.y * sizes.realZoom)

  customPan = {}
  customPan.x = Math.max(leftLimit, Math.min(rightLimit, newPan.x))
  customPan.y = Math.max(topLimit, Math.min(bottomLimit, newPan.y))

  return customPan
}


var ProvinceZoom = svgPanZoom('#SvgProvID',{
  zoomScaleSensitivity: 0.5
, panEnabled: true
, dblClickZoomEnabled: false
, minZoom: 1
, maxZoom: 10
, beforePan: beforePan
});
 //This uses the svg-pan-zoom library (https://github.com/ariutta/svg-pan-zoom)
</script>

<?php include "PageElements/Disclaimer.html" ?>

</body>
</html>