<?php
require_once('../../includes/config.php');
require_once('../../includes/websockets.php');
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
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	
	if($userInfo[0]["confirmed"] == 1) {
		echo "error;Vous êtes déjà civil confirmé.";
		return;
	}
	
	if($userInfo[0]["jetons"] < 100) {
		echo "error;Il vous faut 100 jetons pour devenir civil confirmé.";
		return;
	}
	
	
	$db->executeInsert('INSERT INTO civil_confirmed (user_id, expire) VALUES (?, CURDATE() + INTERVAL 1 MONTH)', array($userInfo[0]['id']));
	$db->executeInsert('UPDATE users SET motto = "Civil confirmé", jetons = jetons - 100, confirmed = 1 WHERE id=?', array($userInfo[0]['id']));
	echo "success;Vous êtes désormais civil confirmé.";
	Mus('confirmed', $userInfo[0]["id"]);
	return;
}
?>