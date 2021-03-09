<?php
include_once "DBLoader.php";
if(!isset($_SESSION)) 
{ 
   session_start(); 
} 


if(isset($_SESSION['Country']))
{
	$database = new Database();
	$db = $database->getConnection();
	$database->UpdateEventTimer($_SESSION['Country']);
	include_once 'PageElements/TopBar.php';
}
else
{
	include_once 'PageElements/LoginTopBar.php';
}

?>