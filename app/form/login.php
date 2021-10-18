<?php
require_once('../../includes/config.php');
require_once('../class/database.php');

// Services
$db = new Database();

// Vérification connecté
session_start();
if(!isset($_SESSION['login'])) {
		if(empty($_POST['first_name']) OR empty($_POST['last_name']) OR empty($_POST['password'])) {
			echo "errorLoginChamp";
		} else {
			$nickname = $_POST['first_name']."-".$_POST['last_name'];
			$stmt = $db->executeQuery('SELECT * FROM users WHERE username=?', array($nickname));
			if(count($stmt) == 1)
			{
				$password = $stmt[0]["password"];
				if(md5($_POST['password']) == $password) {
					$_SESSION['login'] = $stmt[0]["id"];
					echo $stmt[0]["id"];
				} else {
					echo "errorLogin";
				}
			} else {
				echo "errorLogin";
			}
		}
} 
?>