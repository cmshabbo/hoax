<?php
require_once('../../includes/config.php');
require_once('../class/database.php');

// Services
$db = new Database();

// Vérification connecté
session_start();
if(!isset($_SESSION['login'])) {
	echo "error;Veuillez vous reconnectez.";
} 
else
{
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));

	if(empty($_POST['jetonsUsername']) OR empty($_POST['jetonsMontant'])) {
		echo "error;Veuillez remplir tous les champs.";
		return;
	}
	
	$userInfoJetons = $db->executeQuery('SELECT * FROM users WHERE username=?', array($_POST['jetonsUsername']));
	if($userInfoJetons == null) {
		echo "error;Le pseudonyme n'est pas valide.";
		return;
	}
	
	if($userInfo[0]["username"] == $userInfoJetons[0]["username"]) 
	{
		echo "error;Vous ne pouvez pas envoyer des jetons à vous même.";
		return;
	}
	
	if(!is_numeric($_POST['jetonsMontant']) || $_POST['jetonsMontant'] <= 0) {
		echo "error;Le montant est invalide.";
		return;
	}
	
	if($_POST['jetonsMontant'] > $userInfo[0]["jetons"]) {
		echo "error;Vous n'avez pas " . $_POST['jetonsMontant'] . " jetons.";
		return;
	}
	
	$db->executeInsert('UPDATE users SET jetons = jetons - ? WHERE id = ?', array($_POST['jetonsMontant'], $userInfo[0]['id']));
	$db->executeInsert('UPDATE users SET jetons = jetons + ? WHERE id = ?', array($_POST['jetonsMontant'], $userInfoJetons[0]['id']));
	echo "success;Vous avez bien envoyé " . $_POST['jetonsMontant'] . " jetons à " . $userInfoJetons[0]["username"] . ".";
	return;
}