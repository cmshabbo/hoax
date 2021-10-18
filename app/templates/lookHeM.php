<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	$itemsUser = $db->executeQuery('SELECT * FROM looks WHERE gender = "u" OR gender = ? AND invente = ?', array($userInfo[0]["gender"], "1"));
	if(isset($_GET["look"]) && $_GET["look"] == "base") {
?>
			<div class="closeButton"><i class="fas fa-times"></i></div>
			
			<div class="resize animated fadeInDown">
				<h1><img src="<?php echo $configAssetsUrL; ?>/images/look.gif"> Look disponibles</h1>
				<div class="look">
					<div class="row bonnet active" id="ha"></div>
					<div class="row moustache inactive" id="fa"></div>
					<div class="row lunette inactive" id="ea"></div>
					<div class="row teeshirt inactive" id="ch"></div>
					<div class="row echarpe inactive" id="ca"></div>
					<div class="row ceinture inactive" id="wa"></div>
					<div class="row pantalon inactive" id="lg"></div>
					<div class="row chaussure inactive" id="sh"></div>
					<div class="clearfix"></div>
				</div>
				
				<div class="changeLookName">
					<h2>Les bonnets</h2>
					<div class="overflow" id="itemHem">
						<ul>
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								if($itemsUserRow["type"] != "ha" || $itemsUserRow["invente"] == "0")
								{
									continue;
								}
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=ha-<?php echo $itemsUserRow["code"]; ?>-73&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"><div class="price"><?php echo $itemsUserRow["price"]; ?></div></li>
							<?php } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Les couleurs</h2>
						<div class="overflow">
							<ul id="colorListHem">
							</ul>
						</div>
					</div>
				</div>
			</div>
<?php
	}
	elseif(isset($_GET["look"]) && $_GET["look"] == "bonnet") {
?>
					<h2>Les bonnets</h2>
					<div class="overflow" id="itemHem">
						<ul>
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								if($itemsUserRow["type"] != "ha" || $itemsUserRow["invente"] == "0")
								{
									continue;
								}
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=ha-<?php echo $itemsUserRow["code"]; ?>-73&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"><div class="price"><?php echo $itemsUserRow["price"]; ?></div></li>
							<?php } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Les couleurs </h2>
						<div class="overflow">
							<ul id="colorListHem">
							</ul>
						</div>
					</div>
					
<?php
	}
	elseif(isset($_GET["look"]) && $_GET["look"] == "lunettes") {
?>
					<h2>Les lunettes</h2>
					<div class="overflow" id="itemHem">
						<ul>
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								if($itemsUserRow["type"] != "ea" || $itemsUserRow["invente"] == "0")
								{
									continue;
								}
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=fa-<?php echo $itemsUserRow["code"]; ?>-&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -30px"><div class="price"><?php echo $itemsUserRow["price"]; ?></div></li>
							<?php } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Les couleurs </h2>
						<div class="overflow">
							<ul id="colorListHem">
							</ul>
						</div>
					</div>
<?php
	}
	elseif(isset($_GET["look"]) && $_GET["look"] == "teeshirt") {
?>
					<h2>Les tee shirts</h2>
					<div class="overflow" id="itemHem">
						<ul>
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								if($itemsUserRow["type"] != "ch" || $itemsUserRow["invente"] == "0")
								{
									continue;
								}
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=ch-<?php echo $itemsUserRow["code"]; ?>-82&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -40px"><div class="price"><?php echo $itemsUserRow["price"]; ?></div></li>
							<?php } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Les couleurs </h2>
						<div class="overflow">
							<ul id="colorListHem">
							</ul>
						</div>
					</div>
<?php
	}
	elseif(isset($_GET["look"]) && $_GET["look"] == "pantalon") {
?>
					<h2>Les pantalons</h2>
					<div class="overflow" id="itemHem">
						<ul>
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								if($itemsUserRow["type"] != "lg" || $itemsUserRow["invente"] == "0")
								{
									continue;
								}
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=ch-<?php echo $itemsUserRow["code"]; ?>-82&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -60px"><div class="price"><?php echo $itemsUserRow["price"]; ?></div></li>
							<?php } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Les couleurs </h2>
						<div class="overflow">
							<ul id="colorListHem">
							</ul>
						</div>
					</div>
<?php
	}
	elseif(isset($_GET["look"]) && $_GET["look"] == "chaussure") {
?>
					<h2>Les chaussures</h2>
					<div class="overflow" id="itemHem">
						<ul>
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								if($itemsUserRow["type"] != "sh" || $itemsUserRow["invente"] == "0")
								{
									continue;
								}
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=ch-<?php echo $itemsUserRow["code"]; ?>-73&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -80px"><div class="price"><?php echo $itemsUserRow["price"]; ?></div></li>
							<?php } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Les couleurs </h2>
						<div class="overflow">
							<ul id="colorListHem">
							</ul>
						</div>
					</div>
<?php
	}
	elseif(isset($_GET["look"]) && $_GET["look"] == "accessoire") {
?>
					<h2>Les accessoires</h2>
					<div class="overflow" id="itemHem">
						<ul>
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								if($itemsUserRow["type"] != "fa" || $itemsUserRow["invente"] == "0")
								{
									continue;
								}
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=ch-<?php echo $itemsUserRow["code"]; ?>-82&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"><div class="price"><?php echo $itemsUserRow["price"]; ?></div></li>
							<?php } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Les couleurs </h2>
						<div class="overflow">
							<ul id="colorListHem">
							</ul>
						</div>
					</div>
<?php
	}
	elseif(isset($_GET["look"]) && $_GET["look"] == "echarpe") {
?>
					<h2>Les écharpes</h2>
					<div class="overflow" id="itemHem">
						<ul>
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								if($itemsUserRow["type"] != "ca" || $itemsUserRow["invente"] == "0")
								{
									continue;
								}
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=ch-<?php echo $itemsUserRow["code"]; ?>-73&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -25px"><div class="price"><?php echo $itemsUserRow["price"]; ?></div></li>
							<?php } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Les couleurs </h2>
						<div class="overflow">
							<ul id="colorListHem">
							</ul>
						</div>
					</div>
<?php
	}
	elseif(isset($_GET["look"]) && $_GET["look"] == "ceinture") {
?>
					<h2>Les ceintures</h2>
					<div class="overflow" id="itemHem">
						<ul>
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								if($itemsUserRow["type"] != "wa" || $itemsUserRow["invente"] == "0")
								{
									continue;
								}
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=ch-<?php echo $itemsUserRow["code"]; ?>-82&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -60px"><div class="price"><?php echo $itemsUserRow["price"]; ?></div></li>
							<?php } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Les couleurs </h2>
						<div class="overflow">
							<ul id="colorListHem">
							</ul>
						</div>
					</div>
<?php
	}
}
?>