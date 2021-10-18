<?php 
include("../../includes/config.php");
require_once('../class/database.php');
$db = new Database();

if(isset($_GET["id"]) && is_numeric($_GET["id"]))
{
	$getContacts = $db->executeQuery('SELECT * FROM messenger_friendships WHERE user_one_id = ? OR user_two_id = ?', array($_GET["id"], $_GET["id"]));
	echo "Mes contacts";
?>
					<div class="row">
						<div class="avatar"><img src="<?php echo $configSwfUrL; ?>/habbo-imaging/badges/POLICE.gif" style="margin-top: 15px"></div>
						<div class="username">POLICE NATIONALE</div>
						<div class="call" id="17"><i class="fas fa-phone"></i></div>
						<div class="clearfix"></div>
					</div>
<?php
	foreach ($getContacts as $getContactsRow) {
		if($getContactsRow["user_one_id"] == $_GET["id"])
		{
			$userId = $getContactsRow["user_two_id"];
		}
		else
		{
			$userId = $getContactsRow["user_one_id"];
		}
		$userContactInfo = $db->executeQuery('SELECT * FROM users WHERE id = ? LIMIT 1', array($userId));
?>
					<div class="row">
						<div class="avatar"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userContactInfo[0]["look"]; ?>&head_direction=3&gesture=sml"></div>
						<div class="username"><?php echo $userContactInfo[0]["username"]; ?></div>
						<div class="online <?php if($userContactInfo[0]["online"] == 1) { echo "yes"; } else { echo "no"; } ?>"><i class="fas fa-circle"></i></div>
						<div class="call" id="<?php echo $userContactInfo[0]["username"]; ?>"><i class="fas fa-phone"></i></div>
						<div class="sms" id="<?php echo $userContactInfo[0]["id"]; ?>"><i class="fas fa-comment-alt"></i></div>
						<div class="delete" id="<?php echo $userContactInfo[0]["id"]; ?>"><i class="fas fa-times"></i></div>
						<div class="clearfix"></div>
					</div>
<?php
	}
}
?>