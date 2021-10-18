<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
?>
					<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/travail.png"> Les travaux disponibles</div></h1>
					<div class="travaux" style="column-count: 1 !important;">
						<?php
						$jobList = $db->executeQuery('SELECT * FROM groups WHERE id = 18');
						foreach ($jobList as $jobListRow) {
						?>
						<div class="row" id="<?php echo $jobListRow["id"]; ?>" style="width: 780px;">
							<img src="<?php echo $configSwfUrL; ?>/habbo-imaging/badges/<?php echo $jobListRow["badge"]; ?>.gif" class="badge">
							<h1><?php echo utf8_decode($jobListRow["name"]); ?></h1>
							<p><?php echo utf8_decode($jobListRow["desc"]); ?></p>
							<div class="clearfix"></div>
							<div class="gouv_desc">
								Chiffre des caisses de l'état
							</div>
							<div class="chiffre gouv">
								<img src="<?php echo $configAssetsUrL; ?>/images/menu/shop.png"> 
								<?php echo $jobListRow["chiffre"]; ?>
								<div class="clearfix"></div>
							</div>
						</div>
						<?php
						}
						?>
					</div>
					
					<div class="travaux">
						<?php
						$jobList = $db->executeQuery('SELECT * FROM groups WHERE id != 1 AND id != 18');
						foreach ($jobList as $jobListRow) {
						?>
						<div class="row" id="<?php echo $jobListRow["id"]; ?>">
							<img src="<?php echo $configSwfUrL; ?>/habbo-imaging/badges/<?php echo $jobListRow["badge"]; ?>.gif" class="badge">
							<h1><?php echo utf8_decode($jobListRow["name"]); ?></h1>
							<p><?php echo utf8_decode($jobListRow["desc"]); ?></p>
							<div class="chiffre">
								<img src="<?php echo $configAssetsUrL; ?>/images/menu/shop.png"> 
								<?php if($jobListRow["payedByGouv"] == 1) { echo "Travaille pour l'état"; } else { echo $jobListRow["chiffre"]; } ?>
								<div class="clearfix"></div>
							</div>
						</div>
						<?php
						}
						?>
					</div>
					<div class="clearfix"></div>
<?php
}
