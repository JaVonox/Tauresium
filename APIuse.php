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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="API/APIScripts/BuiltInAPIcalls.js"></script>
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
	for the request.
	<br><br>
	<div style="display:block;margin:auto;">
	<input type="textbox" id="APIbox" value="AAA" style="width:60%;font-size:32px;text-align:center;"></input>
	</div>
	<br><br>
	The list of valid commands and their parameters and usages are as follows
	<br><br>
	Legend:
	<br>
	<b> Identifier </b>
	<br>
	(Neccessary Parameter)
	<br>
	[Optional Parameter]
	<br><br>
		
	<h2>GET</h2>
	
	<dl style="text-align:left;">
		<dt> /<b>Province</b>/[Province ID]/[World Code] </dt> <dd> Returns either a list of provinces, or statistics about a specific location, with world specific information appended if a world code is supplied </dd>
		<dt> /<b>View</b>/(APIKEY) </dt> <dd> Returns a list of provinces with the owners and visibility appended, from the perspective of a specific user </dd>
		<dt> /<b>Country</b>/(Country Name) </dt> <dd> Returns information about a specific user including which provinces they own and their current influence </dd>
		<dt> /<b>World</b>/(World Code) </dt> <dd> Returns information about a specific world, including the inhabiting users </dd>
		<dt> /<b>Building</b>/[Building Name] </dt> <dd> Returns either a list of all possible buildings or the specific statistics of a single building </dd>
		<dt> /<b>Government</b>/[Government Type] </dt> <dd> Returns either a list of all possible government types or their initial statistics </dd>
		<dt> /<b>CoastalRegion</b>/[Coastal Region Name] </dt> <dd> Returns either a list of all coastal regions as well as their adjacent regions, or the statistics for a speicific region </dd>
		<dt> /<b>Cost</b>/(Province ID)/(Country Name) </dt> <dd> Returns the individual point cost of a province for a specific country, and by extension if it can be taken at all </dd>
		<dt> /<b>Event</b>/(APIKEY) </dt> <dd> Returns the currently loaded event of a specific player, its title and description as well as the options available </dd>
	</dl>
	
	<h2>POST</h2>
	
	<dl style="text-align:left;">
		<dt> /<b>Country</b>/(Country Name)/(Password)/(World Code)/(Government Type)/(Hex Colour) </dt> <dd> Creates a new country and login using the provided information</dd>
		<dt> /<b>World</b>/(World Name)/(Map Type)/(Speed) </dt> <dd> Creates a new world and returns the world code using the provided information. Map Type must be 'Earth' and the Speed may be either 'VeryQuick', 'Quick', 'Normal' or 'Slow' </dd>
		<dt> /<b>Event</b>/(APIKEY)/(Option Number) </dt> <dd> Answers the currently loaded event of the player whos API key is provided, and returns the results. Option Number must be either 1, 2 or 3 </dd>
		<dt> /<b>Building</b>/(Province ID)/(APIKEY)/(Point Type) </dt> <dd> Attempts to construct a building in the province specified by the player whos API key is provided. Point type must be either C, E or M </dd>
		<dt> /<b>Province</b>/(Province ID)/(APIKEY)/(Point Type) </dt> <dd> Attempts to annex the province specified using influence. Point type must be either C, E or M </dd>
	</dl>
	
	<h2>PUT</h2>
	
	<dl style="text-align:left;">
		<dt> /<b>Event</b>/(APIKEY) </dt> <dd> Updates the last online time of the selected player, as well as their events stacked. Loads an event if applicable.</dd>
	</dl>
	
	<h2>DELETE</h2>
	
	<dl style="text-align:left;">
		<dt> /<b>Event</b>/(APIKEY) </dt> <dd> Skips the currently loaded event for a player without providing any rewards. API only feature. </dd>
	</dl>
	
	</div>
</div>

<script>
var hostname = window.location.hostname;
document.getElementById("APIbox").value = "http://" + hostname + "/Tauresium/TaurAPI/";
</script>
<?php include "PageElements/Disclaimer.html" ?>
</body>
</html>