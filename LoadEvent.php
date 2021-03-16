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
$LoadedEvent = $database->GetEvent($_SESSION['Country']);
$BadEvents = True; //This is true if an event cannot be loaded.

if(is_array($LoadedEvent)) //This occurs if there is enough event stacks
{
	$BadEvents = False;
}
else
{
	header("Location: ErrorPage.php?Error=BadEventLoad"); 
}

?>
<div style="background-image:radial-gradient(circle at center, rgba(230, 191, 131, 0.2), rgba(226, 225, 225, 0.2)),url('Backgroundimages/Parliament.png');width:100%;background-repeat:no-repeat;background-position:center;background-size:cover;">
<div style="background-color:lightgrey;width:60%;min-height:570px;overflow:auto;text-align:center;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">
	<img src="Assets/WaxSeal.png" style="width:128px;height:96px;vertical-align:top;horizontal-align:left;"/>
	<font style="font-size:72px;color:black;font-family:Romanus;"><u> <?php echo $BadEvents ? 'No Event' : $LoadedEvent['Title'] ?></u></font>
	<br><br>
	<div style="width:50%;margin-left:auto;margin-right:auto;font-size:24px;">
	<?php echo $BadEvents ? 'No Event' : $LoadedEvent['Description'] ?>
	</div>
	<br><br><br><br>
	<form method="POST" action="Scripts/EventCompleted.php">
	<input type="submit" class="gameButton" name="Option1" style="font-size:24px;white-space: normal;word-wrap:break-word;margin-left:40px;margin-right:40px;" value="<?php echo $BadEvents ? 'No Event' : $LoadedEvent['Option_1_Desc'] ?>">  </input>
	<br><br><br>
	<input type="submit" class="gameButton" name="Option2" style="font-size:24px;white-space: normal;word-wrap:break-word;margin-left:40px;margin-right:40px;" value="<?php echo $BadEvents ? 'No Event' : $LoadedEvent['Option_2_Desc'] ?>">  </input>
	<br><br><br>
	<input type="submit" class="gameButton" name="Option3" style="font-size:24px;white-space: normal;word-wrap:break-word;margin-left:40px;margin-right:40px;" value="<?php echo $BadEvents ? 'No Event' : $LoadedEvent['Option_3_Desc'] ?>">  </input>
	<input name="invisible-loadedEvent" type="hidden" style="display:none" value="<?php echo $LoadedEvent['Event_ID']; ?>">
	</form>
	<br><br><br>
</div>
<div>
<?php include "PageElements/Disclaimer.html" ?>
</body>
</html>