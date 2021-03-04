<?php
$pageType = $_GET["Type"];
$code = (!isset($_GET["Code"]) ? "" : $_GET["Code"] );
$content = "<font style='font-size:32px;'>";

if($pageType == "Country")
{
	$content = $content . "Congratulations, you have successfully registered your country!
	<br><br>
	Please login with your country name and password in the login box at the top of any screen.
	<br><br><br></font>";
}
else if($pageType == "World")
{
	$content = $content . "Congratulations, you have successfully created your world!
	<br><br>
	You can now create your nation within this world by using the world code provided below. Please keep note of this code as you will need it to log in or to give to other players in your session.
	<br><br><br></font></div><div style='width:min-content;;margin-left:auto;margin-right:auto;'><font style='font-size:92px;font-family:Romanus;'><i>". $code . "</i></font>";
}
else
{
	header("Location: ErrorPage.php"); 
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<link rel="stylesheet" href="MainStyle.css">
<title>
Tauresium - Success
</title>
</head>
<body style="background-color:white;margin:0px;">

<?php include_once 'Scripts/PageUpdate.php'?>

<div style="background-color:lightgrey;width:95%;min-height:570px;overflow:auto;text-align:center;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">
	<font style="font-size:72px;color:green;"> Success! </font>
	<br><br>
	<div style="width:60%;margin-left:auto;margin-right:auto;">
	<?php echo $content ?>
	</div>
</div>

<?php include "PageElements/Disclaimer.html" ?>
</body>
</html>