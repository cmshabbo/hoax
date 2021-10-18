<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
?>
					<div class="gang">
						<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/wanted.png"> Chercher un gang</div></h1>
						<div class="search">
							<input type="text" id="searchNameGang" placeholder="Nom du gang"></input> <input type="submit" id="searchGangButton" class="btn_pink" value="Chercher"></input>
						</div>
						
						<div class="column50 left">
							<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/sabre.png"> Les plus criminels</div></h1>
							<div class="gang_leaderboard">
								<?php
								$leaderboardKillGang = $db->executeQuery('SELECT * FROM gang ORDER BY kills DESC LIMIT 5');
								$i = 0;
								foreach ($leaderboardKillGang as $leaderboardKillGangRow) {
									$i = $i+1;
								?>
								<div class="row">
									<div class="place"><?php echo $i; ?></div>
									<div class="value"><?php echo $leaderboardKillGangRow["kills"]; ?> kills</div>
									<div class="members">
										<?php
										$userGang = $db->executeQuery('SELECT * FROM users WHERE gang = ? ORDER BY RAND() LIMIT 4', array($leaderboardKillGangRow["id"]));
										foreach ($userGang as $userGangRow) {
										?>
										<div class="member_row">
											<img src="http://habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userGangRow["look"]; ?>&action=wav&head_direction=3&direction=3&gesture=sml">
										</div>
										<?php
										} 
										?>
									</div>
									<div class="desc"><?php echo $leaderboardKillGangRow["name"]; ?></div>
									<div class="clearfix"></div>
								</div>
								<?php
								}
								?>
							</div>
							<div class="clearfix"></div>
						</div>
						
						<div class="column50 right">
							<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/dead.png"> Les plus morts</div></h1>
							<div class="gang_leaderboard">
								<?php
								$leaderboardDeadGang = $db->executeQuery('SELECT * FROM gang ORDER BY dead DESC LIMIT 5');
								$i = 0;
								foreach ($leaderboardDeadGang as $leaderboardDeadGangRow) {
									$i = $i+1;
								?>
								<div class="row">
									<div class="place"><?php echo $i; ?></div>
									<div class="value"><?php echo $leaderboardDeadGangRow["dead"]; ?> morts</div>
									<div class="members">
										<?php
										$userGang = $db->executeQuery('SELECT * FROM users WHERE gang = ? ORDER BY RAND() LIMIT 4', array($leaderboardDeadGangRow["id"]));
										foreach ($userGang as $userGangRow) {
										?>
										<div class="member_row">
											<img src="http://habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userGangRow["look"]; ?>&action=wav&head_direction=3&direction=3&gesture=sml">
										</div>
										<?php
										} 
										?>
									</div>
									<div class="desc"><?php echo $leaderboardDeadGangRow["name"]; ?></div>
									<div class="clearfix"></div>
								</div>
								<?php
								}
								?>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="clearfix"></div>
<?php
}
