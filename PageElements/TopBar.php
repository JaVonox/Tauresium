<?php include_once "Scripts/DBLoader.php";?>

<?php
$database = new Database();
$db = $database->getConnection();
$playerStats = $database->getPlayerStats($_SESSION['user']);
$divStyle = '"background-color: #' . $playerStats[0]['Colour'] . ';border:5px solid black;border-radius:5px;margin-right:50px;color:black;vertical-align:middle;overflow:auto;"';
?>

<div id="LogoDiv" style="background-image:linear-gradient(to left, rgba(226, 225, 225, 0.2), rgba(226, 225, 225, 1)),url('Backgroundimages/Volcano.png');width:100%;height:120px;overflow:hidden;background-position:center;background-size:100%;text-align:center;">
<table style="width:100%;">
<tr>
<td style="width:59%;text-align:right;"> <font style="font-family:Romanus;font-size:80px;"> Tauresium </font> </td>
<td style="width:20%">
</td>
<td>
<div style= <?php echo $divStyle ?>>
<font style="font-family:Romanus;font-size:18px;text-decoration:underline;"> <?php echo $playerStats[0]['Country_Name']; ?></font>
<br><br>
<img src="Assets/CultureIcon.png" style="width:32px;height:32px;vertical-align:middle;"/> <?php echo $playerStats[0]['Culture_Influence'] . " "; ?>
<img src="Assets/EconomicIcon.png" style="width:32px;height:32px;vertical-align:middle;"/> <?php echo $playerStats[0]['Economic_Influence'] . " "; ?>
<img src="Assets/MilitaryIcon.png" style="width:32px;height:32px;vertical-align:middle;"/> <?php echo $playerStats[0]['Military_Influence'] . " "; ?>
<br>
<img src="Assets/PlaceholderIcon.png" style="width:32px;height:32px;vertical-align:middle;"/> 00:00
<img src="Assets/PlaceholderIcon.png" style="width:32px;height:32px;vertical-align:middle;"/> <?php echo $playerStats[0]['Events_Stacked']; ?>/5
<br>	
</td>
</tr>
</table>
</div>
<div id="MenuBar" style="background-color:#E4E4E4;width:100%;height:40px;border-bottom:4px solid black;overflow:auto;"> 
	<button style="margin-left:20px;" class="menuButton" onclick="document.location='Index.php'">Index</button>
	<button style="float:right;margin-right:20px;text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';" class="backButton" onclick="document.location='Scripts/KillSession.php'">Logout</button>
	<button class="menuButton" onclick="document.location='Main.php'">The World</button>
	<button class="menuButton">Events</button>
</div>
<script type="text/javascript" src="Scripts/BackgroundLoader.js"> </script>