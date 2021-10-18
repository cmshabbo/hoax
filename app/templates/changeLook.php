<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	$itemsUser = $db->executeQuery('SELECT * FROM looks_users WHERE user_id = ? GROUP BY code', array($userInfo[0]["id"]));
	if(isset($_GET["look"]) && $_GET["look"] == "base") {
?>
			<div class="closeButton"><i class="fas fa-times"></i></div>
			
			<div class="resize animated fadeInDown">
				<h1><img src="<?php echo $configAssetsUrL; ?>/images/look.gif"> Changer de look</h1>
				<div class="look">
					<div class="row peau inactive" id="hd"></div>
					<div class="row bonnet active" id="ha"></div>
					<div class="row moustache inactive" id="fa"></div>
					<div class="row lunette inactive" id="ea"></div>
					<div class="row teeshirt inactive" id="ch"></div>
					<div class="row echarpe inactive" id="ca"></div>
					<div class="row ceinture inactive" id="wa"></div>
					<div class="row pantalon inactive" id="lg"></div>
					<div class="row chaussure inactive" id="sh"></div>
					<div class="clearfix"></div>
					
					<img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userInfo[0]["look"]; ?>&head_direction=2&gesture=sml&size=l&size=l">
				</div>
				
				<div class="changeLookName">
					<h2>Mes bonnets</h2>
					<div class="overflow" id="item">
						<ul>
							<li id="none"><img src="<?php echo $configAssetsUrL; ?>/images/look/none.png" class="basic"></li>
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								$bonnetUserColor = explode(";", $itemsUserRow["color"]);
								$bonnetUser = $db->executeQuery('SELECT * FROM looks WHERE code = ? AND type=?', array($itemsUserRow["code"], "ha"));
								$i = 0;
								foreach ($bonnetUser as $bonnetsUserRow) {
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=ha-<?php echo $itemsUserRow["code"]; ?>-73&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<?php } } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Mes couleurs </h2>
						<div class="overflow">
							<ul id="colorList">
							</ul>
						</div>
					</div>
				</div>
			</div>
<?php
	}
	elseif(isset($_GET["look"]) && $_GET["look"] == "bonnet") {
?>
					<h2>Mes bonnets</h2>
					<div class="overflow" id="item">
						<ul>
							<li id="none"><img src="<?php echo $configAssetsUrL; ?>/images/look/none.png" class="basic"></li>
							
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								$bonnetUserColor = explode(";", $itemsUserRow["color"]);
								$bonnetUser = $db->executeQuery('SELECT * FROM looks WHERE code = ? AND type=?', array($itemsUserRow["code"], "ha"));
								$i = 0;
								foreach ($bonnetUser as $bonnetsUserRow) {
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=ha-<?php echo $itemsUserRow["code"]; ?>-73&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<?php } } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Mes couleurs </h2>
						<div class="overflow">
							<ul id="colorList">
							</ul>
						</div>
					</div>
					
<?php
	}
	elseif(isset($_GET["look"]) && $_GET["look"] == "lunettes") {
?>
					<h2>Mes lunettes</h2>
					<div class="overflow" id="item">
						<ul>
							<li id="none"><img src="<?php echo $configAssetsUrL; ?>/images/look/none.png" class="basic"></li>
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								$bonnetUserColor = explode(";", $itemsUserRow["color"]);
								$bonnetUser = $db->executeQuery('SELECT * FROM looks WHERE code = ? AND type=?', array($itemsUserRow["code"], "ea"));
								$i = 0;
								foreach ($bonnetUser as $bonnetsUserRow) {
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=fa-<?php echo $itemsUserRow["code"]; ?>-&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -30px"></li>
							<?php } } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Mes couleurs </h2>
						<div class="overflow">
							<ul id="colorList">
							</ul>
						</div>
					</div>
<?php
	}
	elseif(isset($_GET["look"]) && $_GET["look"] == "teeshirt") {
?>
					<h2>Mes tee shirts</h2>
					<div class="overflow" id="item">
						<ul>
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								$bonnetUserColor = explode(";", $itemsUserRow["color"]);
								$bonnetUser = $db->executeQuery('SELECT * FROM looks WHERE code = ? AND type=?', array($itemsUserRow["code"], "ch"));
								$i = 0;
								foreach ($bonnetUser as $bonnetsUserRow) {
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=ch-<?php echo $itemsUserRow["code"]; ?>-82&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -40px"></li>
							<?php } } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Mes couleurs </h2>
						<div class="overflow">
							<ul id="colorList">
							</ul>
						</div>
					</div>
<?php
	}
	elseif(isset($_GET["look"]) && $_GET["look"] == "pantalon") {
?>
					<h2>Mes pantalons</h2>
					<div class="overflow" id="item">
						<ul>
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								$bonnetUserColor = explode(";", $itemsUserRow["color"]);
								$bonnetUser = $db->executeQuery('SELECT * FROM looks WHERE code = ? AND type=?', array($itemsUserRow["code"], "lg"));
								$i = 0;
								foreach ($bonnetUser as $bonnetsUserRow) {
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=ch-<?php echo $itemsUserRow["code"]; ?>-82&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -60px"></li>
							<?php } } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Mes couleurs </h2>
						<div class="overflow">
							<ul id="colorList">
							</ul>
						</div>
					</div>
<?php
	}
	elseif(isset($_GET["look"]) && $_GET["look"] == "chaussure") {
?>
					<h2>Mes chaussures</h2>
					<div class="overflow" id="item">
						<ul>
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								$bonnetUserColor = explode(";", $itemsUserRow["color"]);
								$bonnetUser = $db->executeQuery('SELECT * FROM looks WHERE code = ? AND type=?', array($itemsUserRow["code"], "sh"));
								$i = 0;
								foreach ($bonnetUser as $bonnetsUserRow) {
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=ch-<?php echo $itemsUserRow["code"]; ?>-73&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -80px"></li>
							<?php } } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Mes couleurs </h2>
						<div class="overflow">
							<ul id="colorList">
							</ul>
						</div>
					</div>
<?php
	}
	elseif(isset($_GET["look"]) && $_GET["look"] == "accessoire") {
?>
					<h2>Mes accessoires</h2>
					<div class="overflow" id="item">
						<ul>
							<li id="none"><img src="<?php echo $configAssetsUrL; ?>/images/look/none.png" class="basic"></li>
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								$AccessoireUserColor = explode(";", $itemsUserRow["color"]);
								$AccessoiresUser = $db->executeQuery('SELECT * FROM looks WHERE code = ? AND type=?', array($itemsUserRow["code"], "fa"));
								$i = 0;
								foreach ($AccessoiresUser as $AccessoiresUserRow) {
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=ch-<?php echo $itemsUserRow["code"]; ?>-82&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<?php } } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Mes couleurs </h2>
						<div class="overflow">
							<ul id="colorList">
							</ul>
						</div>
					</div>
<?php
	}
	elseif(isset($_GET["look"]) && $_GET["look"] == "echarpe") {
?>
					<h2>Mes écharpes</h2>
					<div class="overflow" id="item">
						<ul>
							<li id="none"><img src="<?php echo $configAssetsUrL; ?>/images/look/none.png" class="basic"></li>
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								$EcharpeUserColor = explode(";", $itemsUserRow["color"]);
								$EcharpeUser = $db->executeQuery('SELECT * FROM looks WHERE code = ? AND type=?', array($itemsUserRow["code"], "ca"));
								$i = 0;
								foreach ($EcharpeUser as $EcharpeUserRow) {
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=ch-<?php echo $itemsUserRow["code"]; ?>-73&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -25px"></li>
							<?php } } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Mes couleurs </h2>
						<div class="overflow">
							<ul id="colorList">
							</ul>
						</div>
					</div>
<?php
	}
	elseif(isset($_GET["look"]) && $_GET["look"] == "ceinture") {
?>
					<h2>Mes ceintures</h2>
					<div class="overflow" id="item">
						<ul>
							<li id="none"><img src="<?php echo $configAssetsUrL; ?>/images/look/none.png" class="basic"></li>
							<?php
							foreach ($itemsUser as $itemsUserRow) {
								$CeintureUserColor = explode(";", $itemsUserRow["color"]);
								$CeintureUser = $db->executeQuery('SELECT * FROM looks WHERE code = ? AND type=?', array($itemsUserRow["code"], "wa"));
								$i = 0;
								foreach ($CeintureUser as $CeintureUserRow) {
							?>
							<li id="<?php echo $itemsUserRow["code"]; ?>"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=ch-<?php echo $itemsUserRow["code"]; ?>-82&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -60px"></li>
							<?php } } ?>
						</ul>
					</div>
					
					<div class="color">
						<h2>Mes couleurs </h2>
						<div class="overflow">
							<ul id="colorList">
							</ul>
						</div>
					</div>
<?php
	}
	elseif(isset($_GET["look"]) && $_GET["look"] == "peau") {
?>
					<h2>Mon type de visage</h2>
					<div class="overflow" id="item">
						<ul>
							<?php if($userInfo[0]["gender"] == "F") { ?>
							<li id="3105"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-3105-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="3106"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-3106-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="3104"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-3104-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="3100"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-3100-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="3099"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-3099-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="3098"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-3098-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="3097"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-3097-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="3096"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-3096-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="629"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-629-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="628"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-628-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="627"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-627-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="626"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-626-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="625"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-625-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="620"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-620-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="615"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-615-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="610"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-610-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="605"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-605-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="600"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-600-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<?php } else { ?>
							<li id="180"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-180-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="185"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-185-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="190"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-190-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="195"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-195-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="200"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-200-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="205"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-205-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="206"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-206-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="207"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-207-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="208"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-208-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="209"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-209-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="3091"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-3091-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="3092"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-3092-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="3093"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-3093-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="3094"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-3094-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="3095"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-3095-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="3101"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-3101-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="3102"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-3102-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<li id="3103"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=hd-3103-2&gender=<?php echo $userInfo[0]["gender"]; ?>" style="margin-left: -10px; margin-top: -20px"></li>
							<?php } ?>
						</ul>
					</div>
<?php
	}
}
?>