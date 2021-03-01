<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<link rel="stylesheet" href="MainStyle.css">
<title>
Tauresium - World View
</title>
</head>

<body style="background-color:white;margin:0px;">

<?php include_once 'Scripts/PageUpdate.php'?>
<?php include_once "Scripts/CheckLogin.php";?>

<?php
$database = new Database();
$db = $database->getConnection();
$player = $database->ReturnLogin(session_id());
$worldStats = $database->GetSessionStats($player);
$worldOccupants = $database->GetSessionPlayers($worldStats['World_Code']);
?>

<div style="background-color:lightgrey;width:95%;min-height:570px;overflow:auto;text-align:center;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">
	<font style="font-size:72px;color:black;text-decoration:underline;"> The World of <?php echo $worldStats['World_Name']; ?> </font>
	<br><br>
	<div style="width:60%;margin-left:auto;margin-right:auto;">
	<font style="font-size:24px;color:black;">World Code: <i><?php echo $worldStats['World_Code'] ?></i></font>
	<br>
	<font style="font-size:24px;color:black;"><?php echo (5 - $worldStats['Capacity']) ?> / 5</font>
	<br>
	<font style="font-size:24px;color:black;">Event speed : <?php echo $worldStats['Speed']; ?> minutes</font>
	<br>
	</div>
	<br><br><br>
	<table style="width:45%;margin-left:auto;margin-right:auto;text-align:center;font-size:24px;">
	<th><u> Flag </u></th>
	<th><u> Country Name  <u></th>
	<th><u> Government <u></th>
	<th><u> Last Online <u></th>
	<?php 
	for($x=0;$x < count($worldOccupants);$x++)
	{
		$playerTitle = $database->getPlayerStats($worldOccupants[$x]['Country_Name'])['Title'];
		
		echo "<tr>";
		echo "<td> <img src='Assets/Flags/" . $worldOccupants[$x]['Colour'] . "' alt='Country Flag' width='180px' height='120px'/> </td>";
		echo "<td>" . $playerTitle . " " . $worldOccupants[$x]['Country_Name'] . "</td>";
		echo "<td>" . $worldOccupants[$x]['Country_Type'] . "</td>";
		echo "<td>" . $worldOccupants[$x]['Last_Event_Time'] . "</td>";
		echo "</tr>";
	}
	?>
	</table>
</div>

<?php include "PageElements/Disclaimer.html" ?>
</body>
</html>