<?php 
require_once("includes/config.php");
require_once('app/class/database.php');

// Services
$db = new Database();

// Vérification connecté
session_start();
if(!isset($_SESSION['login'])) {
	header("Location: $config_base_url/index");
	exit();
}
else
{	
	if(!isset($_COOKIE['session'])) {
		header("Location: $config_url/logout");
		exit();
	}
	else
	{
		if($_SESSION['login'] != $_COOKIE['session'])
		{
			header("Location: $config_url/logout");
			exit();
		}
	}
	
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	if(!isset($_SESSION['pin'])) {
		header("Location: $configBaseUrL/pin");
		exit();
	}
	else if($_SESSION['pin'] != $userInfo[0]["pin"]) {
		header("Location: $configBaseUrL/logout");
		exit();
	}
	
	$db->executeInsert('UPDATE users SET ip_last = ? WHERE id=? LIMIT 1', array($_SERVER['REMOTE_ADDR'], $userInfo[0]['id']));
	
	$travailUserInfo = $db->executeQuery('SELECT * FROM group_memberships WHERE user_id=? LIMIT 1', array($userInfo[0]["id"]));
	$travailInfo = $db->executeQuery('SELECT * FROM groups WHERE id=?', array($travailUserInfo[0]["group_id"]));
	if($travailUserInfo[0]["group_id"] != 1)
	{
		$rankInfo = $db->executeQuery('SELECT * FROM groups_rank WHERE rank_id = ? AND job_id = ?', array($travailUserInfo[0]["rank_id"], $travailUserInfo[0]["group_id"]));
	}
	
	if($userInfo[0]["confirmed"])
	{
		$confirmedInfo = $db->executeQuery('SELECT * FROM civil_confirmed WHERE user_id=?', array($userInfo[0]["id"]));
		$now = new DateTime;
		$dateConfirmed = new DateTime($confirmedInfo[0]["expire"]);
		if($now > $dateConfirmed)
		{
			$db->executeInsert('DELETE FROM civil_confirmed WHERE user_id = ? LIMIT 1', array($userInfo[0]['id']));
			$db->executeInsert('UPDATE users SET confirmed = 0, motto = "Civil" WHERE id=? LIMIT 1', array($userInfo[0]['id']));
		}
	}
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $configName; ?></title>
		<link rel="icon" type="image/png" href="<?php echo $configAssetsUrL; ?>/images/favicon.png" />
		<meta property="og:image" content="<?php echo $configAssetsUrL; ?>/images/logo_info.png" />
		<meta charset="UTF-8"/>
		<link type="text/css" rel="stylesheet" href="<?php echo $configAssetsUrL; ?>/css/styles.css"/>
		<link rel="stylesheet" href="<?php echo $configAssetsUrL; ?>//css/animate.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto|Oswald" rel="stylesheet">
	</head>
	
	<body>
		<div id="alertJs" class="error">
			<div class="description"></div>
			<div class="close"><i class="fas fa-times"></i></div>
		</div>
		
		<div id="myPerso" class="hided">
			<div id="tabIcon"><i class="fas fa-bars"></i></div>
			<div class="username"><img src="<?php echo $configAssetsUrL; ?>/images/myhabbo.gif"> <?php echo $userInfo[0]["username"]; ?> </div>
			<hr />
			<div class="container">
				<div class="avatar">
					<img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userInfo[0]["look"]; ?>&head_direction=2&gesture=sml&size=l&size=l" id="avatarAnimed">
					
					<div class="barProgress">
						<div class="barLvl green" style="width: <?php echo $userInfo[0]["sante"]; ?>%"></div>
						<div class="title">Santé : <?php echo $userInfo[0]["sante"]; ?>/100</div>
					</div>
					
					<div class="barProgress">
						<div class="barLvl purple" style="width: <?php echo $userInfo[0]["sommeil"]; ?>%"></div>
						<div class="title">Fatigue : <?php echo $userInfo[0]["sommeil"]; ?>/100</div>
					</div>
					
					<div class="barProgress">
						<div class="barLvl orange" style="width: <?php echo $userInfo[0]["energie"]; ?>%"></div>
						<div class="title">Énergie : <?php echo $userInfo[0]["energie"]; ?>/100</div>
					</div>
					
					<div class="barProgress">
						<div class="barLvl blue" style="width: <?php echo $userInfo[0]["hygiene"]; ?>%"></div>
						<div class="title">Hygiène : <?php echo $userInfo[0]["hygiene"]; ?>/100</div>
					</div>
					
					<div class="clearfix"></div>
				</div>
				
				<h1><span>Mon travail</span></h1>
				<div class="travail">
					<?php
					$travailUserInfo = $db->executeQuery('SELECT * FROM group_memberships WHERE user_id=? LIMIT 1', array($userInfo[0]["id"]));
					$travailInfo = $db->executeQuery('SELECT * FROM groups WHERE id=?', array($travailUserInfo[0]["group_id"]));
					if($travailUserInfo[0]["group_id"] != 1)
					{
						$rankInfo = $db->executeQuery('SELECT * FROM groups_rank WHERE rank_id = ? AND job_id = ?', array($travailUserInfo[0]["rank_id"], $travailUserInfo[0]["group_id"]));
					}
					?>
					<img src="<?php echo $configSwfUrL; ?>/habbo-imaging/badges/<?php echo $travailInfo[0]["badge"]; ?>.gif">
					<span><?php echo  utf8_decode($travailInfo[0]["name"]); ?></span><br />
					<?php if($travailUserInfo[0]["group_id"] != 1) { echo $rankInfo[0]["name"]; } else { echo "Vous n'avez pas d'emploi"; } ?>
					<div class="clearfix"></div>
				</div>
				
				<?php if($userInfo[0]["carte"] || $userInfo[0]["permis_arme"]) { ?>
				<h1><span>Mes documents</span></h1>
				<div class="list">
					<?php if($userInfo[0]["carte"]) { ?>
					<div class="item cyan">
						<img src="<?php echo $configAssetsUrL; ?>/images/carte.gif">
						<div class="number notDisplay">Carte d'identité</div>
					</div>
					<?php } ?>
					
					<?php if($userInfo[0]["permis_arme"]) { ?>
					<div class="item cyan">
						<img src="<?php echo $configAssetsUrL; ?>/images/portarme.png">
						<div class="number notDisplay">Permis port d'armes</div>
					</div>
					<?php } ?>
					
					<div class="clearfix"></div>
				</div>
				<?php } ?>
				
				<h1><span>Mes véhicules</span></h1>
				<div class="list">
					<?php if($travailUserInfo[0]["group_id"] == 4 && $travailUserInfo[0]["rank_id"] > 1) { ?>
					<div class="item red" id="police">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/police.png">
					</div>
					<?php } if($userInfo[0]["white_hover"]) { ?>
					<div class="item red" id="whiteHoverboard">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/whitehover.png">
					</div>
					<?php } if($userInfo[0]["confirmed"] == 1) { ?>
					<div class="item red" id="blackHoverboard">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/blackhover.png">
					</div>
					
					<div class="item red" id="pinkHoverboard">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/pinkhover.png">
					</div>
					<?php } if($travailUserInfo[0]["group_id"] == 18 && $travailUserInfo[0]["rank_id"] > 1) { ?>
					<div class="item red" id="gouvernement">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/gouvernement.png">
					</div>
					<?php } if($userInfo[0]["porsche911"]) { ?>
					<div class="item red" id="porsche911">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/porsche911.png">
					</div>
					<?php } if($userInfo[0]["fiatpunto"]) { ?>
					<div class="item red" id="fiatpunto">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/fiatpunto.png">
					</div>
					<?php } if($userInfo[0]["volkswagenjetta"]) { ?>
					<div class="item red" id="volkswagenjetta">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/volkswagenjetta.png">
					</div>
					<?php } if($userInfo[0]["bmwi8"]) { ?>
					<div class="item red" id="bmwi8">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/bmwi8.png">
					</div>
					<?php } if($userInfo[0]["audia8"]) { ?>
					<div class="item red" id="audia8">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/audia8.png">
					</div>
					<?php } if($userInfo[0]["audia3"]) { ?>
					<div class="item red" id="audia3">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/audia3.png">
					</div>
					<?php } ?>
					
					<div class="clearfix"></div>
				</div>
				
				<?php if($userInfo[0]["batte"] != 0 || $userInfo[0]["sabre"] != 0 || $userInfo[0]["ak47"] != 0 || $userInfo[0]["uzi"] != 0 || $userInfo[0]["cocktails"] > 0 || $travailUserInfo[0]["group_id"] == 4 && $travailUserInfo[0]["rank_id"] > 1) { ?>
				<h1><span>Mes armes</span></h1>
				<div class="list">
					<?php if($travailUserInfo[0]["group_id"] == 4 && $travailUserInfo[0]["rank_id"] > 1) { ?>
					<div class="item purple" id="taser">
						<img src="<?php echo $configAssetsUrL; ?>/images/armes/taser.png">
					</div>
					<?php } if($userInfo[0]["batte"] != 0) { ?>
					<div class="item purple" id="batte">
						<img src="<?php echo $configAssetsUrL; ?>/images/armes/batte.png">
					</div>
					<?php } if($userInfo[0]["sabre"] != 0) { ?>
					<div class="item purple" id="sabre">
						<img src="<?php echo $configAssetsUrL; ?>/images/armes/sabre.png">
					</div>
					<?php } if($userInfo[0]["ak47"] != 0) { ?>
					<div class="item purple" id="ak47">
						<img src="<?php echo $configAssetsUrL; ?>/images/armes/ak47.png">
						<div class="number"><?php echo $userInfo[0]["ak47_munitions"]; ?></div>
					</div>
					<?php } if($userInfo[0]["uzi"] != 0) { ?>
					<div class="item purple" id="uzi">
						<img src="<?php echo $configAssetsUrL; ?>/images/armes/uzi.png">
						<div class="number"><?php echo $userInfo[0]["uzi_munitions"]; ?></div>
					</div>
					<?php } if($userInfo[0]["cocktails"] != 0) { ?>
					<div class="item purple" id="cocktail">
						<img src="<?php echo $configAssetsUrL; ?>/images/armes/cocktail.png">
						<div class="number"><?php echo $userInfo[0]["cocktails"]; ?></div>
					</div>
					<?php } ?>
					
					<div class="clearfix"></div>
				</div>
				<?php } ?>
				
				<h1><span>Mes utilitaires</span></h1>
				<div class="list">
					<div class="item blue">
						<img src="<?php echo $configAssetsUrL; ?>/images/sac.png">
						<?php if($userInfo[0]["sac"] == "1") { ?>
						<div class="number notDisplay">Eastpack</div>
						<?php } elseif($userInfo[0]["sac"] == "2") { ?>
						<div class="number notDisplay">The North Face</div>
						<?php } elseif($userInfo[0]["sac"] == "3") { ?>
						<div class="number notDisplay">Louis Vuitton</div>
						<?php } elseif($userInfo[0]["sac"] == "4") { ?>
						<div class="number notDisplay">Militaire</div>
						<?php } ?>
					</div>
					
					<?php if($userInfo[0]["telephone"]) { ?>
					<div class="item blue">
						<img src="<?php echo $configAssetsUrL; ?>/images/telephone.png">
						<div class="number notDisplay"><?php echo $userInfo[0]["telephone_name"]; ?></div>
					</div>
					<?php } ?>
					<?php if($userInfo[0]["gps"]) { ?>
					<div class="item blue">
						<img src="<?php echo $configAssetsUrL; ?>/images/gps.png">
						<div class="number notDisplay">GPS</div>
					</div>
					<?php } ?>
					<div class="item blue" id="eau">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/eau.png">
						<div class="number"><?php echo $userInfo[0]["eau"]; ?>L</div>
					</div>
					<div class="item blue" id="coca">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/coca.png">
						<div class="number"><?php echo $userInfo[0]["coca"]; ?></div>
					</div>
					<div class="item blue" id="fanta">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/fanta.png">
						<div class="number"><?php echo $userInfo[0]["fanta"]; ?></div>
					</div>
					<div class="item blue" id="pain">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/pain.png">
						<div class="number"><?php echo $userInfo[0]["pain"]; ?></div>
					</div>
					<div class="item blue" id="sucette">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/sucette.png">
						<div class="number"><?php echo $userInfo[0]["sucette"]; ?></div>
					</div>
					<div class="item blue" id="savon">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/savon.png">
						<div class="number"><?php echo $userInfo[0]["savon"]; ?></div>
					</div>
					<div class="item blue" id="doliprane">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/doliprane.png">
						<div class="number"><?php echo $userInfo[0]["doliprane"]; ?></div>
					</div>
					<div class="item blue" id="weed">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/cannabis_color.png">
						<div class="number"><?php echo $userInfo[0]["weed"]; ?>g</div>
					</div>
					<div class="item blue" id="cigarette">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/cigarette.png">
						<div class="number"><?php if($userInfo[0]["philipmo"] > 0 && round($userInfo[0]["philipmo"]/20) == 0) { echo "1"; } elseif($userInfo[0]["philipmo"] > 0) {  echo round($userInfo[0]["philipmo"]/20); } else { echo "0"; } ?></div>
					</div>
					<div class="item blue" id="clipper">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/clipper.png">
						<div class="number"><?php if($userInfo[0]["clipper"] > 0 && round($userInfo[0]["clipper"]/50) == 0) { echo "1"; } elseif($userInfo[0]["clipper"] > 0) {  echo round($userInfo[0]["clipper"]/50); } else { echo "0"; } ?></div>
					</div>
					<div class="item blue" id="jetons">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/jetons.png">
						<div class="number"><?php echo $userInfo[0]["casino_jetons"]; ?></div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		
		<div id="overlay">
			<div class="close"><i class="fas fa-times"></i></div>
			<div class="resize">
				
			</div>
		</div>
		
		<div id="global">
			<div id="globalShowed">
				<div id="beta">
					<i class="fas fa-question"></i>
					<div class="message">
						<b>BobbaRP</b> est en version BETA, cela signifie qu'il ce peut que vous rencontriez quelques bugs.<br/><br/> Afin d'améliorer votre confort, nous vous remercions d'avance pour tous les rapports de bugs que vous effectuerez sur le forum durant votre séjour dans la ville.<br/>De nombreux redémarrages de serveur seront nécessaires dans les premières semaines, nous nous excusons pour cela.
					</div>
				</div>
				
				<div class="header">
					<div class="resize">
						<img src="<?php echo $configAssetsUrL; ?>/images/logo.png" class="LogoIcon">
						<div class="online"><?php  
						$onlineUsers = $db->executeQuery('SELECT users_online FROM server_status');
						echo $onlineUsers[0]['users_online']; ?> civils dans la ville</div>
						
						<ul class="menu">
							<li>
								<a href="home" class="load homeButton"><img src="<?php echo $configAssetsUrL; ?>/images/menu/accueil.png"></a>
								<div class="name">Accueil</div>
							</li>
							<li>
								<a href="community" class="load communityButton"><img src="<?php echo $configAssetsUrL; ?>/images/menu/community.png"></a>
								<div class="name">Communauté</div>
							</li>
							<li>
								<a href="shop" class="load shopButton"><img src="<?php echo $configAssetsUrL; ?>/images/menu/shop.png"></a>
								<div class="name">Boutique</div>
							</li>
							<li>
								<a href="<?php echo $configBaseUrL; ?>/client" target="_blank"><img src="<?php echo $configAssetsUrL; ?>/images/menu/hotel.png"></a>
								<div class="name">Hôtel</div>
							</li>
							<li>
								<a href="<?php echo $configBaseUrL; ?>/logout"><img src="<?php echo $configAssetsUrL; ?>/images/menu/logout.png"></a>
								<div class="name">Déconnexion</div>
							</li>
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>
				
				<div class="submenu">
					<div class="resize">
						<ul id="subMenuLi">
							<li><a href="javascript:void(0)" id="meButton"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userInfo[0]["look"]; ?>&head_direction=3&gesture=sml&size=l&size=n&headonly=1" class="avatar">Moi</a></li>
							<li><a href="home" class="active"><img src="<?php echo $configAssetsUrL; ?>/images/menu/accueil.png" class="home">Accueil</a></li>
							<li><a href="settings"><img src="<?php echo $configAssetsUrL; ?>/images/parametres.png" class="parametres">Paramètres</a></li>
							<li><a href="job"><img src="<?php echo $configAssetsUrL; ?>/images/travail.png" class="travail">Travaux</a></li>
						</ul>
						<div class="clearfix"></div>
					</div>
				</div>
				
				<div id="contentPage" class="resize">
					<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/credits.gif"> Tirage EuroRP</div></h1>
					<div class="tirage">
						<div class="infos">
							<?php
							$euroRP = $db->executeQuery('SELECT * FROM eurorp');
							$euroRP_participants = $db->executeQuery('SELECT COUNT(*) AS count_row FROM eurorp_participants');
							$euroRP_LastWinner = $db->executeQuery('SELECT * FROM users WHERE id=?', array($euroRP[0]["last_winner"]));
							$euroRpLot = ($euroRP[0]["montant"] * 75)/100;
							
							?>
							<img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $euroRP_LastWinner[0]["look"]; ?>&head_direction=2&gesture=sml&action=wav&size=l" class="avatar">
							
							<div class="row_white last_winner">Dernier gagnant : <b><?php echo $euroRP_LastWinner[0]["username"]; ?></b></div>
							<div class="row_white lot">Participants : <b><?php echo $euroRP_participants[0]["count_row"]; ?></b></div>
							
							<div class="win_lot"><?php echo round($euroRpLot); ?> crédits à gagner</div>
						</div>
						
						
						<div class="eurorp">
							<div class="row" id="day">
								<div class="time">?</div>
								<div class="name">jours</div>
							</div>
							
							<div class="row" id="hours">
								<div class="time">?</div>
								<div class="name">heures</div>
							</div>
							
							<div class="row" id="minutes">
								<div class="time">?</div>
								<div class="name">minutes</div>
							</div>
							
							<div class="row" id="seconds">
								<div class="time">?</div>
								<div class="name">secondes</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					
					<div class="column60 left">
						<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/wanted.png"> Quelques civils recherchés</div></h1>
						<div class="wanted">
						<?php
						$userWanted = $db->executeQuery('SELECT * FROM users_wanted ORDER BY RAND() LIMIT 6');
						$count = 0;
						foreach ($userWanted as $userWantedRow) {
							$count++;
							if($count == 1) {
								$rotate = "5deg";
							}
							elseif($count == 2) {
								$rotate = "-5deg";
							}
							elseif($count == 3) {
								$rotate = "10deg";
							}
							elseif($count == 4) {
								$rotate = "0deg";
							}
							elseif($count == 5) {
								$rotate = "15deg";
							}
							elseif($count == 6) {
								$rotate = "-5deg";
							}
							$userWantedInfo = $db->executeQuery('SELECT * FROM users WHERE id = ? LIMIT 1', array($userWantedRow["user_id"]));
						?>
							<div class="row" style="transform: rotate(<?php echo $rotate; ?>);">
								<div class="avatar"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userWantedInfo[0]["look"]; ?>&head_direction=3&gesture=sml&action=wav"></div>
								<div class="username"><?php echo $userWantedInfo[0]["username"]; ?></div>
							</div>
						<?php } ?>
							<div class="clearfix"></div>
						</div>
						
						<div class="clearfix"></div>
					</div>
					
					<div class="column40 right">
						<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/discord.png"> Notre Discord</div></h1>
						<iframe src="https://discordapp.com/widget?id=465588551791280129&theme=dark" width="320" height="350" allowtransparency="true" frameborder="0" class="shadow"></iframe>
					</div>
					
					<div class="clearfix"></div>
				</div>
				
				<div class="footer">
					<div class="resize">
						<img src="<?php echo $configAssetsUrL; ?>/images/logo.png" class="LogoIcon">
						<div class="copyright"><i class="far fa-copyright"></i> 2017-2018 <b><?php echo $configName; ?></b>, tous droits réservés.<br />
						<?php echo $configName; ?> est un projet indépendant, à but non lucratif.<br />
						Nous ne sommes pas approuvés, affiliés, ou offerts par Sulake Corporation LTD.</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="<?php echo $configAssetsUrL; ?>/js/scripts.js"></script>
		<script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>
		
		<script>		
		var images = [
			"//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userInfo[0]["look"]; ?>&head_direction=1&gesture=sml&size=l&size=l",
			"//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userInfo[0]["look"]; ?>&head_direction=2&gesture=sml&size=l&size=l",
			"//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userInfo[0]["look"]; ?>&head_direction=3&gesture=sml&size=l&size=l",
			"//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userInfo[0]["look"]; ?>&head_direction=4&gesture=sml&size=l&size=l",
			"//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userInfo[0]["look"]; ?>&head_direction=5&gesture=sml&size=l&size=l",
			"//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userInfo[0]["look"]; ?>&head_direction=6&gesture=sml&size=l&size=l",
			"//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userInfo[0]["look"]; ?>&head_direction=7&gesture=sml&size=l&size=l",
			"//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userInfo[0]["look"]; ?>&head_direction=8&gesture=sml&size=l&size=l"
		]
		var current = 0;
		setInterval(function(){
		  $('#avatarAnimed').attr('src', images[current]);
		  current = (current < images.length - 1)? current + 1: 0;
			
		},200);
		
		setInterval(function(){
		  $('#myPerso .container').load("app/templates/userInfos.php?id=<?php echo $userInfo[0]["id"]; ?>");
		},10000);
		
		CountDownTimer();
		</script>
		
		<?php 
		if(isset($_GET["error"])) { 
			if($_GET["error"] == "jetons") {
		?>
		<script>
		showAlert("Le codé indiqué n'est pas valide.", "error"); 
		$('#subMenuLi').load("app/templates/menu_shop.php?active=jetons"); 
		$('#contentPage').load("app/templates/jetons.php", function(){
			$('#contentPage').fadeIn('slow');
		});
		</script>
			<?php } else if($_GET["error"] == "client") { ?>
		<script>
		showAlert("Une erreur est survenue.", "error"); 
		</script>
		<?php } else if($_GET["error"] == "logged") { ?>
		<script>
		showAlert("Vous êtes déjà connecté, veuillez patienter.", "error"); 
		</script>
		<?php 
			}
		} elseif(isset($_GET["success"])) {  
			if($_GET["success"] == "jetons") {
		?>
		<script>
		showAlert("Vous avez été crédité de <?php echo $_GET["jetons"]; ?> jetons.", "success");
		$('#subMenuLi').load("app/templates/menu_shop.php?active=jetons"); 
		$('#contentPage').load("app/templates/jetons.php", function(){
			$('#contentPage').fadeIn('slow');
		});
		</script>
			<?php } ?>
		<?php } ?>
	</body>
</html>