<?php 
include("../../includes/config.php");
require_once('../class/database.php');
$db = new Database();

if(isset($_GET["id"]) && is_numeric($_GET["id"]) && isset($_GET["user_id"]) && is_numeric($_GET["user_id"]))
{
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id = ?', array($_GET["id"]));
	$userContactInfo = $db->executeQuery('SELECT * FROM users WHERE id = ?', array($_GET["user_id"]));
	if($userInfo == null || $userContactInfo == null)
		return;
	
	$db->executeInsert('UPDATE telephone_sms SET lu=? WHERE for_user=?', array("1", $userInfo[0]['id']));
?>
	<div class="header_sms">
		<div class="avatar"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userContactInfo[0]["look"]; ?>&head_direction=3&gesture=sml"></div>
		<div class="username"><?php echo $userContactInfo[0]["username"]; ?></div>
		<div class="online <?php if($userContactInfo[0]["online"] == 1) { echo "yes"; } else { echo "no"; } ?>"><i class="fas fa-circle"></i></div>
		<div class="call" id="<?php echo $userContactInfo[0]["username"]; ?>"><i class="fas fa-phone"></i></div>
		<div class="position" id="position"><i class="fas fa-map-marker-alt"></i></div>
		<div class="clearfix"></div>
	</div>
	
	<div class="messages">
		<?php
		$getSms = $db->executeQuery('(SELECT * FROM telephone_sms WHERE user_id = ? AND for_user = ? OR user_id = ? AND for_user = ? ORDER by date desc LIMIT 50 ) ORDER BY
        id', array($_GET["id"], $_GET["user_id"], $_GET["user_id"], $_GET["id"]));
		foreach ($getSms as $getSmsRow) {
		?>
		<div class="row <?php if($getSmsRow["user_id"] == $userInfo[0]["id"]) { echo "me"; } else { echo "notme"; } ?>">
		<?php 
			$msg = $getSmsRow["message"];
			$msg = preg_replace("#(?<=\s|^)" . preg_quote(":)") . "#", "🙂", $msg);
			$msg = preg_replace("#(?<=\s|^)" . preg_quote("<3") . "#", "❤️", $msg);
			$msg = preg_replace("#(?<=\s|^)" . preg_quote("</3") . "#", "💔", $msg);
			$msg = preg_replace("#(?<=\s|^)" . preg_quote(":D") . "#", "😃", $msg);
			$msg = preg_replace("#(?<=\s|^)" . preg_quote(":p") . "#", "😋", $msg);
			$msg = preg_replace("#(?<=\s|^)" . preg_quote(":P") . "#", "😋", $msg);
			$msg = preg_replace("#(?<=\s|^)" . preg_quote(":(") . "#", "☹️", $msg);
			$msg = preg_replace("#(?<=\s|^)" . preg_quote(":o") . "#", "😮", $msg);
			$msg = preg_replace("#(?<=\s|^)" . preg_quote(":O") . "#", "😮", $msg);
			$msg = preg_replace("#(?<=\s|^)" . preg_quote(":$") . "#", "😊", $msg);
			$msg = preg_replace("#(?<=\s|^)" . preg_quote(":'(") . "#", "😥", $msg);
			$msg = preg_replace("#(?<=\s|^)" . preg_quote(":@") . "#", "😡", $msg);
			$msg = preg_replace("#(?<=\s|^)" . preg_quote(":*") . "#", "😘", $msg);
			$msg = preg_replace("#(?<=\s|^)" . preg_quote("(y)") . "#", "👍", $msg);
			$msg = preg_replace("#(?<=\s|^)" . preg_quote(":/") . "#", "😕", $msg);
			$msg = preg_replace("#(?<=\s|^)" . preg_quote("(a)") . "#", "😇", $msg);
			echo htmlentities($msg); 
		?>
		</div>
		<?php
		}
		?>
	</div>
	
	<div class="sendMessage">
		<input type="text" placeholder="Votre message..." id="MessageValue" maxlength="2500"></input>
		<input type="hidden" id="userMessageValue" value="<?php echo $userContactInfo[0]["id"]; ?>"></input>
	</div>
	
	<script>
	$(".messages").scrollTop($(".messages")[0].scrollHeight);
	</script>

<?php
}
?>