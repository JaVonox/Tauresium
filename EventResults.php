<?php
include_once "Scripts/DBLoader.php";
$milGenChanges = (!isset($_GET["MilInfluenceChanges"]) ? "" : $_GET["MilInfluenceChanges"] );
$ecoGenChanges = (!isset($_GET["EcoInfluenceChanges"]) ? "" : $_GET["EcoInfluenceChanges"] ); 
$cultGenChanges = (!isset($_GET["CultInfluenceChanges"]) ? "" : $_GET["CultInfluenceChanges"]);

$eventTitle = (!isset($_GET["EventTitle"]) ? "" : $_GET["EventTitle"]);
$eventOption = (!isset($_GET["OptionTitle"]) ? "" : $_GET["OptionTitle"]);
$newMil = (!isset($_GET["AddMil"]) ? "" : $_GET["AddMil"]);
$newEco = (!isset($_GET["AddEco"]) ? "" : $_GET["AddEco"]);
$newCult = (!isset($_GET["AddCult"]) ? "" : $_GET["AddCult"]);
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<link rel="stylesheet" href="MainStyle.css">
<title>
Tauresium - Results
</title>
</head>
<body style="background-color:white;margin:0px;">

<?php include_once 'Scripts/PageUpdate.php'?>
<?php include_once "Scripts/CheckLogin.php";?>
<?php 
$database = new Database();
$db = $database->getConnection();
$newTotals = $database->GetPlayerChanges(session_id());
$eventsRemaining = False;

if($newTotals['Events_Stacked'] > 1)
{
	$eventsRemaining = True;
}
?>
<div style="background-color:lightgrey;width:95%;min-height:570px;overflow:auto;text-align:center;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">
	<font style="font-size:72px;color:black;font-family:Romanus;"> <?php echo $eventTitle ?> </font>
	<br>
	<font style="font-size:48px;color:black;font-family:Romanus;">"<i><?php echo $eventOption ?></i>"</font>
	<br><br>
	<div style="width:60%;margin-left:auto;margin-right:auto;font-size:18px;">
	Following our actions in response to this event, the following changes to our nation occured:
	</div>
	<br><br><br>
	<table style="width:60%;margin-left:auto;margin-right:auto;text-align:center;border:1px solid black;">
	<th></th>
	<th> Government <br> Focus <br> Changes </th>
	<th> New <br> Focus <br> Modifiers </th>
	<th> New <br> Influence <br> Points </th>
	<th> Total <br> Influence </th>
	<tr>
		<td> <img src="Assets/CultureIcon.png" style="width:64px;height:64px;vertical-align:middle;"/> </td>
		<td style="<?php echo "" . $cultGenChanges>=0?"color:green":"color:red"?>;font-size:24px;" > <?php echo $cultGenChanges * 100 ?>% </td>
		<td style="font-size:24px;"> <?php echo $newTotals['Culture_Generation'] * 100 ?>% </td>
		<td style="font-size:24px;"> <?php echo $newCult ?> </td>
		<td style="font-size:24px;"> <?php echo $newTotals['Culture_Influence'] ?> </td>
	</tr>
	<tr>
		<td> <img src="Assets/EconomicIcon.png" style="width:64px;height:64px;vertical-align:middle;"/> </td>
		<td style="<?php echo "" . $ecoGenChanges>=0?"color:green":"color:red"?>;font-size:24px;"> <?php echo $ecoGenChanges * 100 ?>% </td>
		<td style="font-size:24px;"> <?php echo $newTotals['Economic_Generation'] * 100 ?>% </td>
		<td style="font-size:24px;"> <?php echo $newEco ?> </td>
		<td style="font-size:24px;"> <?php echo $newTotals['Economic_Influence'] ?> </td>
	</tr>
	<tr>
		<td> <img src="Assets/MilitaryIcon.png" style="width:64px;height:64px;vertical-align:middle;"/> </td>
		<td style="<?php echo "" . $milGenChanges>=0?"color:green":"color:red"?>;font-size:24px;"> <?php echo $milGenChanges * 100 ?>% </td>
		<td style="font-size:24px;"> <?php echo $newTotals['Military_Generation'] * 100 ?>% </td>
		<td style="font-size:24px;"> <?php echo $newMil ?> </td>
		<td style="font-size:24px;"> <?php echo $newTotals['Military_Influence'] ?> </td>
	</tr>
	</table>
	<br><br><br><br>

	<?php
	if($eventsRemaining == True)
	{
		echo "You still have events remaining, click here to complete your next event<br><br><br>";
		echo '<button class="gameButton" onclick="' . "document.location='LoadEvent'" . '"style="font-size:32px;">Next Event</button>';
	}
	else
	{
		echo "You have completed all your events for now - check back later to complete more";
	}
	?>
	<br><br><br><br>
</div>

<?php include "PageElements/Disclaimer.html" ?>
</body>
</html>