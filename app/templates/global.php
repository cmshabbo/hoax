<?php 
include("../../includes/config.php");
require_once('../class/database.php');

session_start();

if(isset($_SESSION['login']) && !empty($_SESSION['login']) && isset($_SESSION['pin'])) {
	$sessionLogin = true;
	$db = new Database();
	return;
}
else  {
	echo '<div class="warningMessage"><img src="'.$configAssetsUrL.'/images/frank.gif"><div class="clearfix"></div> Impossible de charger le contenu...<div class="clearfix" style="margin-top: 10px"></div><a href="'.$configBaseUrL.'/logout" class="btn pink">Se reconnecter</a></div>';
	$sessionLogin = false;
	return;
}