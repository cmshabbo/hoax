<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	$confirmed = false;
	if($userInfo[0]["confirmed"])
	{
		$confirmed = true;
		$confirmedInfo = $db->executeQuery('SELECT * FROM civil_confirmed WHERE user_id=?', array($userInfo[0]["id"]));
	}
?>
					<div class="shop">
						<div class="column70 left">
							<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/confirmed.png"> Devenir un civil confirmé</div></h1>
							<div class="confirmed">
								En devant civil confirmé sur BobbaRP, vous pourrez bénéficier d'avatanges exclusifs.
							</div>
							
							<div class="row">
								<img src="<?php echo $configAssetsUrL; ?>/images/coiffure.png">
								<div class="title">Les coiffures vous seront gratuites</div>
								<p>Hair Salon vous fait un geste commercial et vous offre toutes les coiffures que vous souhaiterez réaliser. Vous n'aurez donc plus besoin d'acheter des bons de coiffure !</p>
								<div class="clearfix"></div>
							</div>
							
							<div class="row">
								<img src="<?php echo $configAssetsUrL; ?>/images/credits_shop.png">
								<div class="title">5% de taxe sur votre salaire</div>
								<p>L'Etat reconnait l'aide fournit et par ce fait vous taxera de 5% sur votre salaire au lieu de 15% auparavant.</p>
								<div class="clearfix"></div>
							</div>
							
							<div class="row">
								<img src="<?php echo $configAssetsUrL; ?>/images/hoverboard.png">
								<div class="title">Deux nouveaux hoverboards!</div>
								<p>Deux nouveaux hoverboards vous seront offerts, un noir et un rose. Vous pourrez avoir la classe et rouler partout avec ces derniers !</p>
								<div class="clearfix"></div>
							</div>
							
							<?php if($confirmed) { ?>
							<input type="submit" class="btn_pink" value="Vous êtes civil confirmé jusqu'au <?php echo date("d/m/Y", strtotime($confirmedInfo[0]["expire"])); ?>" disabled></input>
							<?php } else { ?>
							<input type="submit" id="getCivilConfirmed" class="btn_pink" value="Devenir civil confirmé pendant 1 mois pour 100 jetons"></input>
							<?php } ?>
						</div>
						
						<div class="column30 right">
							<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/jetons.png"> Mes jetons</div></h1>
							<div class="jetons">Vous disposez de <?php echo $userInfo[0]["jetons"]; ?> jetons.</div>
						</div>
					</div>
					
					<div class="clearfix"></div>
<?php } ?>
