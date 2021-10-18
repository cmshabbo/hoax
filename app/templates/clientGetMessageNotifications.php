<?php 
include("../../includes/config.php");
require_once('../class/database.php');
$db = new Database();

if(isset($_GET["id"]) && is_numeric($_GET["id"]))
{
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id = ?', array($_GET["id"]));
	$checkNotifications = $db->executeQuery('SELECT COUNT(*) AS count_row FROM telephone_sms WHERE for_user=? AND lu = ?', array($userInfo[0]['id'], "0"));
	echo $checkNotifications[0]["count_row"];
}
?>