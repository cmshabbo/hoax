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
	
	if(empty($_POST['lastPassword']) OR empty($_POST['newPassword']) OR empty($_POST['newPasswordConfirm'])) {
		echo "errorPasswordChamp";
		return;
	}
	
	if($userInfo[0]["password"] != md5($_POST['lastPassword'])) {
		echo "errorLastPassword";
		return;
	}
	
	if(strlen($_POST['newPassword']) < 6) {
		echo "passwordMinCaractere";
		return;
	}
	
	if(md5($_POST['newPassword']) == $userInfo[0]["password"]) {
		echo "newPasswordSame";
		return;
	}
	
	if($_POST['newPassword'] != $_POST['newPasswordConfirm']) {
		echo "newPasswordDifferent";
		return;
	}
	
	$db->executeInsert('UPDATE users SET password = ? WHERE id=?', array(md5($_POST['newPassword']), $userInfo[0]['id']));
	echo "succesPassword";
	return;
}