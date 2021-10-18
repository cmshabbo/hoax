<?php 
include("../../includes/config.php");
require_once('../class/database.php');
$db = new Database();

$bestUsers = $db->executeQuery('SELECT * FROM users WHERE rank != 8 ORDER by quizz_points DESC LIMIT 5');
foreach ($bestUsers as $bestUsersRow) {
?>
		<div class="users_row">
			<div class="avatar"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $bestUsersRow["look"]; ?>&head_direction=3&gesture=sml&action=wav"></div>
			<div class="username"><?php echo $bestUsersRow["username"]; ?></div>
			<div class="points"><?php echo $bestUsersRow["quizz_points"]; ?> points</div>
			<div class="clearfix"></div>
		</div>
<?php
}