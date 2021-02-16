<?php
session_start();
if(isset($_SESSION['user']))
{
	include_once 'PageElements/TopBar.php';
}
else
{
	include_once 'PageElements/LoginTopBar.php';
}

?>