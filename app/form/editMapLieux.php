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
	
if(!isset($_GET["id"]) || !is_numeric($_GET["id"]) || !isset($_GET["x"]) || !is_numeric($_GET["x"]) || !isset($_GET["y"]) || !is_numeric($_GET["y"]) || !isset($_GET["image"]) || !isset($_GET["type"]) || !is_numeric($_GET["type"]))
	return;

$mapInfo = $db->executeQuery('SELECT * FROM maps WHERE room_id=?', array($_GET["id"]));
if($mapInfo == null)
{
	$db->executeInsert('INSERT INTO maps (room_id, image, x, y, type) VALUES (?, ?, ?, ?, ?)', array($_GET["id"], $_GET["image"], $_GET["x"], $_GET["y"], $_GET["type"]));
}
else
{
	$db->executeInsert('UPDATE maps SET x = ?, y = ?, image = ?, type = ? WHERE room_id=?', array($_GET["x"], $_GET["y"], $_GET["image"], $_GET["type"], $_GET["id"]));
}