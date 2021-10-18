<?php 
include("../../includes/config.php");
require_once('../class/database.php');
$db = new Database();

if(isset($_GET["id"]) && is_numeric($_GET["id"]))
{
	$userProfileInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_GET["id"]));
	if($userProfileInfo == null)
		return;
	
	if($userProfileInfo[0]["morts"] == 0 && $userProfileInfo[0]["kills"] == 0)
	{
		$ratio = 1.00;
	}
	else if($userProfileInfo[0]["morts"] == 0 && $userProfileInfo[0]["kills"] > 0)
	{
		$ratio = $userProfileInfo[0]["kills"];
	}
	else
	{
		$ratio = $userProfileInfo[0]["kills"]/$userProfileInfo[0]["morts"];
	}
	
	if($userProfileInfo[0]["gang"] == 0)
	{
		$gang = "Aucun";
	}
	else {
		$gangInfos = $db->executeQuery('SELECT * FROM gang WHERE id=? LIMIT 1', array($userProfileInfo[0]["gang"]));
		$gang = $gangInfos[0]["name"];
	}
	
	$travailUserInfo = $db->executeQuery('SELECT * FROM group_memberships WHERE user_id=? LIMIT 1', array($userProfileInfo[0]["id"]));
	$travailInfo = $db->executeQuery('SELECT * FROM groups WHERE id=?', array($travailUserInfo[0]["group_id"]));
	if($travailUserInfo[0]["group_id"] != 1)
	{
		$rankInfo = $db->executeQuery('SELECT * FROM groups_rank WHERE rank_id = ? AND job_id = ?', array($travailUserInfo[0]["rank_id"], $travailUserInfo[0]["group_id"]));
	}
?>
								<div class="user_infos">
									<div class="avatar">
										<img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userProfileInfo[0]["look"]; ?>&head_direction=3&gesture=sml&size=l">
									</div>
									
									<div class="username"><?php echo $userProfileInfo[0]["username"]; ?></div>
								</div>
								
								<div class="profil_userTab">
									<input id="menu1" type="radio" name="tabs" checked>
									<label for="menu1">Général</label>

									<input id="menu2" type="radio" name="tabs">
									<label for="menu2">Criminel</label>

									<input id="menu3" type="radio" name="tabs">
									<label for="menu3">Travail</label>

									<section id="tab_general">
										<img src="<?php echo $configAssetsUrL; ?>/images/statut.gif"> Statut : <b><?php echo $userProfileInfo[0]["motto"]; ?></b>
										<div class="clearfix"></div>
										<img src="<?php echo $configAssetsUrL; ?>/images/rejoint.gif"> A rejoint la ville le : <b><?php echo date('d/m/Y', $userProfileInfo[0]["account_created"]); ?></b>
										<div class="clearfix"></div>
										<img src="<?php echo $configAssetsUrL; ?>/images/gang.gif"> Gang : <b><?php echo $gang; ?></b>
										<div class="clearfix"></div>
									</section>

									<section id="tab_criminel">
										<img src="<?php echo $configAssetsUrL; ?>/images/mort.png"> Morts : <b><?php echo $userProfileInfo[0]["morts"]; ?></b>
										<div class="clearfix"></div>
										<img src="<?php echo $configAssetsUrL; ?>/images/sabre.png"> Kills : <b><?php echo $userProfileInfo[0]["kills"]; ?></b>
										<div class="clearfix"></div>
										<img src="<?php echo $configAssetsUrL; ?>/images/ratio2.png"> Ratio : <b><?php echo number_format($ratio, 2); ?></b>
										<div class="clearfix"></div>
										<img src="<?php echo $configAssetsUrL; ?>/images/menotte.png"> Emprisonné : <b><?php echo $userProfileInfo[0]["prison_count"]; ?> fois</b>
										<div class="clearfix"></div>
									</section>
									
									<section id="tab_travail">
										<img src="<?php echo $configSwfUrL; ?>/habbo-imaging/badges/<?php echo $travailInfo[0]["badge"]; ?>.gif">
										<div class="name"><?php echo  utf8_decode($travailInfo[0]["name"]); ?></div>
										<div class="rank"><?php if($travailUserInfo[0]["group_id"] != 1) { echo $rankInfo[0]["name"]; } else { echo "N'a pas d'emploi"; } ?></div>
										<div class="clearfix"></div>
									</section>
								</div>
<?php
}
?>