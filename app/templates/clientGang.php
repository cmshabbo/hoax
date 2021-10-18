<?php 
include("../../includes/config.php");
include("../../includes/functions.php");
include("global_without_message.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	if($userInfo[0]["gang"] == 0)
	{
		return;
	}
	
	$gangInfo = $db->executeQuery('SELECT * FROM gang WHERE id=?', array($userInfo[0]["gang"]));
	$countCapture = $db->executeQuery('SELECT COUNT(*) AS count_row FROM rooms WHERE capture=?', array($userInfo[0]["gang"]));
	if($gangInfo[0]["dead"] == 0)
	{
		$ratio = number_format($gangInfo[0]["kills"], 2, '.', '');
	}
	else
	{
		$ratio = number_format($gangInfo[0]["kills"]/$gangInfo[0]["dead"], 2, '.', '');
	}
	
	$gangLvl = getGangLevel($gangInfo[0]["xp"]);
?>
						<div class="stats">
							<h3>Statistiques</h3>
							<hr>
							<div class="row">
								<div class="img"><img src="<?php echo $configAssetsUrL; ?>/images/kill.png"></div>
								<div class="desc"><?php echo $gangInfo[0]["kills"]; ?></div>
								<div class="clearfix"></div>
							</div>
							
							<div class="row">
								<div class="img"><img src="<?php echo $configAssetsUrL; ?>/images/dead.png"></div>
								<div class="desc"><?php echo $gangInfo[0]["dead"]; ?></div>
								<div class="clearfix"></div>
							</div>
							
							<div class="row">
								<div class="img"><img src="<?php echo $configAssetsUrL; ?>/images/ratio.png"></div>
								<div class="desc"><?php echo $ratio; ?></div>
								<div class="clearfix"></div>
							</div>
							
							<div class="row">
								<div class="img"><img src="<?php echo $configAssetsUrL; ?>/images/points.png"></div>
								<div class="desc"><?php echo $countCapture[0]["count_row"]; ?></div>
								<div class="clearfix"></div>
							</div>
						
							<div class="clearfix"></div>
							<?php if($userInfo[0]["gang_rank"] > 1) { ?>
							<h3>Inviter un civil</h3>
							<hr>
							<input type="text" id="invitGangUsername" placeholder="Pseudonyme"></input>
							<input type="submit" id="invitGangButton" value="&#xf14d;"></input>
							<?php } ?>
						</div>
						
						<div class="gang_content">
							<h3>Niveau du gang</h3>
							<hr>
							<div class="progress_bar">
								<div class="level"><?php echo $gangLvl['lvl']; ?></div>
								<div class="progress_xp"><?php echo $gangInfo[0]["xp"]; ?>/<?php echo $gangLvl['xpNxtLvl']; ?></div>
								<div class="next_level"><?php echo $gangLvl['nextLvl']; ?></div>
								<div class="clearfix"></div>
							</div>
							
							<div class="clearfix"></div>
							<h3>Chefs</h3>
							<hr>
							<?php
							$usersChef = $db->executeQuery('SELECT * FROM users WHERE gang = ? AND gang_rank = ?', array($gangInfo[0]["id"], "4"));
							foreach ($usersChef as $usersChefRow) {
							?>
							<div class="row_avatar">
								<div class="avatar">
									<img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $usersChefRow["look"]; ?>&head_direction=3&gesture=sml">
								</div>
								
								<div class="nickname">
									<div class="etat <?php if($usersChefRow["online"] == 1) { echo "online"; } else { echo "offline"; } ?>"></div>
									<?php echo $usersChefRow["username"]; ?>
								</div>
								
								<?php if($userInfo[0]["id"] == $gangInfo[0]["owner"] && $userInfo[0]["id"] != $usersChefRow["id"]) { ?>
								<div class="action">
									<i class="fas fa-crown give_owner" id="<?php echo $usersChefRow["username"]; ?>"></i>
									<i class="fas fa-arrow-alt-circle-down down_rank" id="<?php echo $usersChefRow["username"]; ?>"></i>
									<i class="fas fa-times-circle virer_user" id="<?php echo $usersChefRow["username"]; ?>"></i>
								</div>
								<?php } ?>
							</div>
							<?php
							}
							?>
							
							<div class="clearfix"></div>
							<h3>Sous-chefs</h3>
							<hr>
							<?php
							$usersSousChef = $db->executeQuery('SELECT * FROM users WHERE gang = ? AND gang_rank = ?', array($gangInfo[0]["id"], "3"));
							foreach ($usersSousChef as $usersSousChefRank) {
							?>
							<div class="row_avatar">
								<div class="avatar">
									<img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $usersSousChefRank["look"]; ?>&head_direction=3&gesture=sml">
								</div>
								
								<div class="nickname">
									<div class="etat <?php if($usersSousChefRank["online"] == 1) { echo "online"; } else { echo "offline"; } ?>"></div>
									<?php echo $usersSousChefRank["username"]; ?>
								</div>
								
								<?php if($userInfo[0]["gang_rank"] == 4 && $userInfo[0]["id"] != $usersSousChefRank["id"]) { ?>
								<div class="action">
									<i class="fas fa-arrow-alt-circle-up up_rank" id="<?php echo $usersSousChefRank["username"]; ?>"></i>
									<i class="fas fa-arrow-alt-circle-down down_rank" id="<?php echo $usersSousChefRank["username"]; ?>"></i>
									<i class="fas fa-times-circle virer_user" id="<?php echo $usersSousChefRank["username"]; ?>"></i>
								</div>
								<?php } ?>
							</div>
							<?php
							}
							?>
							
							<div class="clearfix"></div>
							<h3>Membres</h3>
							<hr>
							<?php
							$usersMembres = $db->executeQuery('SELECT * FROM users WHERE gang = ? AND gang_rank = ?', array($gangInfo[0]["id"], "2"));
							foreach ($usersMembres as $usersMembresRow) {
							?>
							<div class="row_avatar">
								<div class="avatar">
									<img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $usersMembresRow["look"]; ?>&head_direction=3&gesture=sml">
								</div>
								
								<div class="nickname">
									<div class="etat <?php if($usersMembresRow["online"] == 1) { echo "online"; } else { echo "offline"; } ?>"></div>
									<?php echo $usersMembresRow["username"]; ?>
								</div>
								
								<?php if($userInfo[0]["gang_rank"] == 3 || $userInfo[0]["gang_rank"] == 4) { ?>
								<div class="action">
									<i class="fas fa-arrow-alt-circle-up up_rank" id="<?php echo $usersMembresRow["username"]; ?>"></i>
									<i class="fas fa-arrow-alt-circle-down down_rank" id="<?php echo $usersMembresRow["username"]; ?>"></i>
									<?php if($userInfo[0]["gang_rank"] == 4) { ?>
									<i class="fas fa-times-circle virer_user" id="<?php echo $usersMembresRow["username"]; ?>"></i>
									<?php } ?>
								</div>
								<?php } ?>
							</div>
							<?php
							}
							?>
							
							<div class="clearfix"></div>
							<h3>Arrivants</h3>
							<hr>
							<?php
							$usersArrivant = $db->executeQuery('SELECT * FROM users WHERE gang = ? AND gang_rank = ?', array($gangInfo[0]["id"], "1"));
							foreach ($usersArrivant as $usersArrivantRow) {
							?>
							<div class="row_avatar">
								<div class="avatar">
									<img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $usersArrivantRow["look"]; ?>&head_direction=3&gesture=sml">
								</div>
								
								<div class="nickname">
									<div class="etat <?php if($usersArrivantRow["online"] == 1) { echo "online"; } else { echo "offline"; } ?>"></div>
									<?php echo $usersArrivantRow["username"]; ?>
								</div>
								
								<?php if($userInfo[0]["gang_rank"] == 3 || $userInfo[0]["gang_rank"] == 4) { ?>
								<div class="action">
									<i class="fas fa-arrow-alt-circle-up up_rank" id="<?php echo $usersArrivantRow["username"]; ?>"></i>
									<?php if($userInfo[0]["gang_rank"] == 4) { ?>
									<i class="fas fa-times-circle virer_user" id="<?php echo $usersArrivantRow["username"]; ?>"></i>
									<?php } ?>
								</div>
								<?php } ?>
							</div>
							<?php
							}
							?>
						</div>
						<div class="clearfix"></div>
<?php } ?>
