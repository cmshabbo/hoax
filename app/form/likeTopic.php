<?php
require_once('../../includes/config.php');
require_once('../class/database.php');

// Services
$db = new Database();

// Vérification connecté
session_start();
if(!isset($_SESSION['login'])) {
	echo "error;Veuillez vous reconnecter.";
} 
else
{
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=? LIMIT 1', array($_SESSION['login']));
	
	if(empty($_POST['idTopic']) || !is_numeric($_POST['idTopic'])) {
		echo "error;Une erreur est survenue.";
		return;
	}
	
	$topicInfo = $db->executeQuery('SELECT * FROM forums_topics WHERE id = ? LIMIT 1', array($_POST['idTopic']));
	if(count($topicInfo) == 0) {
		echo "error;Une erreur est survenue.";
		return;
	}
	
	$userInfoLike = $db->executeQuery('SELECT * FROM forums_like WHERE user_id = ? AND topic_id = ? LIMIT 1', array($userInfo[0]["id"], $topicInfo[0]["id"]));
	if(count($userInfoLike) == 0) {
		$db->executeInsert('INSERT INTO forums_like (user_id, topic_id) VALUES (?, ?)', array($userInfo[0]["id"], $topicInfo[0]["id"]));
	}
	else
	{
		$db->executeInsert('DELETE FROM forums_like WHERE user_id=? AND topic_id = ? LIMIT 1', array($userInfo[0]["id"], $topicInfo[0]["id"]));
	}
	
	$totalLike = $db->executeQuery('SELECT * FROM forums_like WHERE topic_id = ?', array($topicInfo[0]["id"]));
	if(count($totalLike) == 1 || count($totalLike) == 0)
	{
		$phrase = count($totalLike)." personne aime ça";
	}
	else
	{
		$phrase = count($totalLike)." personnes aiment ça";
	}
	
	echo "success;".$phrase;
	return;
}