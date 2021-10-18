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
	
	$travailUserInfo = $db->executeQuery('SELECT * FROM group_memberships WHERE user_id=? LIMIT 1', array($userInfo[0]["id"]));
		
	$canEditProduits = false;
	if($travailUserInfo[0]["group_id"] == 18 && $travailUserInfo[0]["rank_id"] == 3 || $travailUserInfo[0]["group_id"] == 18 && $travailUserInfo[0]["rank_id"] == 7 || $travailUserInfo[0]["group_id"] == 18 && $travailUserInfo[0]["rank_id"] == 8 || $userInfo[0]["rank"] == 8)
	{
		$canEditProduits = true;
	}
	
	if($canEditProduits == false)
	{
		echo "error;Vous n'avez pas la permission pour faire ça.";
		return;
	}
	
	if(empty($_POST['prixLook']) OR empty($_POST['taxeLook']) OR empty($_POST['inventeLook'])) {
		echo "error;Veuillez remplir tous les champs.";
		return;
	}
	
	if(!is_numeric($_POST['idLook']) || $_POST['idLook'] < 1) {
		echo "error;Une erreur est survenue.";
		return;
	}
	
	if(!is_numeric($_POST['prixLook']) || $_POST['prixLook'] < 1) {
		echo "error;Le prix est invalide.";
		return;
	}
	
	if(!is_numeric($_POST['taxeLook']) || $_POST['taxeLook'] < 0 || $_POST['taxeLook'] >= $_POST['prixLook']) {
		echo "error;La taxe est invalide.";
		return;
	}
	
	if($_POST['inventeLook'] == "Oui") {
		$valueInvente = 1;
	}
	else
	{
		$valueInvente = 0;
	}
	
	$db->executeInsert('UPDATE looks SET price = ?, taxe = ?, invente = ? WHERE id = ?', array($_POST['prixLook'], $_POST['taxeLook'], $valueInvente, $_POST['idLook']));
	echo "success;Le look a bien été modifié.";
	return;
}