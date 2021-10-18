<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	
	if(!isset($_GET["id"]))
		return;
	
	if(!is_numeric($_GET["id"]))
		return;
	
	$topicInfo = $db->executeQuery('SELECT * FROM forums_topics WHERE id = ? LIMIT 1', array($_GET["id"]));
	if(count($topicInfo) == 0)
		return;
	
	if($topicInfo[0]["topic_locked"] == 1)
		return;
?>
				<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/forum/new.png"> Nouvelle réponse</div></h1>
				<form action="<?php echo $configBaseUrL; ?>/home" method="POST">
					<textarea id="desc_reponse" placeholder="Contenu de votre réponse" class="withoutpadding"></textarea>
					<input type="hidden" id="topic_response" class="withoutpadding" value="<?php echo $_GET["id"]; ?>" disabled>
					<input type="submit" id="newReponseButton" value="Répondre" class="btn_pink">
				</form>
				<div class="clearfix"></div>
				
				<script>
					CKEDITOR.replace( 'desc_reponse' );
				</script>
<?php } ?>
