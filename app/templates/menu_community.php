<?php 
include("../../includes/config.php");
include("global_without_message.php");

if($sessionLogin == true) {
?>
							<li><a href="community" <?php if(!isset($_GET["active"])) { ?>class="active"<?php } ?>><img src="<?php echo $configAssetsUrL; ?>/images/menu/community.png" class="community">Communauté</a></li>
							<li><a href="leaderboard"><img src="<?php echo $configAssetsUrL; ?>/images/trophy.gif" class="trophy">Classements</a></li>
							<li><a href="gang"><img src="<?php echo $configAssetsUrL; ?>/images/gang.png" class="gang">Gangs</a></li>
							<li><a href="forum" <?php if(isset($_GET["active"]) && $_GET["active"] == "forum") { ?>class="active"<?php } ?>><img src="<?php echo $configAssetsUrL; ?>/images/forum/discut.png" class="forum">Forum</a></li>
							
<?php } else { ?>
							<li><a href="#" class="active">Une erreur s'est produite</li>
<?php } ?>
