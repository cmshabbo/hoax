<?php 
require_once("../../includes/config.php");
?>
			
			<div class="animated fadeInUp">
					<h1><span class="headline">Connexion à BobbaRP</span></h1>
					<div class="login">
						<form action="<?php echo $configBaseUrL; ?>/index" method="POST">
							<input type="text" id="first_name" placeholder="Votre nom" class="user1">
							<input type="text" id="last_name" placeholder="Votre prénom" class="user">
							<input type="password" id="password" placeholder="Mot de passe" class="password">
							<img src="<?php echo $configAssetsUrL; ?>/images/helico.gif" class="animated swing infinite">
					</div>
							<input type="submit" id="loginButton" value="Se connecter" class="btn_pink">
							<a href="javascript:void(0)" class="btn btn_blue" id="register">ou... Inscris-toi!</a>
						</form>
			</div>