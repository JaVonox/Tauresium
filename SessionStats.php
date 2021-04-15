<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="API/APIScripts/BuiltInAPIcalls.js"></script>
<link rel="stylesheet" href="MainStyle.css">
<title>
Tauresium - World View
</title>
</head>

<body style="background-color:white;margin:0px;">

<?php include_once 'Scripts/PageUpdate.php'?>
<?php include_once "Scripts/CheckLogin.php";?>

<div style="background-color:lightgrey;width:95%;min-height:570px;overflow:auto;text-align:center;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">
	<font id="WorldName" style="font-size:72px;color:black;text-decoration:underline;"> Loading... </font>
	<br><br>
	<div style="width:60%;margin-left:auto;margin-right:auto;">
	<font id="WorldCode" style="font-size:24px;color:black;"></i></font>
	<br>
	<font id="WorldCapacity" style="font-size:24px;color:black;">Loading...</font>
	<br>
	<font id="WorldSpeed" style="font-size:24px;color:black;"></font>
	<br>
	</div>
	<br><br><br>
	<table id="WorldTable" style="width:60%;margin-left:auto;margin-right:auto;text-align:center;font-size:24px;border-collapse:collapse;">
	<th><u> Flag </u></th>
	<th><u> Country Name  <u></th>
	<th><u> Max Military Strength <u></th>
	<th><u> Last Online (UTC) <u></th>
	<th><u> Number Of Provinces <u></th>
	<th><u> Coastal Power <u></th>
	</table>
</div>

<template id="PlTableRow">
	<tr style='border-bottom:2px solid black;font-size:18px;'>
		<td> </td> <!-- Image row -->
		<td> </td> <!-- Name Row -->
		<td> </td> <!-- Mil Row -->
		<td> </td> <!-- Last Online Row -->
		<td> </td> <!-- Number Of Provinces (Maybe add more province detail here? -->
		<td> </td> <!-- Coastal Powers -->
	</tr>
</template>

<script>
BIGetPlayerStats("<?php echo $_SESSION['Country']; ?>").then((Pvalue => { 
	
	BIGetWorldStats(Pvalue.World_Code).then((Wvalue => {
		_FillSessionData(Wvalue); //Loads the World data from the first user and fills out the page
		
		for(var i=0;i<Wvalue.Players.length;i++)
		{
			BIGetPlayerStats(Wvalue.Players[i].Country_Name).then((value => {
				_AddRow(value); //Get value from ajax HTTP call and then store value. (as this uses the API it is already in JSON form)
			}));
		}
	}));
}));

function _AddRow(playerStats) 
{
	var table = document.querySelector("#WorldTable");
    var template = document.querySelector('#PlTableRow');
	
	var clone = template.content.cloneNode(true);
    var td = clone.querySelectorAll("td");

    td[0].innerHTML = "<img src='Assets/Flags/" + playerStats.Colour + ".png' alt='Country Flag' width='180px' height='120px' alt='Flag'/>";
	td[1].textContent = playerStats.Title + " " + playerStats.Country_Name;
    td[2].textContent = playerStats.Mil_Cap;
	td[3].textContent = playerStats.Last_Event_Time;
	td[4].textContent = playerStats.OwnedProvinces.length;
	
	for(var j=0;j<playerStats.Ocean_Powers.length;j++)
	{
		td[5].innerHTML += playerStats.Ocean_Powers[j] + "<br><br>";
	}
	
	table.appendChild(clone);
}

function _FillSessionData(info)
{
	document.getElementById("WorldName").textContent = "The World Of " + info.World_Name;
	document.getElementById("WorldCode").innerHTML = "World Code: <i>" + info.World_Code;
	document.getElementById("WorldCapacity").textContent = "Players: " + (5 - parseInt(info.SlotsLeft,10)) + "/5";
	document.getElementById("WorldSpeed").textContent = "Event speed: " + info.EventSpeed + " minutes";
}
</script>
<?php include "PageElements/Disclaimer.html" ?>
</body>
</html>