<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="API/APIScripts/BuiltInAPICalls.js"></script>
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
<?php include_once "Scripts/MapConnections.php";?>
<?php include_once "Scripts/CheckLogin.php";?>
<?php
/* Session already exists */
$mapConnect = new MapConnections();
$mapConnect->init($_SESSION['Country']);
$playerCountry = $_SESSION['Country'];

$database = new Database();
$db = $database->getConnection();
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
	<div id="ProvCost" style="margin-left:auto;margin-right:auto;width:max-content;"></div>
	<br>
	<button id="ProvExamine" class="gameButton" style="visibility:hidden;text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';float:center;margin-bottom:10px;" onclick="document.location='Main.php'">View/Annex Province</button>
	</td>
	<td id="ProvTableRow" style="width:100%;height:100%;"> 
	</td>
	</tr>
	</table>
</div>

<script src="Libraries/SvgPanZoom/svg-pan-zoom.js"></script>

<script>
var selectedRegion = "Ocean";
var provinceArray; 
var occupiedArray = <?php echo $occupiedSet; ?>;
var invisibleProvinces = <?php echo $visibilitySet;?>;
var playerName = "<?php echo $playerCountry;?>";

BIGetAllProvs().then((value => {
	provinceArray = value; //Returns all provinces via ajax HTTP call
	_DrawSVG();
	_DrawProvinces();
}));

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
		document.getElementById("ProvCost").textContent = "";
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

		var selectedProvince = provinceArray[selectedRegion];
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
		
		document.getElementById("ProvCost").textContent = "Loading...";
		BIGetProvCosts(selectedProvince.Province_ID,playerName).then((value => {
			_LoadProvCosts(value);
		}));

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

function _LoadProvCosts(value) //This script loads the values for the province costs - which are now displayed on the map.
{
	var tableString ='<table><tr><td>';
	var anyAccess = false; //This value becomes true if the player meets the conditions, aside from cost, to take the province.
	
	if(value.Culture_Cost != "Infinite")
	{
		tableString += '<img src="Assets/CultureIcon.png" id="CultureIcon" style="width:24px;height:24px;' + (value.Culture_Possible==false?"filter:grayscale(1);":"") +'"/>'; //These statements grayscale the image if the player does not have enough points
		anyAccess = true;
	}
	
	tableString +="</td><td>";
	
	if(value.Economic_Cost != "Infinite")
	{
		tableString += '<img src="Assets/EconomicIcon.png" id="EconomicIcon" style="width:24px;height:24px;'+ (value.Economic_Possible==false?"filter:grayscale(1);":"") +'"/>';
		anyAccess = true;
	}

	tableString +="</td><td>";
	
	if(value.Military_Cost != "Infinite")
	{
		tableString += '<img src="Assets/MilitaryIcon.png" id="MilitaryIcon" style="width:24px;height:24px;' + (value.Military_Possible==false?"filter:grayscale(1);":"") +'"/>';
		anyAccess = true;
	}
	
	tableString += '</td></tr>';
	tableString += '<tr><td>';
	
	if(value.Culture_Cost != "Infinite")
	{
		tableString += value.Culture_Cost
	}
	
	tableString +="</td><td>";
	
	if(value.Economic_Cost != "Infinite")
	{
		tableString += value.Economic_Cost
	}

	tableString +="</td><td>";
	
	if(value.Military_Cost != "Infinite")
	{
		tableString += value.Military_Cost;
	}
	
	tableString += '</td>';
	tableString += '</tr></table>';
	
	if(value.Province_ID == selectedRegion) //Resynchronises the pull. If this statement is not true then the player has clicked on a different location.
	{
		if(anyAccess == false)
		{
			document.getElementById("ProvCost").textContent = "--Inaccessible--";
		}
		else
		{
			document.getElementById("ProvCost").innerHTML = tableString;
		}
	}
	else if(selectedRegion == "Ocean") //Prevents the program from displaying reloading when ocean is selected. 
	{
		document.getElementById("ProvCost").innerHTML = ""; 
	}
	else
	{
		document.getElementById("ProvCost").innerHTML = "Reloading..."; //This notifies the user that the program is going to reload the information for the new province.
	}
}

function _DrawSVG() //This dynamically loads all the province info from the API, and then allows for the use of the svgpanzoom library
{
	var inHTMLstring = "<svg id='SvgProvID' class='Provinces' onclick='_clickEvent()' style='background-color:#E6BF83;width:950px;height:562px;display:block;margin:auto;border:5px solid #966F33;'>"
	
	for(var element in provinceArray){
	inHTMLstring += "<polygon id='" + provinceArray[element]['Province_ID'] +"' points='"+ provinceArray[element]['Vertex1'] +" "+ provinceArray[element]['Vertex2'] +" "+ provinceArray[element]['Vertex3'] +"'/>";
	}
	
	inHTMLstring += "</svg>";
	
	document.getElementById("ProvTableRow").innerHTML = inHTMLstring;
	
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
}
</script>


<?php include "PageElements/Disclaimer.html" ?>

</body>
</html>