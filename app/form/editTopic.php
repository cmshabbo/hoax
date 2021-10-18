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
	
	$canEdit = false;
	if($topicInfo[0]["author"] == $userInfo[0]["rank"] || $userInfo[0]["rank"] > 7)
	{
		$canEdit = true;
	}
	
	if($canEdit == false) {
		echo "error;Vous n'avez pas la permission pour modifier ce topic.";
		return;
	}
	
	if(empty($_POST['titleTopic'])) {
		echo "error;Veuillez indiquer le titre du topic.";
		return;
	}
	
	if(strlen($_POST['titleTopic']) < 5) {
		echo "error;Le titre de votre topic doit contenir 5 caractères minimum.";
		return;
	}
	
	if(strlen($_POST['titleTopic']) > 60) {
		echo "error;Le titre de votre topic doit contenir 60 caractères minimum.";
		return;
	}
	
	if(empty($_POST['descTopic'])) {
		echo "error;Veuillez indiquer le contenu de votre topic.";
		return;
	}
	
	if(strlen($_POST['descTopic']) < 20) {
		echo "error;Le contenu de votre topic doit contenir 20 caractères minimum.";
		return;
	}
	
	if(isset($_POST['imageTopic']) && !empty($_POST['imageTopic'])) {
		$image = $_POST['imageTopic'];
	}
	else
	{
		$image = "";
	}
	
	$db->executeInsert('UPDATE forums_topics SET name=?, content=?, last_update=NOW(), image=? WHERE id=?', array($_POST['titleTopic'], $_POST['descTopic'], $image, $topicInfo[0]["id"]));
	echo "success;Votre topic a bien été modifié.";
	return;
}