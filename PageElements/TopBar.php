<?php include_once "Scripts/DBLoader.php";?>

<?php
$database = new Database();
$db = $database->getConnection();
$player = $database->ReturnLogin(session_id());

$playerStats = $database->getPlayerStats($player);
$divStyle = '"background-color: #' . $playerStats['Colour'] . ';border:5px solid black;border-radius:5px;margin-right:50px;color:black;vertical-align:middle;overflow:auto;"';

$eventSpeed = $database->GetEventSpeed($player);
$timeFormat = "i:s";

$timeUntilEventAbsolute = abs((($playerStats['Events_Stacked'] - floor($playerStats['Events_Stacked'])) * ($eventSpeed * 60)) - ($eventSpeed * 60));

if(intval(gmdate("h",$timeUntilEventAbsolute)) < 12)
{
	$timeFormat = "h:i:s";
}

//Time until next event - digits of events_stacked * 1200 = time since last event (20secintervals) change with speed.
if($playerStats['Events_Stacked'] < 5)
{
	$timeLeftFormatted = gmdate($timeFormat,$timeUntilEventAbsolute);
}
else
{
	$timeLeftFormatted = "---";
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
<div style= <?php echo $divStyle ?>>
<div style="width:70%;background-color:white;margin-left:auto;margin-right:auto;height:min-content;width:content;">
<font style="font-family:Romanus;font-size:18px;"> <?php echo $playerStats['Title']; ?></font>
<br>
<font style="font-family:Romanus;font-size:18px;text-decoration:underline;"> <?php echo $playerStats['Country_Name']; ?></font>
<br><br>
<img src="Assets/CultureIcon.png" style="width:32px;height:32px;vertical-align:middle;"/> <?php echo $playerStats['Culture_Influence'] . " "; ?>
<img src="Assets/EconomicIcon.png" style="width:32px;height:32px;vertical-align:middle;"/> <?php echo $playerStats['Economic_Influence'] . " "; ?>
<img src="Assets/MilitaryIcon.png" style="width:32px;height:32px;vertical-align:middle;"/> <?php echo $playerStats['Military_Influence'] . " "; ?>
<br>
<img src="Assets/PlaceholderIcon.png" style="width:32px;height:32px;vertical-align:middle;"/> <?php echo $timeLeftFormatted . " "; ?>
<img src="Assets/PlaceholderIcon.png" style="width:32px;height:32px;vertical-align:middle;"/> <?php echo floor($playerStats['Events_Stacked']); ?>/5
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
	<button class="menuButton" onclick="document.location='SessionStats.php'"><?php echo $playerStats['World_Name']; ?></button>
	<button class="tutorialButton" onclick="document.location='HowToPlay.php'">View Tutorial</button>
	<button class="eventsButton" <?php echo (floor($playerStats['Events_Stacked']) >= 1 || $playerStats['Active_Event_ID'] != "") ? "onclick=" . '"' . "document.location='LoadEvent.php'" . '"' : "style='pointer-events:none;visibility:hidden;'" ?> >Events (<?php echo ($playerStats['Active_Event_ID'] != "") ? "Resume Event" : "Left: " . floor($playerStats['Events_Stacked'])?>)</button>
</div>
</div>
</div>
<script type="text/javascript" src="Scripts/BackgroundLoader.js"> </script>