<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
?>
					<div class="shop">
						<div class="column70 left">
							<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/jetons_add.png" style="width: 25px !important;"> Obtenir des jetons</div></h1>
							<div class="confirmed">Un code équivaut à 100 jetons.</div>
							<iframe src="https://script.starpass.fr/iframe/kit_default.php?idd=416956&background=0B4876&verif_en_php=1" width="545" height="420" frameborder="0" style="margin-top: 20px"></iframe>
							
						</div>
						
						<div class="column30 right">
							<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/jetons.png"> Mes jetons</div></h1>
							<div class="jetons">Vous disposez de <?php echo $userInfo[0]["jetons"]; ?> jetons.</div>
						</div>
					</div>
					
					<div class="clearfix"></div>
<?php } ?>
