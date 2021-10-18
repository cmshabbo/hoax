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
	
	$canEdit = false;
	
	if($topicInfo[0]["author"] == $userInfo[0]["rank"] || $userInfo[0]["rank"] > 7)
	{
		$canEdit = true;
	}
	
	if($canEdit == false)
		return;
?>
				<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/forum/new.png"> Modifier mon topic</div></h1>
				<form action="<?php echo $configBaseUrL; ?>/home" method="POST">
					<input type="text" id="title_topic" placeholder="Titre du topic" class="withoutpadding" maxlength="60" value="<?php echo $topicInfo[0]["name"]; ?>">
					<?php if($topicInfo[0]["category_id"] == 1) { ?>
					<input type="text" id="image_topic" placeholder="Lien de l'image" class="withoutpadding" value="<?php echo $topicInfo[0]["image"]; ?>">
					<?php } ?>
					<textarea id="desc_topic" placeholder="Contenu de votre topic" class="withoutpadding"><?php echo $topicInfo[0]["content"]; ?></textarea>
					<input type="hidden" id="id_topic" class="withoutpadding" value="<?php echo $topicInfo[0]["id"]; ?>" disabled>
					<input type="submit" id="editTopicButton" value="Modifier  le topic" class="btn_pink">
				</form>
				<div class="clearfix"></div>
				
				<script>
					CKEDITOR.replace( 'desc_topic' );
				</script>
<?php } ?>
