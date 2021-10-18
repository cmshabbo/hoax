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
	
	if(empty($_POST['idComment']) || !is_numeric($_POST['idComment'])) {
		echo "error;Une erreur est survenue.";
		return;
	}
	
	$commentInfo = $db->executeQuery('SELECT * FROM forums_comments WHERE id = ? LIMIT 1', array($_POST['idComment']));
	if(count($commentInfo) == 0) {
		echo "error;Une erreur est survenue.";
		return;
	}
	
	$canDelete = false;
	
	if($userInfo[0]["rank"] > 7 || $userInfo[0]["id"] == $commentInfo[0]["user_id"])
	{
		$canDelete = true;
	}
	
	if($canDelete == false) {
		echo "error;Vous n'avez pas la permission pour faire ça.";
		return;
	}
	
	echo "success;".$commentInfo[0]['topic_id'];
	$db->executeInsert('DELETE FROM forum_like_comments WHERE comment_id=?', array($commentInfo[0]['id']));
	$db->executeInsert('DELETE FROM forums_comments WHERE id=?', array($commentInfo[0]['id']));
	return;
}