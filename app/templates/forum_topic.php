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
	
	$authorInfoTopic = $db->executeQuery('SELECT * FROM users WHERE id = ? LIMIT 1', array($topicInfo[0]["author"]));
	$userLike = $db->executeQuery('SELECT * FROM forums_like WHERE user_id = ? AND topic_id = ? LIMIT 1', array($userInfo[0]["id"], $topicInfo[0]["id"]));
	$totalLike = $db->executeQuery('SELECT * FROM forums_like WHERE topic_id = ?', array($topicInfo[0]["id"]));
	if(count($totalLike) == 1 || count($totalLike) == 0)
	{
		$phraseLike = count($totalLike)." personne aime ça";
	}
	else
	{
		$phraseLike = count($totalLike)." personnes aiment ça";
	}
	
	$canEdit = false;
	$canDelete = false;
	$canLock = false;
	
	if($userInfo[0]["rank"] > 7)
	{
		$canEdit = true;
		$canDelete = true;
		$canLock = true;
	}
	else if($topicInfo[0]["author"] == $userInfo[0]["id"])
	{
		$canEdit = true;
		$canDelete = true;
	}
?>
					<div class="forum">
						<div class="back backToCategoryForum" id="<?php echo $topicInfo[0]["category_id"]; ?>"><img src="<?php echo $configAssetsUrL; ?>/images/forum/back.png"> Retour à la catégorie</div>
						<div class="clearfix"></div>
						
						<div class="topic">
							<div class="name">
								<?php echo htmlentities($topicInfo[0]["name"]); ?> 
								<?php if($canDelete == true) { ?><div class="icon deleteTopic" id="<?php echo $topicInfo[0]["id"]; ?>"><img src="<?php echo $configAssetsUrL; ?>/images/forum/delete.png"></div><?php } ?>
								<?php if($canLock == true) { ?><div class="icon lockTopic" id="<?php echo $topicInfo[0]["id"]; ?>"><img src="<?php echo $configAssetsUrL; ?>/images/forum/lock.png"></div><?php } ?>
								<?php if($canEdit == true) { ?><div class="icon editTopic" id="<?php echo $topicInfo[0]["id"]; ?>"><img src="<?php echo $configAssetsUrL; ?>/images/forum/new.png"></div><?php } ?>
							</div>
							
							<div class="user_infos">
								<div class="avatar">
									<img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $authorInfoTopic[0]["look"]; ?>&direction=3&head_direction=3&action=wav&gesture=sml&size=l">
								</div>
								
								<div class="username"><?php echo $authorInfoTopic[0]["username"]; ?></div>
							</div>
							
							
							<div class="topic_infos">
								<div class="description">
									<?php 
									$topicContent = $topicInfo[0]["content"];
									$topicContent = str_ireplace('<script', '', $topicContent);
									$topicContent = str_ireplace('<style', '', $topicContent);
									$topicContent = str_ireplace('onclick="', '', $topicContent);
									$topicContent = str_ireplace('javascript:', '', $topicContent);
									echo $topicContent;
									?>
									<hr>
									<div class="love LoveTopic" id="<?php echo $topicInfo[0]["id"]; ?>"><img src="<?php echo $configAssetsUrL; ?>/images/forum/love.png" <?php if(count($userLike) == 0) { ?>class="not"<?php } ?>> <span id="totalLikes"><?php echo $phraseLike; ?></span></div>
									<div class="date">Le <?php echo date("d/m/Y", strtotime($topicInfo[0]["date"])); ?> à <?php echo date("H:i", strtotime($topicInfo[0]["date"])); ?></div>
									<div class="clearfix"></div>
								</div>
							</div>
							
							<div class="clearfix"></div>
						</div>
						
						<?php
						$messagesParPage = 10;
						$retour_total = $db->executeQuery('SELECT COUNT(*) AS count_row FROM forums_comments WHERE topic_id = ?', array($topicInfo[0]["id"]));
						$total = $retour_total[0]["count_row"];
								 
								
						$nombreDePages=ceil($total/$messagesParPage);
								 
						if(isset($_GET['page']))
						{
							if($_GET['page'] > 0)
							{
								$pageActuelle=intval($_GET['page']);
								 
								if($pageActuelle>$nombreDePages)
								{
									$pageActuelle=$nombreDePages;
								}
							}
							else
							{
								$pageActuelle=1;
							}
						}
						else
						{
							 $pageActuelle=1;
						}
								 
						$premiereEntree=($pageActuelle-1)*$messagesParPage;
				
						if($total > $messagesParPage) {
							$comment = $db->executeQueryBind('SELECT * FROM forums_comments WHERE topic_id = :id ORDER by id ASC LIMIT :premiereEntree, :page_value', $topicInfo[0]["id"], $premiereEntree, $messagesParPage);
						} 
						else
						{
							$comment = $db->executeQuery('SELECT * FROM forums_comments WHERE topic_id = ? ORDER by id ASC', array($topicInfo[0]["id"]));
						}
						foreach ($comment as $commentRow) {
							$canEditComment = false;
							$canDeleteComment = false;
							
							if($userInfo[0]["rank"] > 7 || $commentRow["user_id"] == $userInfo[0]["id"])
							{
								$canEditComment = true;
								$canDeleteComment = true;
							}
							$authorComment = $db->executeQuery('SELECT * FROM users WHERE id = ? LIMIT 1', array($commentRow["user_id"]));
							$userLikeComment = $db->executeQuery('SELECT * FROM forum_like_comments WHERE user_id = ? AND comment_id = ? LIMIT 1', array($userInfo[0]["id"], $commentRow["id"]));
							$totalLikeComment = $db->executeQuery('SELECT * FROM forum_like_comments WHERE comment_id = ?', array($commentRow["id"]));
							if(count($totalLikeComment) == 1 || count($totalLikeComment) == 0)
							{
								$phraseLikeComment = count($totalLikeComment)." personne aime ça";
							}
							else
							{
								$phraseLikeComment = count($totalLikeComment)." personnes aiment ça";
							}
						?>
						<div class="topic">
							<div class="name comment">
								Réponse #<?php echo $commentRow["id"]; ?>
								<?php if($canDeleteComment == true) { ?><div class="icon deleteComment" id="<?php echo $commentRow["id"]; ?>"><img src="<?php echo $configAssetsUrL; ?>/images/forum/delete.png"></div><?php } ?>
								<?php if($canEditComment == true) { ?><div class="icon editComment" id="<?php echo $commentRow["id"]; ?>"><img src="<?php echo $configAssetsUrL; ?>/images/forum/new.png"></div><?php } ?>
							</div>
							
							<div class="user_infos">
								<div class="avatar">
									<img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $authorComment[0]["look"]; ?>&head_direction=2&gesture=sml&size=l">
								</div>
								
								<div class="username"><?php echo $authorComment[0]["username"]; ?></div>
							</div>
							
							
							<div class="topic_infos">
								<div class="description">
									<?php 
									$comment = $commentRow["content"];
									$comment = str_ireplace('<script', '', $comment);
									$comment = str_ireplace('<style', '', $comment);
									$comment = str_ireplace('onclick="', '', $comment);
									$comment = str_ireplace('javascript:', '', $comment);
									echo $comment;
									?>
									<hr>
									<div class="love" onclick="likeComment(this, '<?php echo $commentRow["id"]; ?>', '<?php echo $configAssetsUrL; ?>')"><img src="<?php echo $configAssetsUrL; ?>/images/forum/love.png" <?php if(count($userLikeComment) == 0) { ?>class="not"<?php } ?>> <span class="totalLikes"><?php echo $phraseLikeComment; ?></span></div>
									<div class="date">Le <?php echo date("d/m/Y", strtotime($commentRow["date"])); ?> à <?php echo date("H:i", strtotime($commentRow["date"])); ?></div>
									<div class="clearfix"></div>
								</div>
							</div>
							
							<div class="clearfix"></div>
						</div>
						<?php
						}
						?>
						
						<div class="pagination categoryPagination">
							<?php
							if($nombreDePages != 0) 
							{
								echo "Page ";
							}
							
							for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
							{
								 //On va faire notre condition
								 if($i==$pageActuelle) //Si il s'agit de la page actuelle...
								 {
									 echo '<span id="'.$i.'" class="active">'.$i.'</span>';
								 }	
								 else //Sinon...
								 {
									  echo '<span onclick="loadTopicPage(\''.$topicInfo[0]["id"].'\', \''.$i.'\')">'.$i.'</span>';
								 }
							}
							echo '';
							?>
						</div>
						
						<?php if($topicInfo[0]["topic_locked"] == 0 || $userInfo[0]["rank"] > 7) { ?>
						<button class="btn_pink newReply" id="<?php echo $topicInfo[0]["id"]; ?>">Répondre à ce topic</button>
						<?php } ?>
					</div>
					
					<div class="clearfix"></div>
<?php } ?>
