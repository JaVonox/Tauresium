<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<link rel="stylesheet" href="MainStyle.css">
<title>
Tauresium - Event
</title>
</head>
<body style="background-color:white;margin:0px;">

<?php include_once 'Scripts/PageUpdate.php'?>
<?php include_once "Scripts/DBLoader.php";?>
<?php include_once "Scripts/CheckLogin.php";?>

<?php
$database = new Database();
$db = $database->getConnection();
$LoadedEvent = $database->GetEvent(session_id());
$BadEvents = True; //This is true if an event cannot be loaded.

if(is_array($LoadedEvent)) //This occurs if there is enough event stacks
{
	$BadEvents = False;
}
else
{
	$BadEvents = True;
}

?>

<div style="background-color:lightgrey;width:95%;min-height:570px;overflow:auto;text-align:center;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">
	<font style="font-size:72px;color:black;font-family:Romanus;"> <?php echo $BadEvents ? 'No Event' : $LoadedEvent['Title'] ?>  </font>
	<br><br>
	<div style="width:60%;margin-left:auto;margin-right:auto;font-size:24px;">
	<?php echo $BadEvents ? 'No Event' : $LoadedEvent['Description'] ?>
	</div>
	<br><br><br><br>
	<form>
	<input type="submit" class="gameButton" name="Option1" style="font-size:24px;" value="<?php echo $BadEvents ? 'No Event' : $LoadedEvent['Option_1_Desc'] ?>">  </input>
	<br><br><br>
	<input type="submit" class="gameButton" name="Option2" style="font-size:24px;" value="<?php echo $BadEvents ? 'No Event' : $LoadedEvent['Option_2_Desc'] ?>">  </input>
	<br><br><br>
	<input type="submit" class="gameButton" name="Option3" style="font-size:24px;" value="<?php echo $BadEvents ? 'No Event' : $LoadedEvent['Option_3_Desc'] ?>">  </input>
	</form>
</div>

<div class="Disclaimer">
	<p style="margin-left:10%;margin-right:10%;"> Program by 100505349.
	This web application is not intended to be an accurate representation of political borders or cultural boundaries. The map shown in this production is a rough triangulated map meant to serve as a
	representation - with regions being represented by relevant locations (which may not be placed properly).
	The map constructed in this application was made by hand by 100505349 - using image references to properly plot the coordinates </p>	
</div>
</body>
</html>