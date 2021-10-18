<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	if(!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
		return;
	}
	
	$rankInfo = $db->executeQuery('SELECT * FROM groups_rank WHERE id=? LIMIT 1', array($_GET["id"]));
	if($rankInfo == null)
	{
		return;
	}
	else
	{
?>
					<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/tools_edit.gif"> Modifier le rang <?php echo $rankInfo[0]["name"]; ?></h1>
					<form action="<?php echo $configBaseUrL; ?>/home" method="POST">
						<input type="hidden" id="rankId" value="<?php echo $rankInfo[0]["id"]; ?>" disabled>
						<input type="text" id="name" value="<?php echo $rankInfo[0]["name"]; ?>" placeholder="Nom du rang" <?php if($userInfo[0]["rank"] != 8) { echo "disabled"; } ?>>
						<input type="text" id="look_h" value="<?php echo $rankInfo[0]["look_h"]; ?>" placeholder="Look homme" <?php if($userInfo[0]["rank"] != 8) { echo "disabled"; } ?>>
						<input type="text" id="look_f" value="<?php echo $rankInfo[0]["look_f"]; ?>" placeholder="Look fille" <?php if($userInfo[0]["rank"] != 8) { echo "disabled"; } ?>>
						<input type="text" id="salaire" value="<?php echo $rankInfo[0]["salaire"]; ?>" placeholder="Salaire">
						<select id="workEverywhere" <?php if($userInfo[0]["rank"] != 8) { echo "disabled"; } ?>>
							<option disabled>Peut travailler partout</option>
							<?php if($rankInfo[0]["work_everywhere"] == 1) { ?>
							<option name="yes">Oui</option>
							<option name="no">Non</option>
							<?php } else { ?>
							<option name="no">Non</option>
							<option name="yes">Oui</option>
							<?php } ?>
						</select>
						<input type="submit" id="changeRank" value="Modifier le rang" class="btn_pink">
					</form>
					<div class="clearfix"></div>
<?php
	}
}
