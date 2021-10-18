<?php
require_once('../../includes/config.php');
require_once('../class/database.php');

// Services
$db = new Database();

// Vérification connecté
session_start();
if(!isset($_SESSION['login'])) {
	echo "errorLogin";
} 
else
{
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	
	if(empty($_POST['newEmail'])) {
		echo "errorEmailChamp";
		return;
	}
	
	if(empty($_POST['newEmail'])) {
		echo "errorEmailChamp";
		return;
	}
	
	if(!filter_var($_POST['newEmail'], FILTER_VALIDATE_EMAIL)) {
		echo "errorInvalidEmail";
		return;
	}
	
	if($_POST['newEmail'] == $userInfo[0]["mail"]) {
		echo "errorEmailSame";
		return;
	}
	
	$check_email = $db->executeQuery('SELECT COUNT(*) AS count_row FROM users WHERE mail=?', array($_POST['newEmail']));
	if($check_email[0]["count_row"] == 1)
	{
		echo "errorEmailUsed";
		return;
	}
	
	$db->executeInsert('UPDATE users SET mail = ? WHERE id=?', array($_POST['newEmail'], $userInfo[0]['id']));
	echo "succesEmail";
	return;
}
?>