<?php
if(!isset($_SESSION['Country']))
{
	header("Location: ./ErrorPage.php"); //this should be changed to a custom page
}
?>