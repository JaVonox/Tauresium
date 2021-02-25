<?php
include_once "DBLoader.php";
session_start();

if(isset($_SESSION['Active']))
{
	$database = new Database();
	$db = $database->getConnection();
	$database->UpdateEventTimer(session_id());
	include_once 'PageElements/TopBar.php';
}
else
{
	include_once 'PageElements/LoginTopBar.php';
}

?>