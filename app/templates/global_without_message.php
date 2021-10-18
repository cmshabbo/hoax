<?php 
include("../../includes/config.php");
require_once('../class/database.php');

session_start();

if(isset($_SESSION['login']) && !empty($_SESSION['login']) && isset($_SESSION['pin'])) {
	$sessionLogin = true;
	$db = new Database();
	return;
}
else  {
	$sessionLogin = false;
	return;
}