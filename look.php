<?php 
require_once("includes/config.php");
require_once('app/class/database.php');

// Services
$db = new Database();

// Vérification connecté
session_start();
if(!isset($_SESSION['login'])) {
	header("Location: $config_base_url/index");
	exit();
}
else
{	
	if(!isset($_COOKIE['session'])) {
		header("Location: $config_url/logout");
		exit();
	}
	else
	{
		if($_SESSION['login'] != $_COOKIE['session'])
		{
			header("Location: $config_url/logout");
			exit();
		}
	}
	
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	if(!isset($_SESSION['pin'])) {
		header("Location: $configBaseUrL/pin");
		exit();
	}
	else if($_SESSION['pin'] != $userInfo[0]["pin"]) {
		header("Location: $configBaseUrL/logout");
		exit();
	}
	
	$db->executeInsert('UPDATE users SET ip_last = ? WHERE id=? LIMIT 1', array($_SERVER['REMOTE_ADDR'], $userInfo[0]['id']));
	
	$travailUserInfo = $db->executeQuery('SELECT * FROM group_memberships WHERE user_id=? LIMIT 1', array($userInfo[0]["id"]));
	$travailInfo = $db->executeQuery('SELECT * FROM groups WHERE id=?', array($travailUserInfo[0]["group_id"]));
	if($travailUserInfo[0]["group_id"] != 1)
	{
		$rankInfo = $db->executeQuery('SELECT * FROM groups_rank WHERE rank_id = ? AND job_id = ?', array($travailUserInfo[0]["rank_id"], $travailUserInfo[0]["group_id"]));
	}
	
	if($userInfo[0]["confirmed"])
	{
		$confirmedInfo = $db->executeQuery('SELECT * FROM civil_confirmed WHERE user_id=?', array($userInfo[0]["id"]));
		$now = new DateTime;
		$dateConfirmed = new DateTime($confirmedInfo[0]["expire"]);
		if($now > $dateConfirmed)
		{
			$db->executeInsert('DELETE FROM civil_confirmed WHERE user_id = ? LIMIT 1', array($userInfo[0]['id']));
			$db->executeInsert('UPDATE users SET confirmed = 0, motto = "Civil" WHERE id=? LIMIT 1', array($userInfo[0]['id']));
		}
	}
}

echo $userInfo[0]["look"];
?>