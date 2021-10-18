<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	
	if(!isset($_GET["id"]))
		return;
	
	if(!is_numeric($_GET["id"]))
		return;
	
	$categoryInfo = $db->executeQuery('SELECT * FROM forums_category WHERE id = ? LIMIT 1', array($_GET["id"]));
	if(count($categoryInfo) == 0)
		return;
	
	if($categoryInfo[0]["rank"] > $userInfo[0]["rank"])
		return;
?>
				<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/forum/new.png"> Rédiger un nouveau topic</div></h1>
				<form action="<?php echo $configBaseUrL; ?>/home" method="POST">
					<input type="text" id="title_topic" placeholder="Titre du topic" class="withoutpadding" maxlength="60">
					<?php if($_GET["id"] == 1) { ?>
					<input type="text" id="image_topic" placeholder="Lien de l'image" class="withoutpadding">
					<?php } ?>
					<textarea id="desc_topic" placeholder="Contenu de votre topic" class="withoutpadding"></textarea>
					<input type="hidden" id="category_topic" class="withoutpadding" value="<?php echo $_GET["id"]; ?>" disabled>
					<input type="submit" id="newTopicButton" value="Créer le topic" class="btn_pink">
				</form>
				<div class="clearfix"></div>
				
				<script>
					CKEDITOR.replace( 'desc_topic' );
				</script>
<?php } ?>
