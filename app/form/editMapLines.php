<?php
require_once('../../includes/config.php');
require_once('../class/database.php');

// Services
$db = new Database();

// Vérification connecté
session_start();
if(!isset($_SESSION['login']))
	return;

$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));

if($userInfo == null || $userInfo[0]["rank"] != 8)
	return;
	
if(!isset($_GET["id"]) || !is_numeric($_GET["id"]) || !isset($_GET["x"]) || !isset($_GET["y"]) || !isset($_GET["visible"]) || !isset($_GET["width"]) || !is_numeric($_GET["width"]) || !isset($_GET["type"]))
	return;

$lineInfo = $db->executeQuery('SELECT * FROM maps_line WHERE id=?', array($_GET["id"]));
if($_GET["visible"] == "no")
{
	$db->executeInsert('DELETE FROM maps_line WHERE id=?', array($_GET["id"]));
}
elseif($lineInfo == null)
{
	$db->executeInsert('INSERT INTO maps_line (width, x, y, type) VALUES (?, ?, ?, ?)', array($_GET["width"], $_GET["x"], $_GET["y"], $_GET["type"]));
}
else
{
	$db->executeInsert('UPDATE maps_line SET width = ?, x = ?, y = ?, type = ? WHERE id=?', array($_GET["width"], $_GET["x"], $_GET["y"], $_GET["type"], $_GET["id"]));
}