<?php 
include("../../includes/config.php");
require_once('../class/database.php');
$db = new Database();

if(isset($_GET["id"]) && is_numeric($_GET["id"]))
{
	$getSms = $db->executeQuery('SELECT * FROM telephone_sms WHERE user_id = ? OR for_user = ? ORDER by date DESC', array($_GET["id"], $_GET["id"]));
	$countTotal = 0;
	$smsTotal = [];
	foreach ($getSms as $getSmsRow) {
		if($getSmsRow["user_id"] == $_GET["id"])
		{
			$userId = $getSmsRow["for_user"];
		}
		else
		{
			$userId = $getSmsRow["user_id"];
		}
		
		if (isset($smsTotal[$userId])) {
			continue;
		}
		
		$countTotal ++;
		$smsTotal[$userId] = [$userId];
		$userContactInfo = $db->executeQuery('SELECT * FROM users WHERE id = ?', array($userId));
?>
					<div class="row" id="<?php echo $userContactInfo[0]["id"]; ?>">
						<div class="avatar"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userContactInfo[0]["look"]; ?>&head_direction=3&gesture=sml" <?php if($getSmsRow["user_id"] == $_GET["id"] || $getSmsRow["lu"] == 1) { echo 'class="lu"'; } ?>></div>
						<div class="username"><?php echo $userContactInfo[0]["username"]; ?></div>
						<div class="message"><?php echo strlen(htmlentities($getSmsRow["message"])) > 20 ? substr(htmlentities($getSmsRow["message"]),0,20)."..." : htmlentities($getSmsRow["message"]); ?></div>
						<div class="clearfix"></div>
					</div>
<?php
	}
	
	if($countTotal == 0) {
		echo '<div class="nomessage">Aucun message</div>';
	}
}
?>