<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<link rel="stylesheet" href="MainStyle.css">
<script type="text/javascript" src="Scripts/BackgroundLoader.js"> </script>
<title>
Tauresium - Index
</title>
</head>
<body style="background-color:white;margin:0px;">

<div id="LogoDiv" style="background-image:linear-gradient(to left, rgba(226, 225, 225, 0.2), rgba(226, 225, 225, 1)),url('Backgroundimages/Volcano.png');width:100%;height:120px;overflow:hidden;background-position:center;background-size:100%;text-align:center;">
<table style="width:100%;">
<tr>
<td style="width:59%;text-align:right;"> <font style="font-family:Romanus;font-size:80px;"> Tauresium </font> </td>
<td style="width:20%">
</td>
<td>
<div style="background-color:black;border:5px solid black;border-radius:5px;margin-right:50px;color:white;">
<form>
<font style="font-family:Romanus;font-size:18px;"> Existing Session ID? </font>
<br>
<input type="text" width="100%" id="Login" name="LoginInput"/>
<br>
<input type="submit" value="Login"/>
</form>
</div>	
</td>
</tr>
</table>
</div>

<div id="MenuBar" style="background-color:#E4E4E4;width:100%;height:40px;border-bottom:4px solid black;"> 
	<button style="margin-left:20px;" class="menuButton" onclick="document.location='Main.php'">Create a new session</button>
	<button class="menuButton" onclick="document.location='Main.php'">Join a session</button>
</div>

<div style="background-color:lightgrey;width:95%;min-height:570px;overflow:auto;text-align:center;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">
	Hello and welcome to Tauresium! This website is intended to be a playable mapgame hosted online. The contents of this website were created by 100505349 for use in their Application development class
	for the university of derby.
	<br><br>
	<b> What is Tauresium? </b>
	<br>
	Tauresium is an online map game inwhich a player takes control of a nation attempting to expand its influence over the modern world. The end goal of this project is to have a game which allows multiple players to
	interact with a world and each other. Each area in the game reflects a real life enviroment - and it is the intention of the developer to reflect the people and culture of these regions through in game text and
	gameplay mechanics
	<br><br>
	<b> How do i play?</b>
	<br>
	As of writing, the game is not yet functional, but it is proposed that the game will function using different player made sessions, all of which have a indentifying key. By using this key the player will be able to
	connect to their session and recieve a login key to access their country within the session. 
	<br>
	This game functions in real time - every 15 minutes the player will recieve a new event that will effect their influence in the areas of culture,economics and military - each of which can be used as appropriate to expand
	the borders of the players empire. The player will not be told how their decisions will effect their nation so it is important that a player carefully considers how their actions will effect their nation before answering.
	<br><br>
	<b> Who is the winner? </b>
	<br>
	While there is no definitive winner of the game - the winner can be said to be the nation who controls the most territory.
	<br><br>
	<b> When will this be done? </b>
	<br>
	I have no idea
	<br><br>
</div>

<div class="Disclaimer">
	<p style="margin-left:10%;margin-right:10%;"> Program by 100505349.
	This web application is not intended to be an accurate representation of political borders or cultural boundaries. The map shown in this production is a rough triangulated map meant to serve as a
	representation - with regions being represented by relevant locations (which may not be placed properly).
	The map constructed in this application was made by hand by 100505349 - using image references to properly plot the coordinates </p>	
</div>
</body>
</html>