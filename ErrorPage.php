<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<link rel="stylesheet" href="MainStyle.css">
<title>
Tauresium - Error
</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="API/APIScripts/BuiltInAPIcalls.js"></script>
</head>
<body style="background-color:white;margin:0px;">

<?php include "PageElements/NeutralTopBar.php" ?>

<script type="text/javascript" src="Scripts/BackgroundLoader.js"> </script>


<div style="background-color:lightgrey;width:95%;min-height:570px;overflow:auto;text-align:center;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">
	<font style="font-size:72px;"> Error! </font>
	<br><br>
	<font style="font-size:32px;">
	Something appears to have gone wrong while processing your request.
	<br><br>
	This could be caused by inputting an incorrect URL, or might be because something on our side went wrong, please contact the site admin at 100505349@unimail.derby.ac.uk and we will attempt to resolve the issue as soon as possible.
	<br>
	In the meantime, please return to the index using this link:
	<br><br><br>
	<button type="submit" id="Submit" class="backButton" style="text-align: center;display: inline-block;font-size: 64px;margin: 4px 2px;cursor: pointer;font-family:'Helvetica';" onclick="document.location='index.php'">Back to menu</button>
	</font>
</div>

<?php include "PageElements/Disclaimer.html" ?>
</body>
</html>