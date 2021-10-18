<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	if(!isset($_GET["id"])) {
		return;
	}
	
	$lookInfo = $db->executeQuery('SELECT * FROM looks WHERE id=? LIMIT 1', array($_GET["id"]));
	if($lookInfo == null)
	{
		return;
	}
?>
					<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/look.gif"div> Modifier le look <?php echo $lookInfo[0]["code"]; ?></h1>
					<form action="<?php echo $configBaseUrL; ?>/home" method="POST">
						<input type="hidden" id="lookId" value="<?php echo $lookInfo[0]["id"]; ?>" disabled>
						<input type="text" id="lookPrix" value="<?php echo $lookInfo[0]["price"]; ?>" placeholder="Prix du look">
						<input type="text" id="lookTaxe" value="<?php echo $lookInfo[0]["taxe"]; ?>" placeholder="Taxe du look">
						<select id="lookEnVente">
							<option disabled>En vente</option>
							<?php if($lookInfo[0]["invente"] == 1) { ?>
							<option name="yes">Oui</option>
							<option name="no">Non</option>
							<?php } else { ?>
							<option name="no">Non</option>
							<option name="yes">Oui</option>
							<?php } ?>
						</select>
						<input type="submit" id="editLookButton" value="Modifier le look" class="btn_pink">
					</form>
					<div class="clearfix"></div>
<?php
}
