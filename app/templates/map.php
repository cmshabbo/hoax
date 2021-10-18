<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	if($userInfo[0]["gps"] == 0) {
?>
			<img src="<?php echo $configAssetsUrL; ?>/images/map.png">
			<h1>Vous n'avez pas de GPS</h1>
<?php } else { ?>
	<img src="<?php echo $configAssetsUrL; ?>/images/map3.png">
<?php } } ?>