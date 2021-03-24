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
	<br>
	<div style="width:65%;margin-left:auto;margin-right:auto;font-family:Tahoma;">
	Tauresium implements a basic REST API structure allowing for players to interact with the game outside of the website itself. This potentially allows the development of third party clients or similar user-created content.
	This page will explain how to use the API yourself, as well as any restrictions on the API.
	<br>
	<font class="heading"> API Syntax </font>
	<br>
	The Tauresium API, TaurAPI, follows a simple syntax structure, as shown below. Entering this URL will notify the program that you are attempting to use the API, and any further parameters will be interpreted as arguments 
	for the request. 
	<br><br>
	<div style="display:block;margin:auto;">
	<input type="textbox" id="APIbox" value="AAA" style="width:60%;font-size:32px;text-align:center;"></input>
	</div>
	<font class="heading"> Request Types </font>
	<br>
	The following parameters are currently supported by the API. (Optional arguments are presented in square brackets, Parameters that require specific entered values are listed in quotation marks).
	<br>
	<font class="subheading"> Province </font>
	<br>
	The Province API call is a GET-only request used to pull province information, this can mean either just the basegame information, or world specific information. The Province API takes the following arguments.
	
	<pre style="font-size:26px;">127.0.0.1/Tauresium/TaurAPI/Province/["Province_ID"]/["World_Code"]</pre>
	
	Entering Just /Province/ Will list all existing provinces and their basic information, unaffected by any world changes.
	<br><br>
	Entering a Province_ID parameter will allow you to restrict your search based on the ID of a province, displaying only the information related solely to that province. Aditionally, if not entering a world code,
	you may enter the capital or region of the province in place of the ID. 
	<br><br>
	Entering a world code will allow you to view world specific information for a single province. This requires the Province ID to be provided as an ID, with regions and capital names not supported. This will return world specific
	information, including the province owner and any constructions made to the location. If no constructions are available, the building name will default to "Administration". It should be noted the returned building information
	is the name of the construction, rather than the identifying building ID. It should also be noted that any invalid world codes or inputs of provinces that are invalid or unoccupied in the specified world will cause the API to 
	return the non-world specific variant of the province, without an included owner or buildings parameter.
	<br><br>
	<font class="subheading"> Country </font>
	<br>
	The Country parameter is a GET-only request used to retrieve information about a specific user. This input cannot be used to request data about all users for privacy reasons.
	
	<pre style="font-size:26px;">127.0.0.1/Tauresium/TaurAPI/Country/"CountryName"</pre>
	
	This request will retrieve information that would typically be available on the world information screen, as well as additional specific information that is normally inaccessible such as the exact influence of a player, this
	also will return all the provinces owned by said player, as well as the relevant world-specific information such as buildings for each location owned.
	<br><br>
	</div>
</div>

<script>
var hostname = window.location.hostname;
document.getElementById("APIbox").value = hostname + "/Tauresium/TaurAPI/";
</script>
<?php include "PageElements/Disclaimer.html" ?>
</body>
</html>