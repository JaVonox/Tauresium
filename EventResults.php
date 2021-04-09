<?php
include_once "Scripts/DBLoader.php";
$missingParams = False;
$milGenChanges = (!isset($_GET["MilInfluenceChanges"]) ? $missingParams = True : $_GET["MilInfluenceChanges"] );
$ecoGenChanges = (!isset($_GET["EcoInfluenceChanges"]) ? $missingParams = True : $_GET["EcoInfluenceChanges"] ); 
$cultGenChanges = (!isset($_GET["CultInfluenceChanges"]) ? $missingParams = True : $_GET["CultInfluenceChanges"]);

$eventTitle = (!isset($_GET["EventTitle"]) ? $missingParams = True : $_GET["EventTitle"]);
$eventOption = (!isset($_GET["OptionTitle"]) ? $missingParams = True : $_GET["OptionTitle"]);
$newMil = (!isset($_GET["AddMil"]) ? $missingParams = True : $_GET["AddMil"]);
$newEco = (!isset($_GET["AddEco"]) ? $missingParams = True : $_GET["AddEco"]);
$newCult = (!isset($_GET["AddCult"]) ? $missingParams = True : $_GET["AddCult"]);
$backgroundParams = "";

if($missingParams)
{
	header("Location: ErrorPage.php?Error=NoEventParams"); 
}
else if($cultGenChanges >= $milGenChanges && $cultGenChanges >= $ecoGenChanges)
{
	$backgroundParams = "background-image:radial-gradient(circle at center, rgba(0, 0, 98, 1), rgba(0, 0, 98, 0.2)),url('Backgroundimages/CultureDecision.png')";
}
else if($ecoGenChanges >= $cultGenChanges && $ecoGenChanges >= $milGenChanges)
{
	$backgroundParams = "background-image:radial-gradient(circle at center, rgba(0, 98, 0, 1), rgba(0, 98, 0, 0.2)),url('Backgroundimages/EconomicDecision.png')";
}
else if($milGenChanges >= $cultGenChanges && $milGenChanges >= $ecoGenChanges)
{
	$backgroundParams = "background-image:radial-gradient(circle at center, rgba(98, 0, 0, 1), rgba(98, 0, 0, 0.2)),url('Backgroundimages/MilitaryDecision.png')";
}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<link rel="stylesheet" href="MainStyle.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="API/APIScripts/BuiltInAPICalls.js"></script>
<title>
Tauresium - Results
</title>
</head>
<body style="background-color:white;margin:0px;">

<?php include_once 'Scripts/PageUpdate.php'?>
<?php include_once "Scripts/CheckLogin.php";?>
<div style="<?php echo $backgroundParams ?>;width:100%;background-repeat:no-repeat;background-position:center;background-size:cover;">
<div style="background-color:lightgrey;width:60%;min-height:570px;overflow:auto;text-align:center;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">
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
		<td style="font-size:24px;" id="CultGen"> ... </td>
		<td style="font-size:24px;"> <?php echo $newCult ?> </td>
		<td style="font-size:24px;" id="CultInf"> ... </td>
	</tr>
	<tr>
		<td> <img src="Assets/EconomicIcon.png" style="width:64px;height:64px;vertical-align:middle;"/> </td>
		<td style="<?php echo "" . $ecoGenChanges>=0?"color:green":"color:red"?>;font-size:24px;"> <?php echo $ecoGenChanges * 100 ?>% </td>
		<td style="font-size:24px;" id="EcoGen"> ... </td>
		<td style="font-size:24px;"> <?php echo $newEco ?> </td>
		<td style="font-size:24px;" id="EcoInf"> ... </td>
	</tr>
	<tr>
		<td> <img src="Assets/MilitaryIcon.png" style="width:64px;height:64px;vertical-align:middle;"/> </td>
		<td style="<?php echo "" . $milGenChanges>=0?"color:green":"color:red"?>;font-size:24px;"> <?php echo $milGenChanges * 100 ?>% </td>
		<td style="font-size:24px;" id="MilGen"> ... </td>
		<td style="font-size:24px;"> <?php echo $newMil ?> </td>
		<td style="font-size:24px;" id="MilInf"> ... </td>
	</tr>
	</table>
	<br><br>
	
	<font style="display:none;" id="NextEVHidT"> You still have events remaining, click here to complete your next event<br><br><br> </font>
	<button class="gameButton" onclick="document.location='LoadEvent.php'" style="font-size:32px;display:none;" id="NextEVHidB">Next Event</button>
	<font style="display:none;" id="NoEVHid"> You have completed all your events for now - check back later to complete more </font>
	<br><br><br><br>
</div>
</div>

<script>
BIGetPlayerStats("<?php echo $_SESSION['Country'] ?>").done((value => { 
	document.getElementById("CultGen").textContent = Math.floor(value.Culture_Generation * 100) + "%";
	document.getElementById("CultInf").textContent = value.Culture_Influence;
	document.getElementById("EcoGen").textContent = Math.floor(value.Economic_Generation * 100) + "%";
	document.getElementById("EcoInf").textContent = value.Economic_Influence;
	document.getElementById("MilGen").textContent = Math.floor(value.Military_Generation * 100) + "%";
	document.getElementById("MilInf").textContent = value.Military_Influence;
	
	if(value.Events_Stacked > 1)
	{
		document.getElementById("NextEVHidT").style.display = "initial";
		document.getElementById("NextEVHidB").style.display = "initial";
	}
	else
	{
		document.getElementById("NoEVHid").style.display = "initial";
	}
	
	
}));
</script>

<?php include "PageElements/Disclaimer.html" ?>
</body>
</html>