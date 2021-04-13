<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="API/APIScripts/BuiltInAPICalls.js"></script>
<link rel="stylesheet" href="MainStyle.css">
<title>
Tauresium - Event
</title>
</head>
<body style="background-color:white;margin:0px;">

<?php include_once 'Scripts/PageUpdate.php'?>
<?php include_once "Scripts/CheckLogin.php";?>

<div style="background-image:radial-gradient(circle at center, rgba(230, 191, 131, 0.2), rgba(226, 225, 225, 0.2)),url('Backgroundimages/Parliament.png');width:100%;background-repeat:no-repeat;background-position:center;background-size:cover;">
<div style="background-color:lightgrey;width:60%;min-height:570px;overflow:auto;text-align:center;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">
	<img src="Assets/WaxSeal.png" style="width:128px;height:96px;vertical-align:top;"/>
	<font style="font-size:72px;color:black;font-family:Romanus;"><u id="EventTitle"> Loading... </u></font>
	<br><br>
	<div style="width:50%;margin-left:auto;margin-right:auto;font-size:24px;">
	<font id="EventDesc"></font>
	</div>
	<br><br><br><br>
	<form method="POST" action="Scripts/EventCompleted.php">
	<input type="submit" class="gameButton" id="Option1" name="Option1" style="font-size:24px;white-space: normal;word-wrap:break-word;margin-left:40px;margin-right:40px;" value="...">  </input>
	<br><br><br>
	<input type="submit" class="gameButton" id="Option2" name="Option2" style="font-size:24px;white-space: normal;word-wrap:break-word;margin-left:40px;margin-right:40px;" value="...">  </input>
	<br><br><br>
	<input type="submit" class="gameButton" id="Option3" name="Option3" style="font-size:24px;white-space: normal;word-wrap:break-word;margin-left:40px;margin-right:40px;" value="...">  </input>
	</form>
	<br><br><br>
</div>
<div>

<script>
BIGetPlayerEvent("<?php echo $_SESSION['APIKEY'] ?>").done((value => { //Occurs if event is already loaded
	_PopulateEvent(value);
}))
.fail((value => { //If no loaded event exists
	BIPutEvent("<?php echo $_SESSION['APIKEY'] ?>").then((putReturn => { //Attempts to create a new event. Both fail and then run the same function
		_Reload(putReturn.status);
	}))
	.fail((putReturn => {
		_Reload(putReturn.status);
	}))
}));

function _Reload(statusCode) //Checks if the PUT return created a new event.
{
	if(statusCode == 201) //if PUT made a new event, reload page.
	{
		window.location.href = "LoadEvent.php";
	}
	else //If PUT did not make a new event, load error page.
	{
		window.location.href = "ErrorPage.php?Error=BadEventLoad";
	}
}
function _PopulateEvent(eventDetails)
{
	document.getElementById("EventTitle").textContent = eventDetails.Event_Title;
	document.getElementById("EventDesc").textContent = eventDetails.Event_Description;
	document.getElementById("Option1").value = eventDetails.Option1Desc;
	document.getElementById("Option2").value = eventDetails.Option2Desc;
	document.getElementById("Option3").value = eventDetails.Option3Desc;
}
</script>
<?php include "PageElements/Disclaimer.html" ?>
</body>
</html>