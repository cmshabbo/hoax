<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	if(!isset($_GET["id"])) {
		return;
	}
	
	$travailInfo = $db->executeQuery('SELECT * FROM groups WHERE id=? LIMIT 1', array($_GET["id"]));
	if($travailInfo == null || $travailInfo[0]["id"] == 1)
	{
		echo '<div class="warningMessage"><img src="'.$configAssetsUrL.'/images/frank.gif"><div class="clearfix"></div> Impossible de trouver ce métier...<div class="clearfix" style="margin-top: 10px"></div></div>';
	}
	else
	{
		$travailUserInfo = $db->executeQuery('SELECT * FROM group_memberships WHERE user_id=? LIMIT 1', array($userInfo[0]["id"]));
		
		$canEditProduits = false;
		$canEditRank = false;
		if($travailInfo[0]["id"] == 18 && $userInfo[0]["rank"] == 8 || $travailInfo[0]["id"] == 18 && $travailUserInfo[0]["group_id"] == 18 && $travailUserInfo[0]["rank_id"] == 3 || $travailInfo[0]["id"] == 18 && $travailUserInfo[0]["group_id"] == 18 && $travailUserInfo[0]["rank_id"] == 7 || $travailInfo[0]["id"] == 18 && $travailUserInfo[0]["group_id"] == 18 && $travailUserInfo[0]["rank_id"] == 8)
		{
			$canEditProduits = true;
		}
		
		if($userInfo[0]["rank"] == 8 || $travailUserInfo[0]["group_id"] == 18 && $travailUserInfo[0]["rank_id"] == 3 && $travailInfo[0]["id"] != 18 && $travailInfo[0]["usine"] == 0)
		{
			$canEditRank = true;
		}
?>
					<div class="travail">
						<div class="infos">
							<img src="<?php echo $configSwfUrL; ?>/habbo-imaging/badges/<?php echo $travailInfo[0]["badge"]; ?>.gif" class="badge">
							<h1><?php echo utf8_decode($travailInfo[0]["name"]); ?></h1>
							<p><?php echo utf8_decode($travailInfo[0]["desc"]); ?></p>
						</div>
						
						<div class="chiffre"><img src="<?php echo $configAssetsUrL; ?>/images/menu/shop.png"> <?php if($travailInfo[0]["payedByGouv"] == 1) { echo "Travaille pour l'état"; } else { echo $travailInfo[0]["chiffre"]; } ?></div>
						<?php if($travailInfo[0]["forum"] != 0) { ?>
						<button id="<?php echo $travailInfo[0]["forum"]; ?>" class="forum btn_blue">Forum du travail</button>
						<?php } ?>
						
						<?php if($canEditProduits == true) { ?>
						<button id="EditProduits" class="btn_pink">Éditer les produits et leur taxe</button>
						<button id="EditLooks" class="btn_green">Éditer les looks et leur taxe</button>
						<?php } ?>
						
						<?php
						$rankList = $db->executeQuery('SELECT * FROM groups_rank WHERE job_id = ? ORDER by rank_id DESC', array($travailInfo[0]["id"]));
						foreach ($rankList as $rankListRow) {
						?>
						<h1 class="title"><div class="heading"><?php echo $rankListRow["name"]; ?> <?php if($canEditRank == true) { ?><img src="<?php echo $configAssetsUrL; ?>/images/tools_edit.gif" class="edit" id="<?php echo $rankListRow["id"]; ?>"><?php } ?></div></h1>
							<?php
							$userList = $db->executeQuery('SELECT * FROM group_memberships WHERE group_id = ? AND rank_id = ? ORDER by rank_id DESC', array($travailInfo[0]["id"], $rankListRow["rank_id"]));
							$count = 0;
							$direction = 0;
							foreach ($userList as $userListRow) {
								$userJobInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($userListRow["user_id"]));
								$count++;
								$direction++;
							?>
							<div class="user">
								<div class="avatar">
									<img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userJobInfo[0]["look"]; ?>&head_direction=<?php echo $direction; ?>&direction=<?php echo $direction; ?>&gesture=sml&size=l">
								</div>
								<div class="username"><?php echo $userJobInfo[0]["username"]; ?></div>
							</div>
							<?php if($direction == 5) { $direction = 0; } } if($count == 0) { echo '<div class="warning">Aucun civil n\'occupe ce poste.</div>'; } ?>
						<?php } ?>
					</div>
					<div class="clearfix"></div>
<?php
	}
}
