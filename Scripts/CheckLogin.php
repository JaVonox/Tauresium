<?php
if(!isset($_SESSION['Country']))
{
	header("Location: ./ErrorPage.php?Error=BadSession"); //this should be changed to a custom page
}
?>