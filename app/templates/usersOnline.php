<?php 
include("../../includes/config.php");
require_once('../class/database.php');
$db = new Database();

$onlineUsers = $db->executeQuery('SELECT users_online FROM server_status');
echo $onlineUsers[0]['users_online']." civils dans la ville";
?>