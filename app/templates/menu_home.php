<?php 
include("../../includes/config.php");
include("global_without_message.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
?>
							<li cal><a href="javascript:void(0)" id="meButton"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userInfo[0]["look"]; ?>&head_direction=3&gesture=sml&size=l&size=n&headonly=1" class="avatar">Moi</a></li>
							<li><a href="home" class="active"><img src="<?php echo $configAssetsUrL; ?>/images/menu/accueil.png" class="home">Accueil</a></li>
							<li><a href="settings"><img src="<?php echo $configAssetsUrL; ?>/images/parametres.png" class="parametres">Paramètres</a></li>
							<li><a href="job"><img src="<?php echo $configAssetsUrL; ?>/images/travail.png" class="travail">Travaux</a></li>
							
<?php } else { ?>
							<li><a href="#" class="active">Une erreur s'est produite</li>
<?php } ?>
