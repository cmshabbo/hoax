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
	
	if(empty($_POST['categoryTopic']) || !is_numeric($_POST['categoryTopic'])) {
		echo "error;Une erreur est survenue.";
		return;
	}
	
	$categoryInfo = $db->executeQuery('SELECT * FROM forums_category WHERE id = ? LIMIT 1', array($_POST['categoryTopic']));
	if(count($categoryInfo) == 0) {
		echo "error;Une erreur est survenue.";
		return;
	}
	
	if($categoryInfo[0]["rank"] > $userInfo[0]["rank"]) {
		echo "error;Vous n'avez pas la permission pour poster dans cette catégorie.";
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
	
	$db->executeInsert('INSERT INTO forums_topics (category_id, name, content, author, date, last_user, last_update, image, last_update_comment) VALUES (?, ?, ?, ?, NOW(), ?, NOW(), ?, NOW())', array($_POST['categoryTopic'], $_POST['titleTopic'], $_POST['descTopic'], $userInfo[0]["id"], $userInfo[0]["id"], $image));
	$lastTopicId = $db->executeQuery('SELECT id FROM forums_topics WHERE author=? ORDER BY id DESC LIMIT 1', array($userInfo[0]["id"]));
	echo "success;". $lastTopicId[0]["id"];
	return;
}