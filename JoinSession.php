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

<?php include_once 'Scripts/PageUpdate.php'?>

<div style="background-color:lightgrey;width:95%;min-height:570px;overflow:auto;text-align:center;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">
<button id="BackButton" style="background-color:#c0392b;color: white;text-align: center;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;width:200px;height:30px;border:none;font-family:'Helvetica';float:left;" onclick="document.location='index.php'">< Back</button>

<table style="width:100%;text-align:center;">
<tr>
<td> <h1> Join a world? </h1></td>
</tr>
<tr>
<td> To generate a world please use the create a world button on the main menu. When you have recieved the code from this form, you may enter it here to get a login code.</td>
</tr>
<tr>
<td>
<br><br>
<div style="background-color:#E6BF83;min-width:min-content;width:50%;margin-left:auto;margin-right:auto;">
<form>
<br><br>
<font style="font-family:Romanus;font-size:48px;">World Code : </font>
<br>
<input type="text" width="100%" name="WorldCodeInput" autocomplete="off" size="22" maxlength="16" style="text-align:center;font-size:32px;"/>
<br><br>
<font style="font-family:Romanus;font-size:48px;" >My nation name : </font>
<br><br>
<input type="text" width="100%" name="CountryNameInput" size="26" maxlength="20" autocomplete="off" style="text-align:center;font-size:32px;"/>
<br><br>
<font style="font-family:Romanus;font-size:48px;" >My national colour: </font>
<br><br>
<table style="width:min-content;margin-left:auto;margin-right:auto;background-color:white;border:10px solid #966F33;">
<tr>
<td style="padding:20px;"> <img style="background-color:#D66B67;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="D66B67"/> </td>
<td style="padding:20px"> <img style="background-color:#DE965D;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="DE965D"/> </td>
</tr>
<tr>
<td style="padding:20px"> <img style="background-color:#ECE788;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="ECE788"/></td>
<td style="padding:20px"> <img style="background-color:#B5DB7F;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="B5DB7F"/> </td>
</tr>
<tr>
<td style="padding:20px"> <img style="background-color:#8ECDD2;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="8ECDD2"/></td>
<td style="padding:20px"> <img style="background-color:#8F97CF;width:64px;height:64px;margin:0px;vertical-align:middle;"/> <input type="radio" width="100%" name="CountryColour" value="8F97CF"/> </td>
</tr>
</table>
<br><br>
<table>
<button type="submit" id="Submit" style="background-color:green;color: white;text-align: center;display: inline-block;font-size: 64px;margin: 4px 2px;cursor: pointer;width:600px;height:80px;border:none;font-family:'Helvetica';float:center;" onclick="document.location='index.php'">Submit World Code</button>
</form>
<br><br>
</div>
<br><br><br>
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