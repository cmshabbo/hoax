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
	
	if(empty($_POST['topicComment']) || !is_numeric($_POST['topicComment'])) {
		echo "error;Une erreur est survenue.";
		return;
	}
	
	$commentInfo = $db->executeQuery('SELECT * FROM forums_comments WHERE id = ? LIMIT 1', array($_POST['topicComment']));
	if(count($commentInfo) == 0) {
		echo "error;Une erreur est survenue.";
		return;
	}
	
	$canEdit = false;
	if($commentInfo[0]["user_id"] == $userInfo[0]["rank"] || $userInfo[0]["rank"] > 7)
	{
		$canEdit = true;
	}
	
	if($canEdit == false) {
		echo "error;Vous n'avez pas la permission pour modifier ce topic.";
		return;
	}
	
	if(empty($_POST['descComment'])) {
		echo "error;Veuillez indiquer le contenu de votre topic.";
		return;
	}
	
	if(strlen($_POST['descComment']) < 20) {
		echo "error;Le contenu de votre topic doit contenir 20 caractères minimum.";
		return;
	}
	
	$db->executeInsert('UPDATE forums_comments SET content=?, last_update=NOW() WHERE id=?', array($_POST['descComment'], $commentInfo[0]["id"]));
	echo "success;" .$commentInfo[0]["topic_id"];
	return;
}