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
	
	$userInfoLike = $db->executeQuery('SELECT * FROM forum_like_comments WHERE user_id = ? AND comment_id = ? LIMIT 1', array($userInfo[0]["id"], $commentInfo[0]["id"]));
	if(count($userInfoLike) == 0) {
		$db->executeInsert('INSERT INTO forum_like_comments (user_id, comment_id) VALUES (?, ?)', array($userInfo[0]["id"], $commentInfo[0]["id"]));
	}
	else
	{
		$db->executeInsert('DELETE FROM forum_like_comments WHERE user_id=? AND comment_id = ? LIMIT 1', array($userInfo[0]["id"], $commentInfo[0]["id"]));
	}
	
	$totalLike = $db->executeQuery('SELECT * FROM forum_like_comments WHERE comment_id = ?', array($commentInfo[0]["id"]));
	if(count($totalLike) == 1 || count($totalLike) == 0)
	{
		$phrase = count($totalLike)." personne aime ça";
	}
	else
	{
		$phrase = count($totalLike)." personnes aiment ça";
	}
	
	echo "success;".count($userInfoLike).";".$phrase;
	return;
}