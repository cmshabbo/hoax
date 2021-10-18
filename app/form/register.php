<?php
require_once('../../includes/config.php');
require_once('../../includes/websockets.php');
require_once('../class/database.php');

// Services
$db = new Database();

// Vérification connecté
session_start();
if(!isset($_SESSION['login'])) {
	if(empty($_POST['first_name']) OR empty($_POST['last_name']) OR empty($_POST['email']) OR empty($_POST['password']) OR empty($_POST['password_confirm']) OR empty($_POST['sexe'])) 
	{
		echo "errorRegisterChamp";
		return;
	}
	
	if(strlen($_POST['first_name']) < 3) {
		echo "firstNameMinCaractere";
		return;
	}
	
	if(strlen($_POST['first_name']) > 7) {
		echo "firstNameMaxCaractere";
		return;
	}
	
	if(!ctype_alnum($_POST['first_name'])) {
		echo "firstNameInvalidCaractere";
		return;
	}
	
	if(mb_strtoupper($_POST['first_name']) == "ADMIN" OR mb_strtoupper($_POST['first_name']) == "MOD" OR mb_strtoupper($_POST['first_name']) == "ARCHITECTE") {
		echo "firstNamePrefix";
		return;
	}
		
	if(strlen($_POST['last_name']) < 3) {
		echo "lastNameMinCaractere";
		return;
	}
	
	if(strlen($_POST['last_name']) > 7) {
		echo "lastNameMaxCaractere";
		return;
	}
	
	if(!ctype_alnum($_POST['last_name'])) {
		echo "lastNameInvalidCaractere";
		return;
	}
	
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		echo "emailInvalid";
		return;
	}
	
	$checkDoubleAccount = $db->executeQuery('SELECT COUNT(*) AS count_row FROM users WHERE ip_last=?', array($_SERVER['REMOTE_ADDR']));
	if($checkDoubleAccount[0]["count_row"] > 0)
	{
		echo "doubleAccount";
		return;
	}
	
	$check_email = $db->executeQuery('SELECT COUNT(*) AS count_row FROM users WHERE mail=?', array($_POST['email']));
	if($check_email[0]["count_row"] == 1)
	{
		echo "emailUsed";
		return;
	}
	if(strlen($_POST['password']) < 6) {
		echo "passwordMinCaractere";
		return;
	}
	
	if($_POST['password'] != $_POST['password_confirm']) {
		echo "passwordDifferent";
		return;
	}
	
	$username = $_POST['first_name']."-".$_POST['last_name'];
	$check_username = $db->executeQuery('SELECT COUNT(*) AS count_row FROM users WHERE username=?', array($username));
	if($check_username[0]["count_row"] == 1)
	{
		echo "usernameUsed";
		return;
	}
	
	if($_POST['sexe'] == "f") {
		$gender = "F";
		$look = "hr-834-61.lg-710-110.hd-600-2.ch-640-49.sh-725-110";
	} else {
		$gender = "M";
		$look = "hr-3090-61.lg-280-110.hd-180-2.ch-215-49.sh-290-110";
	}
	
	$sessionKey = $configName.'-'.rand(9,999).'/'.substr(sha1(time()).'/'.rand(9,9999999).'/'.rand(9,9999999).'/'.rand(9,9999999),0,33);
	$timestamp = strtotime(date("Y-m-d H:i:s"));
	$db->executeInsert('INSERT INTO users (username, password, mail, auth_ticket, look, gender, account_created, ip_last, ip_reg, mutuelle_expiration, telForfaitReset) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())', array($username, md5($_POST['password']), $_POST['email'], $sessionKey, $look, $gender, $timestamp, $_SERVER['REMOTE_ADDR'], $_SERVER['REMOTE_ADDR']));
	MUS("register", $username); 
	echo "successRegister";
	return;
} 
?>