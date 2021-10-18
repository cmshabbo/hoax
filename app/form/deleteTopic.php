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
	
	$canDelete = false;
	
	if($userInfo[0]["rank"] > 7 || $userInfo[0]["id"] == $topicInfo[0]["author"])
	{
		$canDelete = true;
	}
	
	if($canDelete == false) {
		echo "error;Vous n'avez pas la permission pour faire ça.";
		return;
	}
	
	$db->executeInsert('DELETE FROM forums_comments WHERE topic_id=?', array($topicInfo[0]['id']));
	$db->executeInsert('DELETE FROM forums_like WHERE topic_id=?', array($topicInfo[0]['id']));
	$db->executeInsert('DELETE FROM forums_topics WHERE id=?', array($topicInfo[0]['id']));
	echo "success;Le topic a bien été supprimé.";
	return;
}