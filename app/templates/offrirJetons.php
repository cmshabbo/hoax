<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
?>
					<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/gift.png"> Offrir des jetons</h1>
					<form action="<?php echo $configBaseUrL; ?>/home" method="POST">
						<input type="text" id="jetonsUsername" placeholder="Pseudonyme">
						<input type="text" id="jetonsMontant" placeholder="Montant">
						<input type="submit" id="jetonsOffrirButton" value="Offrir des jetons" class="btn_pink">
					</form>
					<div class="clearfix"></div>
<?php
}
