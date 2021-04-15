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
	<font style="font-family:Castellar;font-size:52px;line-height:2;" > Tauresium - How To Play </font>
	<br>
	<div style="width:80%;margin-left:auto;margin-right:auto;text-align:left;font-family:Tahoma">
	Hey, and welcome to Tauresium. This webgame is a little pet-project of mine, as well as an assignment for the University of Derby application development module that i have spent far too long on. If you have no idea what this
	is, you can check out the index page for a brief overview of the project, this page will be focusing on how the game is actually played.
	<br>
	<font class="heading"> The Game </font>
	<br>
	In Tauresium, you play as the government of a newly formed nation. It is your responsibility to grow your country, support its people, and defend them from the hungry eyes of other nations. You can play Tauresium with
	up to 4 other friends, who will become the other nations around the world - Compete with them for world dominance, or attempt to maintain peace between your neighbours for a better tomorrow. There is no winner to Tauresium,
	you may play as long as you like, provided you are not conquered by your enemies.
	<br>
	<font class="heading"> Setup </font>
	<br>
	To begin playing, you will need to set up a "World" and a "Nation". 
	<br><br>
	A World is the "room" you will be playing in, only you and anyone you invite to the game will be able to interact with the map in your "World", and you may change the settings to suit your playstyle.
	<br><br>
	A Nation is your login and the name of the country you will be playing. You do not have to pick the name of a real country, it can be whatever name you want, provided another player has not already registered under the same name.
	Your nation will need to be linked to a world in order to play the game.
	<br><br> <button class="menuButton" onclick="document.location='NewSession.php?Sender=HowToPlay'" style="margin-right:20px;">Create a new world</button>
	To set up your account, you should first press the "Create a new world" button, visible near the top of any screen. This will take you to a page where you can decide the properties of your world, and once you are finished, you can
	press the "Create my World!" button to generate your world code. You will need your world code to enter your world, so ensure you copy the code properly.
	<br><br><br> 	<button class="menuButton" onclick="document.location='JoinSession.php?Sender=HowToPlay'" style="margin-right:20px;">Create a country</button>
	Next, you can select the "Create a country" button to begin creating your nation. Like the world screen, you can select your preferred settings for your nation, as well as its name and password, which you will need to remember to
	log into your game next time you wish to play. On this screen you will need to enter the world code you recieved from the "Create a new world" screen.
	<br><br><br>
	When selecting a form of government, you will notice that it show plus and minus symbols above and below an icon. This represents the cultural, economic and military power of your nation. 
	For now, this is not too important, but if you have any preferences for what your nation will focus on : culture, economy or military, you may wish to choose a government form that suits you. Also note that when selecting a government form
	your title at the top of the screen will update, make sure you are happy with the title you have been given before proceeding.
	Once you are done with this, press the "Create my nation" buttons on the screen.
	<br><br>
	Once you have completed these steps you are ready to play Tauresium! Just log into the account you have created and you are ready to play!
	<br>
	<font class="heading"> Playing Tauresium </font>
	<br>
	In Tauresium, your nation will need to balance its three main focuses:
	<table style="width:25%;margin-left:auto;margin-right:auto;">
	<th> Culture </th>
	<th> Economy </th>
	<th> Military </th>
	<tr>
	<td> <img src="Assets/CultureIcon.png" style="width:64px;height:64px;"  alt="Cultural Influence"/>  </td>
	<td> <img src="Assets/EconomicIcon.png" style="width:64px;height:64px;"  alt="Economic Influence"/>  </td>
	<td> <img src="Assets/MilitaryIcon.png" style="width:64px;height:64px;"  alt="Military Influence"/>  </td>
	</tr>
	</table>
	<br>
	When you open up the game you will notice in the top right of the website, your countries values for culture, economics and military will be displayed, these are how much "Influence" you have accumulated in each, and you will
	later use this influence to expand your nation and compete with others.
	Your nation will start with some points dependent on the government form you picked, but you can always get more, through "Events".
	<br>
	<font class="subheading"> Events </font>
	<br>
	<img src="Assets/Tutorial/EventLoaded.png" style="width:386px;height:200px;float:right; margin-right:50px;margin-top:20px;" alt="The event screen"/>
	Events are problems that are occuring in your country that your people wish for you to solve, they are also the main way to gain more influence for your nation. Like the influence values, in the top right, you can see how
	long until you recieve your next event (Dependent on the game speed that the world creator chose), and how many events you have available to complete.
	<br>
	When you have atleast one event available, you should be able to see the green "Events" button on your top bar, clicking this will show you the current problem your country faces, and the options you have for solving it!
	<br><br>
	Think carefully how your actions will affect your citizens, as well as what you are doing by selecting an option. Making a decision sets a precedent, acting aggressively will let the world know your government is to be feared,
	and acting to make your citizens lives better will make your government seem more cultured.
	<br><br>
	When you have selected how you will respond to the problem, you will see a screen telling you the results of your actions, and recieve influence points in all categories depending on how important the issue was to your citizens.
	More importantly, you will see how your national focuses have changed. 
	<img src="Assets/Tutorial/EventResults.png" style="width:585px;margin-left:auto;margin-right:auto;float:right;" alt="The event results screen"/>
	<br><br><br>
	Your government is driven by its focuses. The output of influence from each event is determined by how much the government is focusing on that particular aspect, which will be changed by how you acted in other events.
	<br><br>
	<ul>
	<li>Acting in ways that benefit your people or specifically focus on your national culture will increase how much culture influence you recieve per event </li>
	<li>Acting in ways that prioritise the economy or fill your own pockets will increase your economic influence per event</li>
	<li>Acting in ways that are dictatorial in nature, harm your people, or generally aggressive will increase your military influence per event. </li>
	</ul>
	<br>
	All of this will effect how you are able to spread your nations influence across the globe, either through diplomacy, economic incentives or military action.
	<br>
	<font class="subheading"> The World </font>
	<br>
	As you may have noticed when you first logged in, you are taken to a picture of a world map made of triangles. Each of these triangles is called a "Province" and is a rough region that your nation may control. To control this
	location you must take over the major city in the area using the influence you have gathered. You can click on the triangles on this map to search through the different locations, and the cities that best represent that region
	(Though not always the most geographically accurate). You may also see statistics such as the population of the country, this will be important later.
	<br><br>
	<img src="Assets/Tutorial/WorldMapExample.png" style="width:520px;height:308px;margin-left:auto;margin-right:auto;float:right;" alt="A world map"/>
	First, try to find your nation on the map, it will be a triangle within the highlighted area and will be filled with the colour you selected at the start of the game. This is your nation right now, a single region in a vast world,
	but using the influence you have aquired you will be able to stretch your great empire to the corners of the globe.
	<br><br>
	If you select a province that is unowned (a triangle filled with a cream colour) you can see a button appear on the left hand side with the text "View/Annex Province". This will take you into the province view, inwhich you can inspect the details
	of the location, the name of the city, its owner, the city population, national human development index and national nominal GDP per capita, as well as any additional information relating to the location.
	<br><br>
	At the bottom of this screen, you may see three columns, with the culture, economic and military symbols shown previously, underneath this there is a description of the province influence costs (which will either be a number or say "Infinite").
	This value is the influence points you would need to spend to take this land from your current position - in the cases where it says infinite, this means for some reason, your nation cannot take this land with the selected influence type.
	<br><br>
	Provinces can be taken one of three ways:
	<img src="Assets/Tutorial/ViewProvince.png" style="width:218px;height:291px;margin-left:auto;margin-right:20px;float:left;" alt="View province window"/>
	<br>
	<ul>
	<li> <b>Diplomatically</b> - Your country will attempt to peacefully integrate the location into your empire. This costs a certain amount of culture points, and can only be done in provinces without an owner (another player) that are next to a province you already own.</li>
	<li> <b>Economically</b> - Your country will take buy out the location with its economic superiority. This costs economic points and can only be done to provinces that directly connect to the coast, provided they have no owner and are within a reasonable distance of your own nation (which must first have its own coastal province)</li>
	<li> <b>Militarily</b> - Your country will take the location by force, expending military influence. This can be done to any province that fufils either of the previous requirements, and even may take land from other players. The cost to take land using military action is quite high, and increases in cost depending on certain factors</li>
	</ul>
	<br>
	You can see descriptions of why your nation can and cant take a location above the cost, as well as various other modifiers that increase or decrease the price of a city. The cost of the city is dependent on certain factors. For culture, the base cost is related to the population and HDI of the region.
	For economics, the cost is related to the GDP and HDI of the nation (with a bit of extra value based on culture). The Base military cost depends on the base culture and economic values of the city. These values are further modified with attributes such as cultural significance,
	which makes locations that have a lot of real-world significance cost more culture, as well as terrain based modifiers for the economic and military cost of a city, and finally the actual cost of transporting your militia to the location for military actions.
	<br><br>
	Now that you understand this, you should be able to start taking land with the points you have accrued through your events. There are a few more complications to the system that you do not need to worry about at the moment, but as of now you can start playing Tauresium, taking land and answering your peoples troubles.
	<br>
	<font class="subheading"> The World View and Coastal Dominance </font>
	<br>
	Finally, the last important thing to discuss is the world view. From any screen while logged in, you may click on a tab named after the world you are playing in, which will take you to an overview of the world itself, and other players in your world. In this screen you can see
	the colours of each player (shown by their flag), their country names, their government type as well as their province count, last login date and "coastal dominance". 
	<br><br>
	Coastal dominance refers to the amount of power a player has in a certain coastal region. To travel between coastal regions (Which are often continents), you will need to control a number of locations along the coast line of a region. You can
	see what coastal region a location belongs to by selecting it on the map screen, as long as it is coastal, and you can see how much more provinces you will need to dominate the oceans in that region. Becoming dominant in a region will allow you
	to sail away to far away lands, dependent on where the coast connects to, this can be seen using the vision system, inwhich world map provinces will be greyed out if you cannot possibly access them. When entering a new coastal region, you will gain visibility of all
	connected regions, which you will be able to sail to once you gain dominance in a region.
	<br>
	<font class="heading"> Final Thoughts </font>
	<br>
	At this stage in the tutorial, you now have everything you need to start playing, thank you for reading this fairly long document, and I hope it helps you play! The features discussed here are the basics to playing the game,
	and as time progresses, the game will include more and more features, which hopefully will be easy to understand. And of course, please do not take this game literally, it is a dramatisation of politics, and likely one that is very
	inaccurate to real life.
	<br>
	<font class="subheading"> You are now ready to start playing Tauresium! Have fun! </font>
	<br><br><br>
	</div>
</div>

<?php include "PageElements/Disclaimer.html" ?>
</body>
</html>