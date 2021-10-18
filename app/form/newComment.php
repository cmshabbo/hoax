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
	
	if(empty($_POST['topicReponse']) || !is_numeric($_POST['topicReponse'])) {
		echo "error;Une erreur est survenue.";
		return;
	}
	
	$topicInfo = $db->executeQuery('SELECT * FROM forums_topics WHERE id = ? LIMIT 1', array($_POST['topicReponse']));
	if(count($topicInfo) == 0) {
		echo "error;Une erreur est survenue.";
		return;
	}
	
	if($topicInfo[0]["topic_locked"] == 1) {
		echo "error;Ce topic est fermé.";
		return;
	}
	
	if(empty($_POST['descReponse'])) {
		echo "error;Veuillez indiquer le contenu de votre topic.";
		return;
	}
	
	if(strlen($_POST['descReponse']) < 20) {
		echo "error;Le contenu de votre topic doit contenir 20 caractères minimum.";
		return;
	}
	
	$db->executeInsert('UPDATE forums_topics SET last_user = ?, last_update_comment = NOW() WHERE id = ?', array($userInfo[0]["id"], $topicInfo[0]["id"]));
	$db->executeInsert('INSERT INTO forums_comments (user_id, topic_id, content, date, last_update) VALUES (?, ?, ?, NOW(), NOW())', array($userInfo[0]["id"], $topicInfo[0]["id"], $_POST['descReponse']));
	echo "success;". $topicInfo[0]["id"];
	return;
}