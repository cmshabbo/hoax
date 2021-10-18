<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
?>
					<div class="column50 left">
						<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/credits.gif"> Les plus riches</div></h1>
						
						<div class="leaderboard">
							<?php
							$leaderboardCredits = $db->executeQuery('SELECT *, (credits + banque) AS richesse FROM users WHERE rank = 1 ORDER BY richesse DESC LIMIT 3');
							$i = 0;
							foreach ($leaderboardCredits as $leaderboardCreditsRow) {
								$i = $i+1;
								if($i == 1)
								{
									$className = "one";
								}
								elseif($i == 2)
								{
									$className = "two";
								}
								else if($i == 3)
								{
									$className = "three";
								}								
							?>
							<div class="<?php echo $className; ?>">
								<div class="avatar"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=avatarimage?figure=<?php echo $leaderboardCreditsRow["look"]; ?>&direction=3&head_direction=3&action=wav&gesture=sml&size=l&size=l"></div>
								<div class="description">
									<b class="username"><?php echo $i; ?>. <?php echo $leaderboardCreditsRow["username"]; ?></b>
									<div class="clearfix"></div>
									<?php echo $leaderboardCreditsRow["richesse"]; ?> crédits
								</div>
								<div class="img"><img src="<?php echo $configAssetsUrL; ?>/images/<?php echo $className; ?>.gif"></div>
							</div>
							<?php
							}
							?>
						</div>
						
						<div class="clearfix"></div>
					</div>
					
					<div class="column50 right">
						<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/sabre.png"> Les plus criminels</div></h1>
						
						<div class="leaderboard">
							<?php
							$leaderboardKill = $db->executeQuery('SELECT * FROM users ORDER BY kills DESC LIMIT 3');
							$i = 0;
							foreach ($leaderboardKill as $leaderboardKillRow) {
								$i = $i+1;
								if($i == 1)
								{
									$className = "one";
								}
								elseif($i == 2)
								{
									$className = "two";
								}
								else if($i == 3)
								{
									$className = "three";
								}								
							?>
							<div class="<?php echo $className; ?>">
								<div class="avatar"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=avatarimage?figure=<?php echo $leaderboardKillRow["look"]; ?>&direction=3&head_direction=3&action=wav&gesture=sml&size=l&size=l"></div>
								<div class="description">
									<b class="username"><?php echo $i; ?>. <?php echo $leaderboardKillRow["username"]; ?></b>
									<div class="clearfix"></div>
									<?php echo $leaderboardKillRow["kills"]; ?> kills
								</div>
								<div class="img"><img src="<?php echo $configAssetsUrL; ?>/images/<?php echo $className; ?>.gif"></div>
							</div>
							<?php
							}
							?>
						</div>
						
						<div class="clearfix"></div>
					</div>
					
					<div class="column50 left">
						<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/mort.png"> Les plus morts</div></h1>
						
						<div class="leaderboard">
							<?php
							$leaderboardMort = $db->executeQuery('SELECT * FROM users ORDER BY morts DESC LIMIT 3');
							$i = 0;
							foreach ($leaderboardMort as $leaderboardMortRow) {
								$i = $i+1;
								if($i == 1)
								{
									$className = "one";
								}
								elseif($i == 2)
								{
									$className = "two";
								}
								else if($i == 3)
								{
									$className = "three";
								}								
							?>
							<div class="<?php echo $className; ?>">
								<div class="avatar"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=avatarimage?figure=<?php echo $leaderboardMortRow["look"]; ?>&direction=3&head_direction=3&action=wav&gesture=sml&size=l&size=l"></div>
								<div class="description">
									<b class="username"><?php echo $i; ?>. <?php echo $leaderboardMortRow["username"]; ?></b>
									<div class="clearfix"></div>
									<?php echo $leaderboardMortRow["morts"]; ?> morts
								</div>
								<div class="img"><img src="<?php echo $configAssetsUrL; ?>/images/<?php echo $className; ?>.gif"></div>
							</div>
							<?php
							}
							?>
						</div>
						
						<div class="clearfix"></div>
					</div>
					
					<div class="column50 right">
						<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/menotte.png"> Les plus emprisonnés</div></h1>
						
						<div class="leaderboard">
							<?php
							$leaderboardPrison = $db->executeQuery('SELECT * FROM users ORDER BY prison_count DESC LIMIT 3');
							$i = 0;
							foreach ($leaderboardPrison as $leaderboardPrisonRow) {
								$i = $i+1;
								if($i == 1)
								{
									$className = "one";
								}
								elseif($i == 2)
								{
									$className = "two";
								}
								else if($i == 3)
								{
									$className = "three";
								}								
							?>
							<div class="<?php echo $className; ?>">
								<div class="avatar"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=avatarimage?figure=<?php echo $leaderboardPrisonRow["look"]; ?>&direction=3&head_direction=3&action=wav&gesture=sml&size=l&size=l"></div>
								<div class="description">
									<b class="username"><?php echo $i; ?>. <?php echo $leaderboardPrisonRow["username"]; ?></b>
									<div class="clearfix"></div>
									<?php echo $leaderboardPrisonRow["prison_count"]; ?> fois
								</div>
								<div class="img"><img src="<?php echo $configAssetsUrL; ?>/images/<?php echo $className; ?>.gif"></div>
							</div>
							<?php
							}
							?>
						</div>
						
						<div class="clearfix"></div>
					</div>
					
					<div class="column50 left">
						<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/travail.png"> Ayant le plus de créations</div></h1>
						
						<div class="leaderboard">
							<?php
							$leaderboardCreation = $db->executeQuery('SELECT * FROM users ORDER BY creations DESC LIMIT 3');
							$i = 0;
							foreach ($leaderboardCreation as $leaderboardCreationRow) {
								$i = $i+1;
								if($i == 1)
								{
									$className = "one";
								}
								elseif($i == 2)
								{
									$className = "two";
								}
								else if($i == 3)
								{
									$className = "three";
								}								
							?>
							<div class="<?php echo $className; ?>">
								<div class="avatar"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=avatarimage?figure=<?php echo $leaderboardCreationRow["look"]; ?>&direction=3&head_direction=3&action=wav&gesture=sml&size=l&size=l"></div>
								<div class="description">
									<b class="username"><?php echo $i; ?>. <?php echo $leaderboardCreationRow["username"]; ?></b>
									<div class="clearfix"></div>
									<?php echo $leaderboardCreationRow["creations"]; ?> créations
								</div>
								<div class="img"><img src="<?php echo $configAssetsUrL; ?>/images/<?php echo $className; ?>.gif"></div>
							</div>
							<?php
							}
							?>
						</div>
						
						<div class="clearfix"></div>
					</div>
					
					<div class="clearfix"></div>
<?php } ?>
