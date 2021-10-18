<?php 
require_once("includes/config.php");
require_once('app/class/database.php');

// Services
$db = new Database();

// Vérification connecté
session_start();
if(isset($_SESSION['login'])) {
		header("Location: $configBaseUrL/home");
		exit();
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $configName; ?></title>
		<link rel="icon" type="image/png" href="<?php echo $configAssetsUrL; ?>/images/favicon.png" />
		<meta property="og:image" content="<?php echo $configAssetsUrL; ?>/images/logo_info.png" />
		<meta name="description" content="Sur BobbaRP, devenez un réél civil et devenez le plus riche du serveur ! De nombreuses exclusivités vous attendent..." />
		<meta charset="UTF-8"/>
		<link type="text/css" rel="stylesheet" href="<?php echo $configAssetsUrL; ?>/css/index.css"/>
		<link rel="stylesheet" href="<?php echo $configAssetsUrL; ?>/css/animate.css">
		<link rel="stylesheet" href="<?php echo $configAssetsUrL; ?>/css/fontawesome.css">
		<link href="https://fonts.googleapis.com/css?family=Oswald|Open+Sans|Roboto" rel="stylesheet">
	</head>
	
	<body>
		<div id="alertJs" class="error"></div>
		
		<div id="global">
			<div class="header">
				<a href="<?php echo $configBaseUrL; ?>"><img src="<?php echo $configAssetsUrL; ?>/images/logo_small.png" class="logo animated fadeInLeft"></a>
				<div class="online animated fadeInRight"><?php  
				$onlineUsers = $db->executeQuery('SELECT users_online FROM server_status');
				echo $onlineUsers[0]['users_online']; ?> civils dans la ville</div>
				<div class="clearfix"></div>
				<hr/>
			</div>
			
			<div id="indexContent">
				<div class="animated fadeInUp">
					<h1><span class="headline">Connexion à <?php echo $configName; ?></span></h1>
					<div class="login">
						<form action="index.php" method="POST">
							<input type="text" id="first_name" placeholder="Votre nom" class="user1">
							<input type="text" id="last_name" placeholder="Votre prénom" class="user">
							<input type="password" id="password" placeholder="Mot de passe" class="password">
							<img src="<?php echo $configAssetsUrL; ?>/images/helico.gif" class="animated swing infinite">
					</div>
							<input type="submit" id="loginButton" value="Se connecter" class="btn_pink">
							<a href="javascript:void(0)" class="btn btn_blue" id="register">ou... Inscris-toi!</a>
						</form>
				</div>
			</div>
			
			<div class="last_action animated fadeInRight">
				<?php
				$lastAction = $db->executeQuery('SELECT * FROM last_actions ORDER BY id DESC LIMIT 3');
				foreach ($lastAction as $lastActionRow) {
					$userInfoAction = $db->executeQuery('SELECT * FROM users WHERE id = ?', array($lastActionRow["user_id"]));
				?>
				<div class="row">
					<img src="//habbo.fr/habbo-imaging/avatarimage?figure=avatarimage?figure=<?php echo $userInfoAction[0]["look"]; ?>&head_direction=3&gesture=sml&size=l&size=l">
					<div class="username"><?php echo $userInfoAction[0]["username"]; ?></div>
					<div class="message"><?php echo $lastActionRow["action_maked"]; ?></div>
					<div class="clearfix"></div>
				</div>
				<?php
				}
				?>
			</div>
			
			<div class="clearfix"></div>
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="<?php echo $configAssetsUrL; ?>/js/index.js"></script>
	</body>
</html>