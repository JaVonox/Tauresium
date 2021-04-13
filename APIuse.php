<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<link rel="stylesheet" href="MainStyle.css">
<style>

.heading
{
	font-family:Romanus;
	font-size:48px;
	line-height:2;
}

.subheading
{
	font-family:Romanus;
	font-size:32px;
	line-height:2;
}

ul
{
	list-style-type: circle;
}
</style>

<title>
Tauresium - Tutorial
</title>
</head>
<body style="background-color:white;margin:0px;">

<?php include_once 'Scripts/PageUpdate.php'?>

<div style="background-color:lightgrey;width:95%;min-height:570px;overflow:auto;text-align:center;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">
	<br>
	<font style="font-family:Castellar;font-size:52px;line-height:2;" > API </font>
	<div style="width:65%;margin-left:auto;margin-right:auto;font-family:Tahoma;">
	<?php
	//This will read the player their API key if they are logged in
	if(isset($_SESSION['APIKEY']))
	{
		echo '<font class="subheading"> My API key is: <font class="HiddenText">' . $_SESSION['APIKEY'] . '</font></font>';
		echo '<br><font style="font-size:12px;">This key can be used as an alternate method to use your account. For this reason you should treat this value like your password - do not give it away to other users or untrusted programs.<br>';
		echo '<b>If you do not know what you are doing with this, do not attempt to use it.</b></font><br><br>';
	}
	?>
	Tauresium implements a basic REST API structure allowing for players to interact with the game outside of the website itself. This potentially allows the development of third party clients or similar user-created content.
	<br>
	<font class="heading"> API Syntax </font>
	<br>
	The Tauresium API, TaurAPI, follows a simple syntax structure, as shown below. Entering this URL will notify the program that you are attempting to use the API, and any further parameters will be interpreted as arguments 
	for the request. TODO finish this??
	<br><br>
	<div style="display:block;margin:auto;">
	<input type="textbox" id="APIbox" value="AAA" style="width:60%;font-size:32px;text-align:center;"></input>
	</div>
	</div>
</div>

<script>
var hostname = window.location.hostname;
document.getElementById("APIbox").value = hostname + "/Tauresium/TaurAPI/";
</script>
<?php include "PageElements/Disclaimer.html" ?>
</body>
</html>