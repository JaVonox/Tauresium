<div id="LogoDiv" style="background-image:linear-gradient(to left, rgba(226, 225, 225, 0.2), rgba(226, 225, 225, 1)),url('Backgroundimages/Volcano.png');width:100%;height:120px;overflow:hidden;background-position:center;background-size:100%;text-align:center;">
<table style="width:100%;">
<tr>
<td style="width:59%;text-align:right;"> <font style="font-family:Romanus;font-size:80px;"> Tauresium </font> </td>
<td style="width:20%">
</td>
<td>
<div style="background-color:black;border:5px solid black;border-radius:5px;margin-right:50px;color:white;">
<form action="Scripts/LoginVerify.php" method="POST">
<font style="font-family:Romanus;font-size:18px;"> Login? </font>
<br>
Username:
<input type="text" width="100%" id="Login" name="LoginInput" autocomplete="off"/>
<br>
Password:
<input type="password" width="100%" id="Login" name="PasswordInput" autocomplete="off"/>
<br>
<input type="submit" value="Login"/>
</form>
</div>	
</td>
</tr>
</table>
</div>
<div id="MenuBar" style="background-color:#E4E4E4;width:100%;height:40px;border-bottom:4px solid black;"> 
	<button style="margin-left:20px;" class="menuButton" onclick="document.location='index.php'">Index</button>
	<button class="menuButton" onclick="document.location='NewSession.php'">Create a new world</button>
	<button class="menuButton" onclick="document.location='JoinSession.php'">Create a country</button>
	<button class="tutorialButton" onclick="document.location='HowToPlay.php'">View Tutorial</button>
</div>

<script type="text/javascript" src="Scripts/BackgroundLoader.js"> </script>
