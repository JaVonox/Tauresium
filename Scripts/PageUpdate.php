<?php
session_start();
if(isset($_SESSION['Active']))
{
	include_once 'PageElements/TopBar.php';
}
else
{
	include_once 'PageElements/LoginTopBar.php';
}

?>