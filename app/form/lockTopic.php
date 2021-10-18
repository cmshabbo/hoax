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
	
	$topicInfoLock = $db->executeQuery('SELECT * FROM forums_topics WHERE id = ? LIMIT 1', array($_POST['idTopic']));
	if(count($topicInfoLock) == 0) {
		echo "error;Une erreur est survenue.";
		return;
	}
	
	$canLock = false;
	
	if($userInfo[0]["rank"] > 7)
	{
		$canLock = true;
	}
	
	if($canLock == false) {
		echo "error;Vous n'avez pas la permission pour faire ça.";
		return;
	}
	
	if($topicInfoLock[0]["topic_locked"] == 1) {
		echo "success;Le topic est désormais ouvert.";
		$db->executeInsert('UPDATE forums_topics SET topic_locked=? WHERE id=?', array("0", $topicInfoLock[0]['id']));
		return;
	}
	
	echo "success;Le topic est désormais fermé.";
	$db->executeInsert('UPDATE forums_topics SET topic_locked=? WHERE id=?', array("1", $topicInfoLock[0]['id']));
	return;
}