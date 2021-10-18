<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
?>
					<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/travail.png"> Liste des produits</div></h1>
					<div class="produits">
						<?php
						$produitList = $db->executeQuery('SELECT * FROM items_list');
						foreach ($produitList as $produitListRow) {
						?>
						<div class="row" id="<?php echo $produitListRow["id"]; ?>">
							<div class="image"><img src="<?php echo $configAssetsUrL; ?>/images/<?php echo $produitListRow["image"]; ?>"></div>
							<div class="name"><?php echo $produitListRow["name"]; ?></div>
						</div>
						<?php } ?>
					</div>
					<div class="clearfix"></div>
<?php
}
