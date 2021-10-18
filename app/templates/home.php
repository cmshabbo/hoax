<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
?>
					<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/credits.gif"> Tirage EuroRP</div></h1>
					<div class="tirage">
						<div class="infos">
							<?php
							$euroRP = $db->executeQuery('SELECT * FROM eurorp');
							$euroRP_participants = $db->executeQuery('SELECT COUNT(*) AS count_row FROM eurorp_participants');
							$euroRP_LastWinner = $db->executeQuery('SELECT * FROM users WHERE id=?', array($euroRP[0]["last_winner"]));
							$euroRpLot = ($euroRP[0]["montant"] * 75)/100;
							
							?>
							<img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $euroRP_LastWinner[0]["look"]; ?>&head_direction=2&gesture=sml&action=wav&size=l" class="avatar">
							
							<div class="row_white last_winner">Dernier gagnant : <b><?php echo $euroRP_LastWinner[0]["username"]; ?></b></div>
							<div class="row_white lot">Participants : <b><?php echo $euroRP_participants[0]["count_row"]; ?></b></div>
							
							<div class="win_lot"><?php echo round($euroRpLot); ?> crédits à gagner</div>
						</div>
						
						
						<div class="eurorp">
							<div class="row" id="day">
								<div class="time">?</div>
								<div class="name">jours</div>
							</div>
							
							<div class="row" id="hours">
								<div class="time">?</div>
								<div class="name">heures</div>
							</div>
							
							<div class="row" id="minutes">
								<div class="time">?</div>
								<div class="name">minutes</div>
							</div>
							
							<div class="row" id="seconds">
								<div class="time">?</div>
								<div class="name">secondes</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					
					<div class="column60 left">
						<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/wanted.png"> Quelques civils recherchés</div></h1>
						<div class="wanted">
						<?php
						$userWanted = $db->executeQuery('SELECT * FROM users_wanted ORDER BY RAND() LIMIT 6');
						$count = 0;
						foreach ($userWanted as $userWantedRow) {
							$count++;
							if($count == 1) {
								$rotate = "5deg";
							}
							elseif($count == 2) {
								$rotate = "-5deg";
							}
							elseif($count == 3) {
								$rotate = "10deg";
							}
							elseif($count == 4) {
								$rotate = "0deg";
							}
							elseif($count == 5) {
								$rotate = "15deg";
							}
							elseif($count == 6) {
								$rotate = "-5deg";
							}
							$userWantedInfo = $db->executeQuery('SELECT * FROM users WHERE id = ? LIMIT 1', array($userWantedRow["user_id"]));
						?>
							<div class="row" style="transform: rotate(<?php echo $rotate; ?>);">
								<div class="avatar"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userWantedInfo[0]["look"]; ?>&head_direction=3&gesture=sml&action=wav"></div>
								<div class="username"><?php echo $userWantedInfo[0]["username"]; ?></div>
							</div>
						<?php } ?>
							<div class="clearfix"></div>
						</div>
						
						<div class="clearfix"></div>
					</div>
					
					<div class="column40 right">
						<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/discord.png"> Notre Discord</div></h1>
						<iframe src="https://discordapp.com/widget?id=465588551791280129&theme=dark" width="320" height="350" allowtransparency="true" frameborder="0" class="shadow"></iframe>
					</div>
					
					<div class="clearfix"></div>
<?php
}
