<?php 
include("../../includes/config.php");
include("global_without_message.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
?>
							<li><a href="shop" <?php if(!isset($_GET["active"])) { ?>class="active"<?php } ?>><img src="<?php echo $configAssetsUrL; ?>/images/confirmed.png" class="confirmed">Civil confirmé</a></li>
							<li><a href="jetons" <?php if(isset($_GET["active"]) && $_GET["active"] == "jetons") { ?>class="active"<?php } ?>><img src="<?php echo $configAssetsUrL; ?>/images/jetons_add.png" class="jetons">Obtenir des jetons</a></li>
							<li><a href="give_jetons"><img src="<?php echo $configAssetsUrL; ?>/images/gift.png" class="gift">Offrir des jetons</a></li>
							
<?php } else { ?>
							<li><a href="#" class="active">Une erreur s'est produite</li>
<?php } ?>
