<?php
if(!isset($_SESSION)) 
{ 
   session_start(); 
} 
?>

<div>
<div id="LogoDiv" style="background-image:linear-gradient(to left, rgba(226, 225, 225, 0.2), rgba(226, 225, 225, 1)),url('Backgroundimages/Volcano.png');width:100%;min-height:120px;height:min-content;background-position:center;background-size:100%;text-align:center;">
<table style="width:100%;">
<tr>
<td style="width:59%;text-align:right;"> <font style="font-family:Romanus;font-size:80px;"> Tauresium </font> </td>
<td style="width:20%">
</td>
<td>
<div id="boxDiv" style="background-color: white;border:5px solid black;border-radius:5px;margin-right:50px;color:black;vertical-align:middle;overflow:auto;">
<div style="width:70%;background-color:white;margin-left:auto;margin-right:auto;height:min-content;width:content;">
<font style="font-family:Romanus;font-size:18px;" id="pTitle"> Loading... </font>
<br>
<font style="font-family:Romanus;font-size:18px;text-decoration:underline;" id="pName" ></font>
<br><br>
<img src="Assets/CultureIcon.png" style="width:32px;height:32px;vertical-align:middle;"  alt="Cultural Influence"/> <font id="pCult"></font>
<img src="Assets/EconomicIcon.png" style="width:32px;height:32px;vertical-align:middle;"  alt="Economic Influence"/> <font id="pEco"></font>
<img src="Assets/MilitaryIcon.png" style="width:32px;height:32px;vertical-align:middle;"  alt="Military Influence"> <font id="pMil"> </font>
<br>
<font id="pTime"> Loading... </font> <img id="eImage" src="Assets/EventIcon.png" style="width:32px;height:32px;vertical-align:middle;" alt="Event Stacks"> <font id="pEvent"></font>
<br>	
</td>
</tr>
</table>
</div>
</div>
<div id="MenuBar" style="background-color:#E4E4E4;width:100%;height:40px;border-bottom:4px solid black;overflow:auto;"> 
	<button style="margin-left:20px;" class="menuButton" onclick="document.location='index.php'">Index</button>
	<button style="float:right;margin-right:20px;text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';" class="backButton" onclick="document.location='Scripts/KillSession.php'">Logout</button>
	<button class="menuButton" onclick="document.location='Main.php'">World Map</button>
	<button class="menuButton" onclick="document.location='SessionStats.php'" id="wName">...</button>
	<button class="apiButton" onclick="document.location='APIuse.php'">API</button>
	<button class="tutorialButton" onclick="document.location='HowToPlay.php'">View Tutorial</button>
	<button class="eventsButton" id="wEvents" style="display:none;" onclick="document.location='LoadEvent.php'">...</button>
</div>
</div>
</div>

<script>
BIGetPlayerStats("<?php echo $_SESSION['Country']; ?>").then((Pvalue => {
	PopulateData(Pvalue);
	
	BIGetWorldStats(Pvalue.World_Code).then((Wvalue => {
		PopulateWorldData(Pvalue,Wvalue);
	}));
}));

function PopulateData(userInfo)
{
	document.getElementById("pTitle").innerHTML = userInfo.Title;
	document.getElementById("pName").innerHTML = userInfo.Country_Name;
	document.getElementById("pCult").innerHTML = userInfo.Culture_Influence;
	document.getElementById("pEco").innerHTML = userInfo.Economic_Influence;
	document.getElementById("pMil").innerHTML = userInfo.Military_Influence + "/" + userInfo.Mil_Cap;
	
	if(userInfo.Military_Influence >= userInfo.Mil_Cap)
	{
		document.getElementById("pMil").style.color = "green";
	}
	
	document.getElementById("pEvent").innerHTML = Math.floor(userInfo.Events_Stacked) + "/5";
	
	if(userInfo.Events_Stacked >= 5)
	{
		document.getElementById("pEvent").style.color = "green";
	}
	
	document.getElementById("boxDiv").style.backgroundColor = "#" + userInfo.Colour;
}

function PopulateWorldData(userInfo,worldInfo)
{

	var secondsLeft = Math.abs(((userInfo.Events_Stacked - Math.floor(userInfo.Events_Stacked)) * (worldInfo.EventSpeed * 60)) - (worldInfo.EventSpeed * 60));
	
	//the following code calculates how much time is left in H:M:S based on the amount of seconds. It appends 0 to the front for the purposes of displaying the value appropriately
	//The minutes and second values are displayed as the last two digits hence meaning that any values below 10 will automatically include the 0 character at the start.
	var hourDisplay = "0" + Math.floor(secondsLeft / 3600);
	var minuteDisplay = "0" + Math.floor((secondsLeft / 60) - (hourDisplay * 60));
	var secDisplay = "0" + Math.floor(secondsLeft - ((minuteDisplay * 60) + (hourDisplay * 3600)));
	
	if(hourDisplay >= 1)
	{
		document.getElementById("pTime").innerHTML = hourDisplay + ":" + minuteDisplay.slice(-2) + ":" + secDisplay.slice(-2);
	}
	else
	{
		document.getElementById("pTime").innerHTML = minuteDisplay.slice(-2) + ":" + secDisplay.slice(-2);
	}
	
	document.getElementById("wName").textContent = worldInfo.World_Name;
	
	if(!Number.isInteger(userInfo.Active_Event_ID)) //If there is no active event
	{
		if(Math.floor(userInfo.Events_Stacked) >= 1)
		{
			document.getElementById("wEvents").innerHTML = "Events (" + Math.floor(userInfo.Events_Stacked) + "/5)";
			document.getElementById("wEvents").style.display = "initial";
		}
		else
		{
			document.getElementById("eImage").setAttribute("style","width:32px;height:32px;vertical-align:middle;filter:grayscale(1)");
		}
	}
	else
	{
		document.getElementById("wEvents").innerHTML = "Events (Resume Event)";
		document.getElementById("wEvents").style.display = "initial";
	}
	
}
</script>

<script type="text/javascript" src="Scripts/BackgroundLoader.js"> </script>