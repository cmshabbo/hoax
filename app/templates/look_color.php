<?php 
include("../../includes/config.php");
include("global_without_message.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	$colorUser = $db->executeQuery('SELECT * FROM looks_users WHERE code = ? AND user_id = ?', array($_GET["id"], $userInfo[0]["id"]));
	foreach ($colorUser as $colorUserRow) {
		echo '<li class="color colorItem'.$colorUserRow["color"].'" id="'.$colorUserRow["color"].'"></li> ';
	}
}