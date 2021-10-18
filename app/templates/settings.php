<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
?>
					<div class="column50 left">
						<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/parametres.png"> Changer mon mot de passe</div></h1>
						<form action="<?php echo $configBaseUrL; ?>/home" method="POST">
							<input type="password" id="last_password" placeholder="Mot de passe actuel" class="password_confirm">
							<input type="password" id="new_password" placeholder="Votre nouveau mot de passe" class="password">
							<input type="password" id="new_password_confirm" placeholder="Confirmez votre nouveau mot de passe" class="password">
							<input type="submit" id="changePasswordButton" value="Modifier mon mot de passe" class="btn_blue">
						</form>
						<div class="clearfix"></div>
					</div>
					
					<div class="column50 right">
						<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/email_icon.png"> Changer mon email</div></h1>
						<form action="<?php echo $configBaseUrL; ?>/home" method="POST">
							<input type="text" id="last_email" placeholder="Adresse mail actuelle" class="email" value="<?php echo $userInfo[0]["mail"]; ?>" disabled>
							<input type="text" id="newEmail" placeholder="Votre nouvelle adresse mail" class="email">
							<input type="submit" id="changeEmailButton" value="Modifier mon adresse mail" class="btn_pink">
						</form>
						
						<div class="clearfix"></div>
					</div>
					
					<div class="clearfix"></div>
<?php } ?>
