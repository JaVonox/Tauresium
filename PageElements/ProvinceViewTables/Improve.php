<?php
if(!isset($_SESSION)) 
{ 
   session_start(); 
} 

$selectedProvince = $_GET["selectedProvince"]; //Gets from AJAX load.
?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="MainStyle.css">
<style>
.tippy-box[data-theme~='buildBox']{
  background-color: white;
  color: black;
}

.tippy-box[data-theme~='buildBox'] > .tippy-arrow::before {
  transform: scale(0);
}
</style>
</head>

<table style="border-collapse:separate;margin-left:auto;margin-right:auto;width:45%;border-spacing:25px;">
<tr style="text-align:center;font-size:36px;font-family:Romanus;">
<td style="border-bottom:2px solid black;" id="Col1">Buildings</td>
<td style="border-bottom:2px solid black;" id="Col2">Buildings</td>
</tr>
<tr style="text-align:center;">
<td><img class="BuildingSlot" id="Building1" src="Assets/PlaceholderBox.png" style="width:96px;height:96px;border: 5px solid black;"/></td>
<td><img class="BuildingSlot" id="Building6" src="Assets/PlaceholderBox.png" style="width:96px;height:96px;border: 5px solid black;"/></td>
</tr>
<tr style="text-align:center;">
<td><img class="BuildingSlot" id="Building2" src="Assets/PlaceholderBox.png" style="width:96px;height:96px;border: 5px solid black;"/></td>
<td><img class="BuildingSlot" id="Building7" src="Assets/PlaceholderBox.png" style="width:96px;height:96px;border: 5px solid black;"/></td>
</tr>
<tr style="text-align:center;">
<td><img class="BuildingSlot" id="Building3" src="Assets/PlaceholderBox.png" style="width:96px;height:96px;border: 5px solid black;"/></td>
<td><img class="BuildingSlot" id="Building8"src="Assets/PlaceholderBox.png" style="width:96px;height:96px;border: 5px solid black;"/></td>
</tr>
<tr style="text-align:center;">
<td><img class="BuildingSlot" id="Building4" src="Assets/PlaceholderBox.png" style="width:96px;height:96px;border: 5px solid black;"/></td>
<td><img class="BuildingSlot" id="Building9" src="Assets/PlaceholderBox.png" style="width:96px;height:96px;border: 5px solid black;"/></td>
</tr>
</table>

<div id="PopUpDiv" style="display:none;">
	<img id="BuildIcon" src="Assets/PlaceholderBox.png" style="display:block;margin-left:auto;margin-right:auto;width:128px;height:128px;"/>
	<table style="width:90%;margin-left:auto;margin-right:auto;text-align:center;border-collapse:collapse;">
		<th id="BuildName" style="font-family:Romanus;font-size:32px;border-bottom:2px solid black;">Building Name</th>
		<tr><td style="font-size:24px;" id="BuildCost" >Cost: 999</td></tr>
		<tr><td id="BuildCap" style="font-size:18px">+99 Military Capacity</td></tr>
		<tr><td id="BuildDef" style="font-size:18px">+99% Local Defensive Strength</td></tr>
		<tr><td id="BuildCostMod" style="font-size:18px">-99% Local Build Cost</td></tr>
		<tr><td id="BuildConstruct"style="font-size:22px">Click To Construct</td><tr>
	</table>
</div>

<script> //Tippy is defined in the provinces page
tippy('.BuildingSlot', {
	content:'Loading',
	theme:'buildBox',
	placement:'right',
	allowHTML: true,
	duration:[400, 200],
	onShow(instance)
	{
		_loadPopupBuilding(instance.reference.id);
		instance.setContent(document.getElementById("PopUpDiv").innerHTML);
	}
});
</script>

<script> //LoadBuildingInfo
var thisProv = ajaxProvInfo;
var thisWorld = playerWorld;

var possibleBuildings = thisProv.Possible_Buildings
var currentBuildings = [thisProv.Build1ID,thisProv.Build2ID];

var refCodeLookup = {"C":"Culture","E":"Economic","M":"Military"}

var column1Type = refCodeLookup[currentBuildings[0][0]];
var column2Type = refCodeLookup[currentBuildings[1][0]];
	
var column1Tier = currentBuildings[0][1];
var column2Tier = currentBuildings[1][1];
	
_loadBuildings();

function _loadBuildings() 
{
	//First character of columns = column type.
	
	document.getElementById("Col1").textContent = column1Type + " Buildings";
	document.getElementById("Col2").textContent = column2Type + " Buildings";
	
	for(i = 1; i < 5;i++)
	{
		document.getElementById("Building" + i).src = "Assets/Buildings/" +  possibleBuildings[i].Building_Name + ".png";
		if(i -1 == parseInt(column1Tier)) //can build
		{
			document.getElementById("Building" + i).style.border = "5px solid green";
			document.getElementById("Building" + i).onclick =  function() {_CreateBuild(thisProv.Province_ID,currentBuildings[0][0]);};
		}
		else if(i - 1< parseInt(column1Tier)) //below build tier
		{
			document.getElementById("Building" + i).style.filter = "sepia(1)";
			document.getElementById("Building" + i).style.border = "5px solid yellow";
		}
		else //above build tier
		{
			document.getElementById("Building" + i).style.filter = "grayscale(1)";
			document.getElementById("Building" + i).style.border = "5px solid black";
		}
	}
	
	for(i = 6; i < 10;i++)
	{
		document.getElementById("Building" + i).src = "Assets/Buildings/" +  possibleBuildings[i].Building_Name + ".png";
		if(i - 6 == parseInt(column2Tier)) //can build
		{
			document.getElementById("Building" + i).style.border = "5px solid green";
			document.getElementById("Building" + i).onclick = function(){ _CreateBuild(thisProv.Province_ID,currentBuildings[1][0]);};//Allows player to expend points to construct buildings
		}
		else if(i - 6< parseInt(column2Tier)) //below build tier
		{
			document.getElementById("Building" + i).style.filter = "sepia(1)";
			document.getElementById("Building" + i).style.border = "5px solid yellow";
		}
		else //above build tier
		{
			document.getElementById("Building" + i).style.filter = "grayscale(1)";
			document.getElementById("Building" + i).style.border = "5px solid black";
		}
	}
}

function _loadPopupBuilding(evt)
{
	var subjectEntry = possibleBuildings[evt.slice(evt.length - 1)]; //Last character of id = building in array
	var subjectID = evt.slice(evt.length - 1);
	var costType = refCodeLookup[subjectEntry.BuildingID[0]];
	
	document.getElementById("BuildIcon").src = "Assets/Buildings/" +  subjectEntry.Building_Name + ".png";
	document.getElementById("BuildName").textContent = subjectEntry.Building_Name;
	document.getElementById("BuildCost").textContent = "Cost: " + Math.ceil(subjectEntry.Base_Cost * (1-(ajaxProvInfo.Build_Cost/100))) + " " + costType + " Influence";
	document.getElementById("BuildCap").textContent = "+" + subjectEntry.Bonus_Mil_Cap + " Military Capacity";
	document.getElementById("BuildDef").textContent = "+" + subjectEntry.Bonus_Def_Strength + "% Local Defensive Strength";
	document.getElementById("BuildCostMod").textContent = "-" + subjectEntry.Bonus_Build_Cost + "% Local Build Cost";
	
	if(subjectID < 5)
	{
		if(subjectID <= parseInt(column1Tier))
		{
			document.getElementById("BuildConstruct").style.color = "red";
			document.getElementById("BuildConstruct").textContent = "Already Constructed";
		}
		else if(subjectID == parseInt(column1Tier) + 1)
		{
			document.getElementById("BuildConstruct").style.color = "darkgreen";
			document.getElementById("BuildConstruct").textContent = "Click To Construct";
		}
		else
		{
			document.getElementById("BuildConstruct").style.color = "red";
			document.getElementById("BuildConstruct").textContent = "Cannot Be Constructed";
		}
	}
	else
	{
		if(subjectID - 5 <= parseInt(column2Tier))
		{
			document.getElementById("BuildConstruct").style.color = "red";
			document.getElementById("BuildConstruct").textContent = "Already Constructed";
		}
		else if(subjectID - 5 == parseInt(column2Tier) + 1)
		{
			document.getElementById("BuildConstruct").style.color = "darkgreen";
			document.getElementById("BuildConstruct").textContent = "Click To Construct";
		}
		else
		{
			document.getElementById("BuildConstruct").style.color = "red";
			document.getElementById("BuildConstruct").textContent = "Cannot Be Constructed";
		}
	}
}

function _CreateBuild(provID,type)
{
	//for some reason this script returns true for both an unsuccessful and successful POST request.
	
	BIPostBuild(provID,"<?php echo $_SESSION['APIKEY'];?>",type).done((apiReturn =>{ 
		if(apiReturn.statusText == "Sucessfully constructed building")
		{
			window.location.href = 'provinces.php?ProvinceView=' + provID;
		}
		else
		{
			window.location.href = 'provinces.php?ProvinceView=' + provID + "&Errors=" + apiReturn.statusText;
		}
		}))
		.fail((apiReturn =>{ 
		if(apiReturn.statusText == "Sucessfully constructed building")
		{
			window.location.href = 'provinces.php?ProvinceView=' + provID;
		}
		else
		{
			window.location.href = 'provinces.php?ProvinceView=' + provID + "&Errors=" + apiReturn.statusText;
		}
	}));
	
	//TODO - switch this to not use page redirects unless necessary.
}
</script>
</html>