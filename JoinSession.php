<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<link rel="stylesheet" href="MainStyle.css">
<title>
Tauresium - Join Session
</title>
</head>
<body style="background-color:white;margin:0px;">

<?php include_once 'Scripts/PageUpdate.php'?>

<div style="background-image:linear-gradient(to top, rgba(226, 225, 225, 0.7), rgba(230, 191, 131, 1)),url('Backgroundimages/InkPage.png');width:95%;overflow:auto;text-align:center;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">
<button id="BackButton" style="background-color:#c0392b;color: white;text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';float:left;" onclick="document.location='index.php'">< Back</button>

<table style="width:100%;text-align:center;">
<tr>
<td>
<br><br>
<div style="background-color:#F2DFC1;min-width:min-content;width:50%;margin-left:auto;margin-right:auto;border:10px solid black;">
<br><br>
<font id="NationTitle" style="font-family:Castellar;font-size:52px;" > New Nation </font>
<br><br>
<form>
<font style="font-family:Romanus;font-size:48px;" >My nation name: </font>
<br><br>
<input id="NationName" type="text" width="100%" name="CountryNameInput" size="45" maxlength="20" autocomplete="off" style="text-align:center;font-size:18px;font-family:Romanus;" onkeyup="_UpdateTitle()"/>
<br><br>
<font style="font-family:Romanus;font-size:32px;">World Code: </font>
<br>
<div style="width:400px;;margin-left:auto;margin-right:auto;">
<font style="font-family:Arial;font-size:12px;word-wrap: break-word;">You must generate this from the "Create a new Session" tab, any code generated can be shared with up to 5 friends to play a world together </font>
</div>
<br>
<input type="text" width="100%" name="WorldCodeInput" autocomplete="off" size="37" maxlength="16" style="text-align:center;font-size:18px;font-family:Romanus;"/>
<br><br>
<font style="font-family:Romanus;font-size:32px;" >Government Type: </font>
<br>
<div style="width:400px;;margin-left:auto;margin-right:auto;">
<font style="font-family:Arial;font-size:12px;word-wrap: break-word;">This will effect your base stats when you start the game, these stats will change as the game progresses. The actual government type cannot be changed once you start.</font>
</div>
<br><br>
<table style="width:max-content;margin-left:auto;margin-right:auto;">
<tr>
<th style="border-bottom:1px solid black;"> Culture Focus </th>
<th style="border-bottom:1px solid black;"> Economic Focus </th>
<th style="border-bottom:1px solid black;"> Military Focus </th>
<th style="border-bottom:1px solid black;"> Challenge </th>
</tr>
<tr onclick="_SelectionResponse()">
<td>
<input type="radio" width="100%" name="GovernmentType" value="Sultanate" /> <label for="GovernmentType"> Sultanate </label> <!-- ++++culture --economic -military + C:200 E:0 M:100 300-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="Horde"/> <label for="GovernmentType"> Horde </label> <!-- ++++culture ----economic [] C:300 E:0 M:0 300-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="ElectoralMonarchy"/> <label for="GovernmentType"> Electoral Monarchy </label>  <!-- +++culture +military ---economic + C:70 E:0 M:150 220-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="Theocracy"/> <label for="GovernmentType"> Theocracy </label> <!-- ++culture -military + C:200 E:0 M:50 250 -->
<br>
<input type="radio" width="100%" name="GovernmentType" value="Monarchy"/> <label for="GovernmentType">  Hereditary Monarchy </label> <!-- +culture + C:100 E:50 M:80 230-->
<br>
</td>
<td>
<input type="radio" width="100%" name="GovernmentType" value="Libertarian"/> <label for="GovernmentType"> Libertarian Republic </label> <!-- --military --culture ++++economic [] C:70 E:150 M:50 270-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="Colonial"/> <label for="GovernmentType"> Colonial Republic </label> <!-- +++economic --military + C:100 E:100 M:100 300-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="Democracy"/> <label for="GovernmentType"> Democracy </label> <!-- +++economic --culture + C:70 E:150 M:0 220-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="MerchantRepublic"/> <label for="GovernmentType">  Merchant Republic </label> <!-- ++economic -military + C:80 E:120 M:50 250-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="ClassicRepublic"/> <label for="GovernmentType"> Classical Republic </label> <!-- +economic + C:70 E:100 M:70 240 -->
<br>
</td>
<td>
<input type="radio" width="100%" name="GovernmentType" value="Dictatorship"/> <label for="GovernmentType"> Dictatorship </label> <!-- +++military -economic -culture + C:30 E:50 M:150 230 -->
<br>
<input type="radio" width="100%" name="GovernmentType" value="CommunistRepublic"/> <label for="GovernmentType"> People's Republic </label> <!-- ++military ++culture ---economic + C:70 E:0 M:150 220-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="Oligarchy"/> <label for="GovernmentType"> Oligarchy </label> <!-- +military + C:50 E:70 M:100 220-->
<br>
</td>
<td>
<input type="radio" width="100%" name="GovernmentType" value="Anarchy"/> <label for="GovernmentType"> Anarchist Commune </label> <!-- -military -culture -economic --- C:25 E:25 M:25 75-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="Tribe"/> <label for="GovernmentType"> Tribe </label> <!-- --military --culture --economic ------ C:0 E:0 M:0 0-->
<br>
</td>
</tr>
</table>
<br><br>

<div>
<table style="width:min-content;margin-left:auto;margin-right:auto;">
<tr>
<td> <font id="CulturePlus" style="font-size:32px;color:green"> &nbsp </font> </td>
<td> <font id="EconomicPlus" style="font-size:32px;color:green"> &nbsp </font> </td>
<td> <font id="MilitaryPlus" style="font-size:32px;color:green"> &nbsp </font> </td>
</tr>
<tr>
<td><img src="Assets/CultureIcon.png" style="width:64px;height:64px;vertical-align:middle;"/> </td>
<td><img src="Assets/EconomicIcon.png" style="width:64px;height:64px;vertical-align:middle;"/> </td>
<td><img src="Assets/MilitaryIcon.png" style="width:64px;height:64px;vertical-align:middle;"/> </td>
</tr>
<tr>
<td> <font id="CultureMinus" style="font-size:32px;color:red"> &nbsp </font> </td>
<td> <font id="EconomicMinus" style="font-size:32px;color:red"> &nbsp </font> </td>
<td> <font id="MilitaryMinus" style="font-size:32px;color:red"> &nbsp </font> </td>
</tr>
</table>
</div>
<font style="font-family:Romanus;font-size:48px;" >My national colour: </font>
<br><br>
<table style="width:min-content;margin-left:auto;margin-right:auto;background-color:white;border:10px solid #966F33;">
<tr>
<td style="padding:20px;"> <img style="background-color:#D66B67;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="D66B67"/> </td>
<td style="padding:20px"> <img style="background-color:#DE965D;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="DE965D"/> </td>
<td style="padding:20px"> <img style="background-color:#ECE788;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="ECE788"/></td>
</tr>
<tr>
<td style="padding:20px"> <img style="background-color:#B5DB7F;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="B5DB7F"/> </td>
<td style="padding:20px"> <img style="background-color:#8ECDD2;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="8ECDD2"/></td>
<td style="padding:20px"> <img style="background-color:#8F97CF;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="8F97CF"/> </td>
</tr>
</table>
<br><br>

<button type="submit" id="Submit" style="background-color:green;color: white;text-align: center;display: inline-block;font-size: 64px;margin: 4px 2px;cursor: pointer;width:600px;height:80px;border:none;font-family:'Helvetica';float:center;" onclick="document.location='index.php'">Create my nation!</button>
</form>
<br><br>
</div>
<br><br><br>
</div>

<script>
var selectedGovernment = "NULL";
var governmentTitles = new Map([['Sultanate', 'The Sultanate of'],
['Horde', 'The Great Horde of'],
['ElectoralMonarchy', 'The Electoral Kingdom of'],
['Theocracy', 'The Prince-bishopric of'],
['Monarchy', 'The Kingdom of'],
['Libertarian', 'The Free State of'],
['Colonial', 'The Colonial Domain of'],
['Democracy', 'The Democratic Republic of'],
['MerchantRepublic', 'The Mercantile Republic of'],
['ClassicRepublic', 'The Republic of'],
['Dictatorship', 'The Nation of'],
['CommunistRepublic', "The People's Republic of"],
['Oligarchy', 'The Oligarchical State of'],
['Anarchy', 'The Free Communities of'],
['Tribe', 'The Tribe of'],
]);
	
function _UpdateTitle()
{
	if(selectedGovernment != "NULL")
	{
		document.getElementById("NationTitle").textContent = governmentTitles.get(selectedGovernment) + " " + document.getElementById("NationName").value;
	}
	else
	{
		document.getElementById("NationTitle").textContent = "State of " + document.getElementById("NationName").value;
	}
}

function _SelectionResponse(evt) 
{
	selectedGovernment = event.srcElement.value;
	//C = C+ E= E+ M= M+ D = C- F= E- W=M-
	
	var governmentEffects = new Map([['Sultanate', 'CCCCFFW'],
	['Horde', 'CCCCFFFF'],
	['ElectoralMonarchy', 'CCCMFFFF'],
	['Theocracy', 'CCW'],
	['Monarchy', 'C'],
	['Libertarian', 'EEEEWWDD'],
	['Colonial', 'EEEWW'],
	['Democracy', 'EEEDD'],
	['MerchantRepublic', 'EEW'],
	['ClassicRepublic', 'E'],
	['Dictatorship', 'MMMFD'],
	['CommunistRepublic', 'MMCCFFFF'],
	['Oligarchy', 'M'],
	['Anarchy', 'DFW'],
	['Tribe', 'DDFFWW'],
	]);
	

	if(typeof selectedGovernment !== 'undefined')
	{
		var bonusDump = Array.from(governmentEffects.get(selectedGovernment));
		var cultureMod = "";
		var economicMod = "";
		var militaryMod = "";
		
		_UpdateTitle();
		
		for(var ch = 0;ch < bonusDump.length;ch+=1)
		{
			switch(bonusDump[ch])
			{
				case "C":
					cultureMod += "+";
					break;
				case "E":
					economicMod += "+";
					break;
				case "M":
					militaryMod += "+";
					break;
				case "D":
					cultureMod += "-";
					break;
				case "F":
					economicMod += "-";
					break;
				case "W":
					militaryMod += "-";
					break;
			}
		}
		
		if(cultureMod.length > 0)
		{
			if(cultureMod.substring(0,1) == "+" )
			{
				document.getElementById("CulturePlus").textContent = cultureMod;
				document.getElementById("CultureMinus").textContent = "\xa0";
			}
			else if(cultureMod.substring(0,1) == "-" )
			{
				document.getElementById("CultureMinus").textContent = cultureMod;
				document.getElementById("CulturePlus").textContent = "\xa0";
			}
		}
		else
		{
			document.getElementById("CulturePlus").textContent = "\xa0";
			document.getElementById("CultureMinus").textContent = "\xa0";
		}
		
		if(economicMod.length > 0)
		{
			if(economicMod.substring(0,1) == "+" )
			{
				document.getElementById("EconomicPlus").textContent = economicMod;
				document.getElementById("EconomicMinus").textContent = "\xa0";
			}
			else if(economicMod.substring(0,1) == "-" )
			{
				document.getElementById("EconomicMinus").textContent = economicMod;
				document.getElementById("EconomicPlus").textContent = "\xa0";
			}
		}
		else
		{
			document.getElementById("EconomicPlus").textContent = "\xa0";
			document.getElementById("EconomicMinus").textContent = "\xa0";
		}
		
		if(militaryMod.length > 0)
		{
			if(militaryMod.substring(0,1) == "+" )
			{
				document.getElementById("MilitaryPlus").textContent = militaryMod;
				document.getElementById("MilitaryMinus").textContent = "\xa0";
			}
			else if(militaryMod.substring(0,1) == "-" )
			{
				document.getElementById("MilitaryMinus").textContent = militaryMod;
				document.getElementById("MilitaryPlus").textContent = "\xa0";
			}
		}
		else
		{
			document.getElementById("MilitaryPlus").textContent = "\xa0";
			document.getElementById("MilitaryMinus").textContent = "\xa0";
		}
	}
}
</script>

<div class="Disclaimer">
	<p style="margin-left:10%;margin-right:10%;"> Program by 100505349.
	This web application is not intended to be an accurate representation of political borders or cultural boundaries. The map shown in this production is a rough triangulated map meant to serve as a
	representation - with regions being represented by relevant locations (which may not be placed properly).
	The map constructed in this application was made by hand by 100505349 - using image references to properly plot the coordinates </p>	
</div>
</body>
</html>