<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	
	if(!isset($_GET["id"]))
		return;
	
	if(!is_numeric($_GET["id"]))
		return;
	
	$commentInfo = $db->executeQuery('SELECT * FROM forums_comments WHERE id = ? LIMIT 1', array($_GET["id"]));
	if(count($commentInfo) == 0)
		return;
	
	$canEdit = false;
	
	if($commentInfo[0]["user_id"] == $userInfo[0]["rank"] || $userInfo[0]["rank"] > 7)
	{
		$canEdit = true;
	}
	
	if($canEdit == false)
		return;
?>
				<h1 class="title"><div class="heading"><img src="<?php echo $configBaseUrL; ?>/assets/images/forum/new.png"> Modifier la réponse</div></h1>
				<form action="<?php echo $configBaseUrL; ?>/home" method="POST">
					<textarea id="desc_reponse" placeholder="Contenu de votre topic" class="withoutpadding"><?php echo $commentInfo[0]["content"]; ?></textarea>
					<input type="hidden" id="topic_reponse" class="withoutpadding" value="<?php echo $commentInfo[0]["id"]; ?>" disabled>
					<input type="submit" id="editCommentButton" value="Modifier la réponse" class="btn_pink">
				</form>
				<div class="clearfix"></div>
				
				<script>
					CKEDITOR.replace( 'desc_reponse' );
				</script>
<?php } ?>
