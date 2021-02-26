<?php
$NationError = (!isset($_GET["NationName"]) ? "" : $_GET["NationName"] );
$PasswordError = (!isset($_GET["Password"]) ? "" : $_GET["Password"] ); //Password will never be passed back so this will be safe.
$WorldCodeError = (!isset($_GET["WorldCodeInput"]) ? "" : $_GET["WorldCodeInput"]);
$GovernmentTypeError = (!isset($_GET["GovernmentType"]) ? "" : $_GET["GovernmentType"]);
$CountryColourError = (!isset($_GET["CountryColour"]) ? "" : $_GET["CountryColour"]);

$NationValue = "";
$WorldCodeValue = "";
$GovernmentTypeValue = "";
$CountryColourValue = "";
$ErrorMessage = "";


if($NationError == "MISSING")
{
	$ErrorMessage = $ErrorMessage . "Please enter a nation name <br>";
}
else if(substr($NationError,0,7) == "INVALID")
{
	$ErrorMessage = $ErrorMessage . "Nation name must be less than 20 characters long and may only consist of alphabetical characters <br>";
	$NationValue = substr($NationError,7,strlen($NationError));
}
else if(substr($NationError,0,8) == "OCCUPIED")
{
	$ErrorMessage = $ErrorMessage . "That country name is currently in use by another player, please choose something else <br>";
	$NationValue = substr($NationError,8,strlen($NationError));
}
else
{
	$NationValue = $NationError;
}

if($PasswordError == "INVALID")
{
	$ErrorMessage = $ErrorMessage . "The password entered is missing or invalid. Please enter a new password.<br>";
}

if($WorldCodeError == "MISSING")
{
	$ErrorMessage = $ErrorMessage . "Please enter a world code <br>";
}
else if(substr($WorldCodeError,0,7) == "INVALID")
{
	$ErrorMessage = $ErrorMessage . "World codes may only be alphanumeric characters and must be 16 characters in length<br>";
	$WorldCodeValue = substr($WorldCodeError,7,strlen($WorldCodeError));
}
else if(substr($WorldCodeError,0,8) == "OCCUPIED")
{
	$ErrorMessage = $ErrorMessage . "The selected world is full. <br>";
	$WorldCodeValue = substr($WorldCodeError,8,strlen($WorldCodeError));
}
else
{
	$WorldCodeValue = $WorldCodeError;
}


if($GovernmentTypeError == "MISSING" || $GovernmentTypeError == "INVALID")
{
	$ErrorMessage = $ErrorMessage . "Please select a government type <br>";
}
else 
{
	$GovernmentTypeValue = $GovernmentTypeError;
}

if($CountryColourError == "MISSING")
{
	$ErrorMessage = $ErrorMessage . "Please select a country colour <br>";
}
else if(substr($CountryColourError,0,7) == "INVALID")
{
	$ErrorMessage = $ErrorMessage . "Please select a valid country colour <br>";
}
else if(substr($CountryColourError,0,8) == "OCCUPIED")
{
	$ErrorMessage = $ErrorMessage . "This colour is in use by another player in your session, please choose another.<br>";
	$CountryColourValue = substr($CountryColourError,8,strlen($CountryColourError));
}
else
{
	$CountryColourValue = $CountryColourError;
}

?>

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

<div id="Background" style="background-image:radial-gradient(circle at center, rgba(230, 191, 131, 1), rgba(226, 225, 225, 0.7)),url('Backgroundimages/InkPage.png');width:95%;overflow:auto;text-align:center;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">
<button id="BackButton" class="backButton" style="text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';float:left;" onclick="document.location='index'">< Back</button>

<table style="width:100%;text-align:center;">
<tr>
<td>
<br><br>
<div style="background-color:#F2DFC1;min-width:min-content;width:50%;margin-left:auto;margin-right:auto;border:10px solid black;">
<br><br>
<font id="NationTitle" style="font-family:Castellar;font-size:52px;" > New Nation </font>
<br><br>
<div id="ErrorBox">
<font style="color:red;"> <?php echo $ErrorMessage; ?></font>
</div>
<form method="POST" action="Scripts/CreateNewAccount.php">
<font style="font-family:Romanus;font-size:48px;" >My nation name: </font>
<br><br>
<input id="NationName" type="text" width="100%" name="CountryNameInput" size="45" maxlength="20" autocomplete="off" style="text-align:center;font-size:18px;font-family:Romanus;" onkeyup="_UpdateTitle()" value="<?php echo $NationValue; ?>"/>
<br><br>
<font style="font-family:Romanus;font-size:48px;" >My password: </font>
<br>
<div style="width:400px;;margin-left:auto;margin-right:auto;">
<font style="font-family:Arial;font-size:12px;word-wrap: break-word;">Please make sure you choose a password you will remember - there is no way to recover this password if it is forgotten.</font>
</div>
<br>
<input id="NationPass" type="password" width="100%" name="CountryPassInput" size="50" maxlength="25" autocomplete="off" style="text-align:center;font-size:18px;font-family:Romanus;"/>
<br><br>
<font style="font-family:Romanus;font-size:32px;">World Code: </font>
<br>
<div style="width:400px;;margin-left:auto;margin-right:auto;">
<font style="font-family:Arial;font-size:12px;word-wrap: break-word;">You must generate this from the "Create a new Session" tab, any code generated can be shared with up to 5 friends to play a world together </font>
</div>
<br>
<input type="text" width="100%" name="WorldCodeInput" autocomplete="off" size="37" maxlength="16" style="text-align:center;font-size:18px;font-family:Romanus;" value="<?php echo $WorldCodeValue; ?>"/>
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
<input type="radio" width="100%" name="GovernmentType" value="Sultanate" <?php echo ($GovernmentTypeValue == "Sultanate") ? 'checked="checked"' : ''; ?> /> <label for="GovernmentType"> Sultanate </label> <!-- ++++culture --economic -military + C:200 E:0 M:100 300-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="Horde" <?php echo ($GovernmentTypeValue == "Horde") ? 'checked="checked"' : ''; ?>/> <label for="GovernmentType"> Horde </label> <!-- ++++culture ----economic [] C:300 E:0 M:0 300-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="ElectoralMonarchy" <?php echo ($GovernmentTypeValue == "ElectoralMonarchy") ? 'checked="checked"' : ''; ?> /> <label for="GovernmentType"> Electoral Monarchy </label>  <!-- +++culture +military ---economic + C:70 E:0 M:150 220-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="Theocracy" <?php echo ($GovernmentTypeValue == "Theocracy") ? 'checked="checked"' : ''; ?>/> <label for="GovernmentType"> Theocracy </label> <!-- ++culture -military + C:200 E:0 M:50 250 -->
<br>
<input type="radio" width="100%" name="GovernmentType" value="Monarchy" <?php echo ($GovernmentTypeValue == "Monarchy") ? 'checked="checked"' : ''; ?>/> <label for="GovernmentType">  Hereditary Monarchy </label> <!-- +culture + C:100 E:50 M:80 230-->
<br>
</td>
<td>
<input type="radio" width="100%" name="GovernmentType" value="Libertarian" <?php echo ($GovernmentTypeValue == "Libertarian") ? 'checked="checked"' : ''; ?>/> <label for="GovernmentType"> Libertarian Republic </label> <!-- --military --culture ++++economic [] C:70 E:150 M:50 270-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="Colonial" <?php echo ($GovernmentTypeValue == "Colonial") ? 'checked="checked"' : ''; ?>/> <label for="GovernmentType"> Colonial Republic </label> <!-- +++economic --military + C:100 E:100 M:100 300-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="Democracy" <?php echo ($GovernmentTypeValue == "Democracy") ? 'checked="checked"' : ''; ?>/> <label for="GovernmentType"> Democracy </label> <!-- +++economic --culture + C:70 E:150 M:0 220-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="MerchantRepublic" <?php echo ($GovernmentTypeValue == "MerchantRepublic") ? 'checked="checked"' : ''; ?>/> <label for="GovernmentType">  Merchant Republic </label> <!-- ++economic -military + C:80 E:120 M:50 250-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="ClassicRepublic" <?php echo ($GovernmentTypeValue == "ClassicRepublic") ? 'checked="checked"' : ''; ?> /> <label for="GovernmentType"> Classical Republic </label> <!-- +economic + C:70 E:100 M:70 240 -->
<br>
</td>
<td>
<input type="radio" width="100%" name="GovernmentType" value="Dictatorship"/ <?php echo ($GovernmentTypeValue == "Dictatorship") ? 'checked="checked"' : ''; ?>> <label for="GovernmentType"> Dictatorship </label> <!-- +++military -economic -culture + C:30 E:50 M:150 230 -->
<br>
<input type="radio" width="100%" name="GovernmentType" value="CommunistRepublic" <?php echo ($GovernmentTypeValue == "CommunistRepublic") ? 'checked="checked"' : ''; ?>/> <label for="GovernmentType"> People's Republic </label> <!-- ++military ++culture ---economic + C:70 E:0 M:150 220-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="Oligarchy"/ <?php echo ($GovernmentTypeValue == "Oligarchy") ? 'checked="checked"' : ''; ?>> <label for="GovernmentType"> Oligarchy </label> <!-- +military + C:50 E:70 M:100 220-->
<br>
</td>
<td>
<input type="radio" width="100%" name="GovernmentType" value="Anarchy" <?php echo ($GovernmentTypeValue == "Anarchy") ? 'checked="checked"' : ''; ?>/> <label for="GovernmentType"> Anarchist Commune </label> <!-- -military -culture -economic --- C:25 E:25 M:25 75-->
<br>
<input type="radio" width="100%" name="GovernmentType" value="Tribe" <?php echo ($GovernmentTypeValue == "Tribe") ? 'checked="checked"' : ''; ?>/> <label for="GovernmentType"> Tribe </label> <!-- --military --culture --economic ------ C:0 E:0 M:0 0-->
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
<td style="padding:20px;"> <img style="background-color:#D66B67;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="D66B67" onclick="_UpdateBackground()" <?php echo ($CountryColourValue == "D66B67") ? 'checked="checked"' : ''; ?>/> </td>
<td style="padding:20px"> <img style="background-color:#DE965D;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="DE965D" onclick="_UpdateBackground()" <?php echo ($CountryColourValue == "DE965D") ? 'checked="checked"' : ''; ?>/> </td>
<td style="padding:20px"> <img style="background-color:#ECE788;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="ECE788" onclick="_UpdateBackground()" <?php echo ($CountryColourValue == "ECE788") ? 'checked="checked"' : ''; ?>/></td>
</tr>
<tr>
<td style="padding:20px"> <img style="background-color:#B5DB7F;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="B5DB7F" onclick="_UpdateBackground()" <?php echo ($CountryColourValue == "B5DB7F") ? 'checked="checked"' : ''; ?>/> </td>
<td style="padding:20px"> <img style="background-color:#8ECDD2;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="8ECDD2" onclick="_UpdateBackground()" <?php echo ($CountryColourValue == "8ECDD2") ? 'checked="checked"' : ''; ?>/></td>
<td style="padding:20px"> <img style="background-color:#8F97CF;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="8F97CF" onclick="_UpdateBackground()" <?php echo ($CountryColourValue == "8F97CF") ? 'checked="checked"' : ''; ?>/> </td>
</tr>
</table>
<br><br>

<button type="submit" id="Submit" class="gameButton" style="text-align: center;display: inline-block;font-size: 64px;margin: 4px 2px;cursor: pointer;font-family:'Helvetica';float:center;" onclick="document.location='index'">Create my nation!</button>
</form>
<br><br>
</div>
<br><br><br>
</div>

<script>
var selectedGovernment = "NULL";
var selectedColour = "NULL";
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
['CommunistRepublic', "The Peoples Republic of"],
['Oligarchy', 'The Oligarchical State of'],
['Anarchy', 'The Free Communities of'],
['Tribe', 'The Tribe of'],
]);
var phpName = "<?php echo $NationValue; ?>";
var phpGov = "<?php echo $GovernmentTypeValue; ?>";
var phpColour = "<?php echo $CountryColourValue; ?>";

if(phpGov !== "")
{
	selectedGovernment = phpGov;
	_QualityResponse(selectedGovernment);
}
else
{
	if(phpName !== "")
	{
		document.getElementById("NationTitle").textContent = document.getElementById("NationName").value;
	}
	else
	{
		document.getElementById("NationTitle").textContent = "New Nation";
	}
}

if(phpColour !== "")
{
	selectedColour = phpColour;
	var redComponent = ((parseInt(selectedColour[0],16) * 16) + parseInt(selectedColour[1],16));
	var greenComponent = ((parseInt(selectedColour[2],16) * 16) + parseInt(selectedColour[3],16));
	var blueComponent = ((parseInt(selectedColour[4],16) * 16) + parseInt(selectedColour[5],16));
	document.getElementById("Background").style.backgroundImage = "radial-gradient(circle at center,rgba(" + redComponent +"," + greenComponent + "," + blueComponent+", 1), rgba(226, 225, 225, 0.8)),url('Backgroundimages/InkPage.png')";
}

function _UpdateTitle()
{
	if(selectedGovernment != "NULL")
	{
		document.getElementById("NationTitle").textContent = governmentTitles.get(selectedGovernment) + " " + document.getElementById("NationName").value;
	}
	else
	{
		document.getElementById("NationTitle").textContent = document.getElementById("NationName").value;
	}
}

function _UpdateBackground(evt)
{
	selectedColour = event.srcElement.value;
	
	if(selectedColour !== "NULL")
	{
		var redComponent = ((parseInt(selectedColour[0],16) * 16) + parseInt(selectedColour[1],16));
		var greenComponent = ((parseInt(selectedColour[2],16) * 16) + parseInt(selectedColour[3],16));
		var blueComponent = ((parseInt(selectedColour[4],16) * 16) + parseInt(selectedColour[5],16));
		document.getElementById("Background").style.backgroundImage = "radial-gradient(circle at center,rgba(" + redComponent +"," + greenComponent + "," + blueComponent+", 1), rgba(226, 225, 225, 0.8)),url('Backgroundimages/InkPage.png')";
	}
}
function _SelectionResponse(evt) 
{
	_QualityResponse(event.srcElement.value);
}

function _QualityResponse(source) 
{
	selectedGovernment = source;
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