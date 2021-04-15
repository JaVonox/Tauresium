<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="100505349">
<link rel="stylesheet" href="MainStyle.css">
<title>
Tauresium - Login
</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="API/APIScripts/BuiltInAPIcalls.js"></script>
</head>
<body style="background-color:white;margin:0px;">

<?php include "PageElements/NeutralTopBar.php" ?>

<div style="background-color:lightgrey;width:95%;min-height:570px;overflow:auto;text-align:center;border:5px solid lightgrey;border-radius:15px;margin-left:auto;margin-right:auto;" class="InformationText">
<font style="font-size:32px;"> Sorry that login was not recognised, please try again: </font>
<br><br>
<div style="background-color:#e0e0e0;border-radius:5px;margin-right:auto;margin-left:auto;color:black;width:50%;">
<form action="Scripts/LoginVerify.php" method="POST">
<font style="font-family:Romanus;font-size:48px;"> Login? </font>
<br><br>
<div style="width:400px;margin-left:auto;margin-right:auto;">
<font style="font-family:Arial;font-size:14px;word-wrap: break-word;">Usernames and passwords are case sensitive - please remember to ensure you do not have capslock enabled when entering your information</font>
</div>
<br><br>
Username:
<input style="font-size:24px;" type="text" width="100%" id="Login" size="20" name="LoginInput" autocomplete="off"/>
<br><br>
Password:
<input style="font-size:24px;" type="password" width="100%" id="Login" size="20"  name="PasswordInput" autocomplete="off"/>
<br><br>
<input style="font-family:Romanus;font-size:32px;" class="gameButton" type="submit" value="Login"/>
</form>
</div>
</div>


<?php include "PageElements/Disclaimer.html" ?>
</body>
</html>