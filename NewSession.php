<?php
$worldError = (!isset($_GET["WorldName"]) ? "" : $_GET["WorldName"] );
$mapError = (!isset($_GET["MapType"]) ? "" : $_GET["MapType"] );
$speedError = (!isset($_GET["GameSpeed"]) ? "" : $_GET["GameSpeed"] );
$errorMessage = "";

$worldValue = "";
$mapValue = "";
$speedValue = "";

if($worldError == "MISSING")
{
	$errorMessage = $errorMessage . "Please enter a world name <br>";
}
else if(substr($worldError,0,7) == "INVALID")
{
	$errorMessage = $errorMessage . "World name must be less than 20 characters long and may only consist of alphabetical characters <br>";
	$worldValue = substr($worldError,7,strlen($worldError));
}
else
{
	$worldValue = $worldError;
}

if($mapError == "MISSING")
{
	$errorMessage = $errorMessage . "Please select a map type <br>";
}
else if(substr($mapError,0,7) == "INVALID")
{
	$errorMessage = $errorMessage . "Please select a valid map type <br>";
}
else
{
	$mapValue = $mapError;
}

if($speedError == "MISSING")
{
	$errorMessage = $errorMessage . "Please select a game speed <br>";
}
else if(substr($speedError,0,7) == "INVALID")
{
	$errorMessage = $errorMessage . "Please select a valid game speed <br>";
}
else
{
	$speedValue = $speedError;
}

?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<link rel="stylesheet" href="MainStyle.css">
<title>
Tauresium - New Session
</title>
</head>
<body style="background-color:white;margin:0px;">

<?php include_once 'Scripts/PageUpdate.php'?>

<div id="Background" style="background-image:linear-gradient(to top, rgba(226, 225, 225, 0.5), rgba(230, 191, 131, 1)),url('Backgroundimages/MappaMundi.png');width:95%;overflow:auto;text-align:center;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">
<button id="BackButton" class="backButton" style="text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';float:left;" onclick="document.location='index.php'">< Back</button>

<table style="width:100%;text-align:center;">
<tr>
<td>
<br><br>
<div style="background-color:#F2DFC1;min-width:min-content;width:50%;margin-left:auto;margin-right:auto;border:10px solid black;">
<br><br>
<font id="NationTitle" style="font-family:Castellar;font-size:52px;" > Create a New World </font>
<br>
<div style="width:400px;;margin-left:auto;margin-right:auto;">
<font style="font-family:Arial;font-size:12px;word-wrap: break-word;"> Creating a new world allows you to play the game with up to 5 other players - simply fill out this form and click enter to get your world code, which you and your friends can enter on the "Join a session" page to enter a game together. </font>
</div>
<br>
<div id="ErrorBox">
<font style="color:red;"> <?php echo $errorMessage; ?></font>
</div>
<form method="POST" action="Scripts/CreateNewWorld.php">
<font style="font-family:Romanus;font-size:48px;" >My World Name: </font>
<div style="width:400px;;margin-left:auto;margin-right:auto;">
<font style="font-family:Arial;font-size:12px;word-wrap: break-word;"> The name of your world will have no impact on gameplay, but for roleplay reasons you might want to choose a name that you like!</font>
</div>
<br>
<input type="text" width="100%" name="WorldName" size="45" maxlength="20" autocomplete="off" style="text-align:center;font-size:18px;font-family:Romanus;" />
<br><br><br>
<font style="font-family:Romanus;font-size:48px;" > World Map Type: </font>
<div style="width:400px;;margin-left:auto;margin-right:auto;">
<font style="font-family:Arial;font-size:12px;word-wrap: break-word;"> This will determine what map your session will be played on. As of this release only the basic earth map exists, but more will be released in the future.</font>
</div>
<br>
<table style="width:min-content;margin-left:auto;margin-right:auto;">
<tr>
<td style="padding:20px;"> 
<img style="background-image:url('Assets/WorldMapIcon.png');width:256px;height:256px;margin:0px;vertical-align:middle;"/> 
<font> Real World </font>
<br>
<input type="radio" name="MapType" value="Earth" <?php echo ($mapValue == "Earth") ? 'checked="checked"' : ''; ?>/> <!-- checked="checked" -->
</td>
<td style="padding:20px;"> 
<img style="background-image:url('Assets/WorldMapGreyscale.png');width:256px;height:256px;margin:0px;vertical-align:middle;"/> 
<font> TBA </font>
<br>
<input type="radio" width="100%" style="pointer-events:none;opacity:0.5;" width="100%" name="MapType" value="TBA" <?php echo ($mapValue == "TBA") ? 'checked="checked"' : ''; ?>/> <!-- style="pointer-events:none;opacity:0.5;" -->
</td>
</tr>
</table>
<font style="font-family:Romanus;font-size:48px;" > Game Speed: </font>
<div style="width:400px;;margin-left:auto;margin-right:auto;">
<font style="font-family:Arial;font-size:12px;word-wrap: break-word;"> This determines how often events appear in the game - setting this setting to a greater speed will mean events occur quicker. Think carefully about this as quicker event timers mean that to keep up you will need to be active more often.  </font>
</div>
<br>
<table style="width:content;margin-left:auto;margin-right:auto;">
<tr>
<td style="padding:20px;"> 
<input type="radio" name="GameSpeed" style="pointer-events:none;opacity:0.5;" value="Quick" <?php echo ($speedValue == "Quick") ? 'checked="checked"' : ''; ?>/> <label for="GameSpeed"> Quick (10 Minute event timer)</label>
</td>
<td style="padding:20px;"> 
<input type="radio" name="GameSpeed" value="Normal" <?php echo ($speedValue == "Normal") ? 'checked="checked"' : ''; ?>/> <label for="GameSpeed"> Normal (20 Minute event timer)</label> <!-- checked="checked" -->
</td>
<td style="padding:20px;"> 
<input type="radio" name="GameSpeed" style="pointer-events:none;opacity:0.5;" value="Slow" <?php echo ($speedValue == "Slow") ? 'checked="checked"' : ''; ?>/> <label for="GameSpeed"> Slow (40 Minute event timer)</label>
</td>
<td style="padding:20px;"> 
<input type="radio" name="GameSpeed" style="pointer-events:none;opacity:0.5;" value="VerySlow" <?php echo ($speedValue == "VerySlow") ? 'checked="checked"' : ''; ?>/> <label for="GameSpeed"> Very Slow (1 Hour event timer)</label>
</td>
</tr>
</table>
<br><br>
<button type="submit" id="Submit" class="gameButton" style="text-align: center;display: inline-block;font-size: 64px;margin: 4px 2px;cursor: pointer;font-family:'Helvetica';float:center;" onclick="document.location='index.php'">Create my World!</button>
</form>
<br><br>
</div>
<br><br><br>
</div>

<script>
var selectedGovernment = "NULL";
var selectedColour = "NULL";
	

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
</script>

<div class="Disclaimer">
	<p style="margin-left:10%;margin-right:10%;"> Program by 100505349.
	This web application is not intended to be an accurate representation of political borders or cultural boundaries. The map shown in this production is a rough triangulated map meant to serve as a
	representation - with regions being represented by relevant locations (which may not be placed properly).
	The map constructed in this application was made by hand by 100505349 - using image references to properly plot the coordinates </p>	
</div>
</body>
</html>