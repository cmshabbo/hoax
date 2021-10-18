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
	
	if($userInfo[0]["pin"] == "0") 
	{
		$pinCodeFormat = sprintf("%04d", $_POST['codePin']);

		if(empty($pinCodeFormat)) {
			echo "errorPinBug";
			return;
		}
		
		if(!is_numeric($pinCodeFormat)) {
			echo "errorPinBug";
			return;
		}
		
		if(strlen($pinCodeFormat) != 4) {
			echo "errorPinBug";
			return;
		}
		
		if($pinCodeFormat == "0000") {
			echo "errorPinZero";
			return;
		}
		
		if($userInfo[0]["gender"] == "F") 
		{
			$db->executeInsert('INSERT INTO looks_users (user_id, code, color) VALUES (?, "710", "110")', array($userInfo[0]['id']));
			$db->executeInsert('INSERT INTO looks_users (user_id, code, color) VALUES (?, "640", "49")', array($userInfo[0]['id']));
			$db->executeInsert('INSERT INTO looks_users (user_id, code, color) VALUES (?, "725", "110")', array($userInfo[0]['id']));
		}
		else
		{
			$db->executeInsert('INSERT INTO looks_users (user_id, code, color) VALUES (?, "280", "110")', array($userInfo[0]['id']));
			$db->executeInsert('INSERT INTO looks_users (user_id, code, color) VALUES (?, "215", "49")', array($userInfo[0]['id']));
			$db->executeInsert('INSERT INTO looks_users (user_id, code, color) VALUES (?, "290", "110")', array($userInfo[0]['id']));
		}
		$db->executeInsert('INSERT INTO user_badges (user_id, badge_id) VALUES (?, "Z63")', array($userInfo[0]['id']));
		$db->executeInsert('UPDATE users SET pin = ? WHERE id=?', array($pinCodeFormat, $userInfo[0]['id']));
		$db->executeInsert('INSERT INTO group_memberships (user_id) VALUES (?)', array($userInfo[0]['id']));
		echo "Votre code PIN ".$pinCodeFormat." a bien été créé, il vous sera utile à chaque connexion.";
		return;
	}
	else
	{
		$pinCodeFormat = sprintf("%04d", $_POST['codePin']);

		if(empty($pinCodeFormat)) {
			echo "errorPinBug";
			return;
		}
		
		if(!is_numeric($pinCodeFormat)) {
			echo "errorPinBug";
			return;
		}
		
		if(strlen($pinCodeFormat) != 4) {
			echo "errorPinBug";
			return;
		}
		
		if(strlen($pinCodeFormat) != 4) {
			echo "errorPinBug";
			return;
		}
		
			
		if($userInfo[0]["pin"] != $pinCodeFormat) {
			echo "errorPinDifferent";
			return;
		}
		
		$_SESSION['pin'] = $pinCodeFormat;
		echo "successPIN";
		return;
	}
}
?>