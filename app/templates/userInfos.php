<?php 
include("../../includes/config.php");
require_once('../class/database.php');
$db = new Database();

if(isset($_GET["id"]) && is_numeric($_GET["id"])) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_GET["id"]));
	if($userInfo == null)
		return;
?>
				<div class="avatar">
					<img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userInfo[0]["look"]; ?>&head_direction=2&gesture=sml&size=l&size=l" id="avatarAnimed">
					
					<div class="barProgress">
						<div class="barLvl green" style="width: <?php echo $userInfo[0]["sante"]; ?>%"></div>
						<div class="title">Santé : <?php echo $userInfo[0]["sante"]; ?>/100</div>
					</div>
					
					<div class="barProgress">
						<div class="barLvl purple" style="width: <?php echo $userInfo[0]["sommeil"]; ?>%"></div>
						<div class="title">Fatigue : <?php echo $userInfo[0]["sommeil"]; ?>/100</div>
					</div>
					
					<div class="barProgress">
						<div class="barLvl orange" style="width: <?php echo $userInfo[0]["energie"]; ?>%"></div>
						<div class="title">Énergie : <?php echo $userInfo[0]["energie"]; ?>/100</div>
					</div>
					
					<div class="barProgress">
						<div class="barLvl blue" style="width: <?php echo $userInfo[0]["hygiene"]; ?>%"></div>
						<div class="title">Hygiène : <?php echo $userInfo[0]["hygiene"]; ?>/100</div>
					</div>
					
					<div class="clearfix"></div>
				</div>
				
				<h1><span>Mon travail</span></h1>
				<div class="travail">
					<?php
					$travailUserInfo = $db->executeQuery('SELECT * FROM group_memberships WHERE user_id=? LIMIT 1', array($userInfo[0]["id"]));
					$travailInfo = $db->executeQuery('SELECT * FROM groups WHERE id=?', array($travailUserInfo[0]["group_id"]));
					if($travailUserInfo[0]["group_id"] != 1)
					{
						$rankInfo = $db->executeQuery('SELECT * FROM groups_rank WHERE rank_id = ? AND job_id = ?', array($travailUserInfo[0]["rank_id"], $travailUserInfo[0]["group_id"]));
					}
					?>
					<img src="<?php echo $configSwfUrL; ?>/habbo-imaging/badges/<?php echo $travailInfo[0]["badge"]; ?>.gif">
					<span><?php echo  utf8_decode($travailInfo[0]["name"]); ?></span><br />
					<?php if($travailUserInfo[0]["group_id"] != 1) { echo $rankInfo[0]["name"]; } else { echo "Vous n'avez pas d'emploi"; } ?>
					<div class="clearfix"></div>
				</div>
				
				<?php if($userInfo[0]["carte"] || $userInfo[0]["permis_arme"]) { ?>
				<h1><span>Mes documents</span></h1>
				<div class="list">
					<?php if($userInfo[0]["carte"]) { ?>
					<div class="item cyan">
						<img src="<?php echo $configAssetsUrL; ?>/images/carte.gif">
						<div class="number notDisplay">Carte d'identité</div>
					</div>
					<?php } ?>
					
					<?php if($userInfo[0]["permis_arme"]) { ?>
					<div class="item cyan">
						<img src="<?php echo $configAssetsUrL; ?>/images/portarme.png">
						<div class="number notDisplay">Permis port d'armes</div>
					</div>
					<?php } ?>
					
					<div class="clearfix"></div>
				</div>
				<?php } ?>
				
				<h1><span>Mes véhicules</span></h1>
				<div class="list">
					<?php if($travailUserInfo[0]["group_id"] == 4 && $travailUserInfo[0]["rank_id"] > 1) { ?>
					<div class="item red" id="police">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/police.png">
					</div>
					<?php } if($userInfo[0]["white_hover"]) { ?>
					<div class="item red" id="whiteHoverboard">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/whitehover.png">
					</div>
					<?php } if($userInfo[0]["confirmed"] == 1) { ?>
					<div class="item red" id="blackHoverboard">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/blackhover.png">
					</div>
					
					<div class="item red" id="pinkHoverboard">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/pinkhover.png">
					</div>
					<?php } if($travailUserInfo[0]["group_id"] == 18 && $travailUserInfo[0]["rank_id"] > 1) { ?>
					<div class="item red" id="gouvernement">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/gouvernement.png">
					</div>
					<?php } if($userInfo[0]["porsche911"]) { ?>
					<div class="item red" id="porsche911">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/porsche911.png">
					</div>
					<?php } if($userInfo[0]["fiatpunto"]) { ?>
					<div class="item red" id="fiatpunto">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/fiatpunto.png">
					</div>
					<?php } if($userInfo[0]["volkswagenjetta"]) { ?>
					<div class="item red" id="volkswagenjetta">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/volkswagenjetta.png">
					</div>
					<?php } if($userInfo[0]["bmwi8"]) { ?>
					<div class="item red" id="bmwi8">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/bmwi8.png">
					</div>
					<?php } if($userInfo[0]["audia8"]) { ?>
					<div class="item red" id="audia8">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/audia8.png">
					</div>
					<?php } if($userInfo[0]["audia3"]) { ?>
					<div class="item red" id="audia3">
						<img src="<?php echo $configAssetsUrL; ?>/images/vehicules/audia3.png">
					</div>
					<?php } ?>
					
					<div class="clearfix"></div>
				</div>
				
				<?php if($userInfo[0]["batte"] != 0 || $userInfo[0]["sabre"] != 0 || $userInfo[0]["ak47"] != 0 || $userInfo[0]["uzi"] != 0 || $userInfo[0]["cocktails"] > 0 || $travailUserInfo[0]["group_id"] == 4 && $travailUserInfo[0]["rank_id"] > 1) { ?>
				<h1><span>Mes armes</span></h1>
				<div class="list">
					<?php if($travailUserInfo[0]["group_id"] == 4) { ?>
					<div class="item purple" id="taser">
						<img src="<?php echo $configAssetsUrL; ?>/images/armes/taser.png">
					</div>
					<?php } if($userInfo[0]["batte"] != 0) { ?>
					<div class="item purple" id="batte">
						<img src="<?php echo $configAssetsUrL; ?>/images/armes/batte.png">
					</div>
					<?php } if($userInfo[0]["sabre"] != 0) { ?>
					<div class="item purple" id="sabre">
						<img src="<?php echo $configAssetsUrL; ?>/images/armes/sabre.png">
					</div>
					<?php } if($userInfo[0]["ak47"] != 0) { ?>
					<div class="item purple" id="ak47">
						<img src="<?php echo $configAssetsUrL; ?>/images/armes/ak47.png">
						<div class="number"><?php echo $userInfo[0]["ak47_munitions"]; ?></div>
					</div>
					<?php } if($userInfo[0]["uzi"] != 0) { ?>
					<div class="item purple" id="uzi">
						<img src="<?php echo $configAssetsUrL; ?>/images/armes/uzi.png">
						<div class="number"><?php echo $userInfo[0]["uzi_munitions"]; ?></div>
					</div>
					<?php } if($userInfo[0]["cocktails"] != 0) { ?>
					<div class="item purple" id="cocktail">
						<img src="<?php echo $configAssetsUrL; ?>/images/armes/cocktail.png">
						<div class="number"><?php echo $userInfo[0]["cocktails"]; ?></div>
					</div>
					<?php } ?>
					
					<div class="clearfix"></div>
				</div>
				<?php } ?>
				
				<h1><span>Mes utilitaires</span></h1>
				<div class="list">
					<div class="item blue">
						<img src="<?php echo $configAssetsUrL; ?>/images/sac.png">
						<?php if($userInfo[0]["sac"] == "1") { ?>
						<div class="number notDisplay">Eastpack</div>
						<?php } elseif($userInfo[0]["sac"] == "2") { ?>
						<div class="number notDisplay">The North Face</div>
						<?php } elseif($userInfo[0]["sac"] == "3") { ?>
						<div class="number notDisplay">Louis Vuitton</div>
						<?php } elseif($userInfo[0]["sac"] == "4") { ?>
						<div class="number notDisplay">Militaire</div>
						<?php } ?>
					</div>
					
					<?php if($userInfo[0]["telephone"]) { ?>
					<div class="item blue">
						<img src="<?php echo $configAssetsUrL; ?>/images/telephone.png">
						<div class="number notDisplay"><?php echo $userInfo[0]["telephone_name"]; ?></div>
					</div>
					<?php } ?>
					<?php if($userInfo[0]["gps"]) { ?>
					<div class="item blue">
						<img src="<?php echo $configAssetsUrL; ?>/images/gps.png">
						<div class="number notDisplay">GPS</div>
					</div>
					<?php } ?>
					<div class="item blue" id="eau">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/eau.png">
						<div class="number"><?php echo $userInfo[0]["eau"]; ?>L</div>
					</div>
					<div class="item blue" id="coca">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/coca.png">
						<div class="number"><?php echo $userInfo[0]["coca"]; ?></div>
					</div>
					<div class="item blue" id="fanta">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/fanta.png">
						<div class="number"><?php echo $userInfo[0]["fanta"]; ?></div>
					</div>
					<div class="item blue" id="pain">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/pain.png">
						<div class="number"><?php echo $userInfo[0]["pain"]; ?></div>
					</div>
					<div class="item blue" id="sucette">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/sucette.png">
						<div class="number"><?php echo $userInfo[0]["sucette"]; ?></div>
					</div>
					<div class="item blue" id="savon">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/savon.png">
						<div class="number"><?php echo $userInfo[0]["savon"]; ?></div>
					</div>
					<div class="item blue" id="doliprane">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/doliprane.png">
						<div class="number"><?php echo $userInfo[0]["doliprane"]; ?></div>
					</div>
					<div class="item blue" id="weed">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/cannabis_color.png">
						<div class="number"><?php echo $userInfo[0]["weed"]; ?>g</div>
					</div>
					<div class="item blue" id="cigarette">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/cigarette.png">
						<div class="number"><?php if($userInfo[0]["philipmo"] > 0 && round($userInfo[0]["philipmo"]/20) == 0) { echo "1"; } elseif($userInfo[0]["philipmo"] > 0) {  echo round($userInfo[0]["philipmo"]/20); } else { echo "0"; } ?></div>
					</div>
					<div class="item blue" id="clipper">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/clipper.png">
						<div class="number"><?php if($userInfo[0]["clipper"] > 0 && round($userInfo[0]["clipper"]/50) == 0) { echo "1"; } elseif($userInfo[0]["clipper"] > 0) {  echo round($userInfo[0]["clipper"]/50); } else { echo "0"; } ?></div>
					</div>
					<div class="item blue" id="jetons">
						<img src="<?php echo $configAssetsUrL; ?>/images/consommables/jetons.png">
						<div class="number"><?php echo $userInfo[0]["casino_jetons"]; ?></div>
					</div>
					<div class="clearfix"></div>
				</div>
<?php
}