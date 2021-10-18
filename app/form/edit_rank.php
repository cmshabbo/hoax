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
	
	$canEditRank = false;
	
	if($userInfo[0]["rank"] == 8 || $travailUserInfo[0]["group_id"] == 18 && $travailUserInfo[0]["rank_id"] == 3) 
	{
		$canEditRank = true;
	}
	
	if($canEditRank != 8) 
	{
		echo "error;Vous n'avez pas la permission pour faire ça.";
		return;
	}
	
	if(empty($_POST['name']) OR empty($_POST['look_h']) OR empty($_POST['look_f']) OR empty($_POST['salaire']) OR empty($_POST['workEverywhere'])) {
		echo "error;Veuillez remplir tous les champs.";
		return;
	}
	
	if(!is_numeric($_POST['rankId']) || $_POST['rankId'] < 1) {
		echo "error;Une erreur est survenue.";
		return;
	}
	
	$rankInfo = $db->executeQuery('SELECT * FROM groups_rank WHERE id=?', array($_POST['rankId']));
	if($rankInfo == null) {
		echo "error;Une erreur est survenue.";
		return;
	}
	
	$groupInfo = $db->executeQuery('SELECT * FROM groups WHERE id=?', array($rankInfo[0]["job_id"]));
	
	if(strlen($_POST['name']) < 2 || strlen($_POST['name']) > 25) {
		echo "error;Le nom du rang doit être compris entre 2 et 25 caractères.";
		return;
	}
	
	/* if(!ctype_alnum(trim(str_replace(' ','',$_POST['name'])))) {
		echo "errorNameNumeric";
		return;
	} */
	
	if(!is_numeric($_POST['salaire']) || $_POST['salaire'] < 1) {
		echo "error;Le salaire doit être numérique.";
		return;
	}
	
	if($_POST['workEverywhere'] == "Oui") {
		$valueWorkEverywhere = 1;
	}
	else
	{
		$valueWorkEverywhere = 0;
	}
	
	if($travailUserInfo[0]["group_id"] == 18 && $travailUserInfo[0]["rank_id"] == 3 && $groupInfo[0]["id"] == 18 && $userInfo[0]["rank"] != 8 || $travailUserInfo[0]["group_id"] == 18 && $travailUserInfo[0]["rank_id"] == 3 && $groupInfo[0]["usine"] == 1 && $userInfo[0]["rank"] != 8)
	{
		echo "error;Le ministre de l'économie ne peut pas gérer le gouvernement ou les usines.";
		return;
	}
	
	if($_POST['salaire'] > $groupInfo[0]["chiffre"] && $groupInfo[0]["payedByGouv"] == 0)
	{
		echo "error;Le salaire ne peut pas être plus haut que le chiffre d'affaire.";
		return;
	}
	
	if($userInfo[0]["rank"] == 8)
	{
		$db->executeInsert('UPDATE groups_rank SET name = ?, look_h = ?, look_f = ?, salaire = ?, work_everywhere = ? WHERE id=?', array($_POST['name'], $_POST['look_h'], $_POST['look_f'], $_POST['salaire'], $valueWorkEverywhere, $_POST['rankId']));
		echo "success;Le rang a bien été modifié.";
	}
	elseif($travailUserInfo[0]["group_id"] == 18 && $travailUserInfo[0]["rank_id"] == 3)
	{
		$db->executeInsert('UPDATE groups_rank SET salaire = ? WHERE id=?', array($_POST['salaire'], $_POST['rankId']));
		echo "success;Le rang a bien été modifié.";
	}
	return;
}