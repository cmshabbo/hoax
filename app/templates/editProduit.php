<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	if(!isset($_GET["id"])) {
		return;
	}
	
	$produitInfo = $db->executeQuery('SELECT * FROM items_list WHERE id=? LIMIT 1', array($_GET["id"]));
	if($produitInfo == null)
	{
		return;
	}
?>
					<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/travail.png"div> Modifier le produit <?php echo $produitInfo[0]["name"]; ?></h1>
					<form action="<?php echo $configBaseUrL; ?>/home" method="POST">
						<input type="hidden" id="produitId" value="<?php echo $produitInfo[0]["id"]; ?>" disabled>
						<input type="text" id="produitPrix" value="<?php echo $produitInfo[0]["prix"]; ?>" placeholder="Prix du produit">
						<input type="text" id="produitTaxe" value="<?php echo $produitInfo[0]["taxe"]; ?>" placeholder="Taxe du produit">
						<input type="submit" id="editProduitButton" value="Modifier le produit" class="btn_pink">
					</form>
					<div class="clearfix"></div>
<?php
}
