<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<link rel="stylesheet" href="MainStyle.css">
<title>
Tauresium - Join Session
</title>
</head>
<body style="background-color:white;margin:0px;">

<?php include_once 'PageElements/LoginTopBar.php';?>

<div id="MenuBar" style="background-color:#E4E4E4;width:100%;height:40px;border-bottom:4px solid black;"> 
	<button style="margin-left:20px;" class="menuButton" onclick="document.location='index.php'">Main Menu</button>
</div>

<div style="background-color:lightgrey;width:95%;min-height:570px;overflow:auto;text-align:center;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">
<button id="BackButton" style="background-color:#c0392b;color: white;text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';float:left;" onclick="document.location='index.php'">< Back</button>

<table style="width:100%;text-align:center;">
<tr>
<td> <h1> Join a world? </h1></td>
</tr>
<tr>
<td> <font> To generate a world please use the create a world button on the main menu. When you have recieved the code from this form, you may enter it here to get a login code.</font></td>
</tr>
<tr>
<td>
<br><br>
<form>
<font style="font-family:Romanus;font-size:18px;">Enter your world code here!</font>
<br><br><br>
<input type="text" width="100%" id="WorldCode" name="WorldCodeInput"/>
<br><br>
<button type="submit" id="Submit" style="background-color:green;color: white;text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';float:center;" onclick="document.location='index.php'">Submit World Code</button>
</form>
</td>
</tr>
</table>
</div>

<div class="Disclaimer">
	<p style="margin-left:10%;margin-right:10%;"> Program by 100505349.
	This web application is not intended to be an accurate representation of political borders or cultural boundaries. The map shown in this production is a rough triangulated map meant to serve as a
	representation - with regions being represented by relevant locations (which may not be placed properly).
	The map constructed in this application was made by hand by 100505349 - using image references to properly plot the coordinates </p>	
</div>
</body>
</html>