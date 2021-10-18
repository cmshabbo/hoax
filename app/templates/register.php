<?php
	include("../../includes/config.php");
?>
			<div class="animated fadeInUp">
				<h1><span class="headline">Inscription à BobbaRP</span></h1>
				<div class="login">
					<form action="<?php echo $configBaseUrL; ?>/index" method="POST">
						<input type="text" id="first_name" placeholder="Votre nom" class="user1">
						<input type="text" id="last_name" placeholder="Votre prénom" class="user">
						<input type="text" id="email" placeholder="Votre email" class="email">
						<input type="password" id="password" placeholder="Mot de passe" class="password">
						<input type="password" id="password_confirm" placeholder="Confirmez votre mot de passe" class="password_confirm">
						<select id="sexe" class="sexe">
							<option value="" disabled>Sexe</option>
							<option value="h">Homme</option>
							<option value="f">Femme</option>
						</select>
						<img src="<?php echo $configAssetsUrL; ?>/images/helico2.gif" class="animated swing infinite">
				</div>
						<input type="submit" id="registerButton" value="S'inscrire" class="btn_blue">
						<a href="javascript:void(0)" class="btn btn_pink" id="login">ou... Connecte-toi!</a>
					</form>
			</div>