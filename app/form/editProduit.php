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
	
	if(empty($_POST['prixProduit']) OR empty($_POST['taxeProduit'])) {
		echo "error;Veuillez remplir tous les champs.";
		return;
	}
	
	if(!is_numeric($_POST['idProduit']) || $_POST['idProduit'] < 1) {
		echo "error;Une erreur est survenue.";
		return;
	}
	
	if(!is_numeric($_POST['prixProduit']) || $_POST['prixProduit'] < 1) {
		echo "error;Le prix est invalide.";
		return;
	}
	
	if(!is_numeric($_POST['taxeProduit']) || $_POST['taxeProduit'] < 0 || $_POST['taxeProduit'] >= $_POST['prixProduit']) {
		echo "error;La taxe est invalide.";
		return;
	}
	
	$db->executeInsert('UPDATE items_list SET prix = ?, taxe = ? WHERE id = ?', array($_POST['prixProduit'], $_POST['taxeProduit'], $_POST['idProduit']));
	echo "success;Le produit a bien été modifié.";
	return;
}