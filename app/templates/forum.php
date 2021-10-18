<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
?>
					<div class="forum">
						<?php
						$sections = $db->executeQuery('SELECT * FROM forums_sections');
						foreach ($sections as $sectionsRow) {
						?>
						<div class="section">
							<div class="name"><img src="<?php echo $configAssetsUrL; ?>/images/forum/<?php echo $sectionsRow["icon"]; ?>"><?php echo $sectionsRow["name"]; ?></div>
							<div class="content">
								<?php
								$category = $db->executeQuery('SELECT * FROM forums_category WHERE section_id = ?', array($sectionsRow["id"]));
								foreach ($category as $categoryRow) {
								?>
								<div class="row">
									<div class="icon"><img src="<?php echo $configAssetsUrL; ?>/images/forum/<?php echo $categoryRow["icon"]; ?>"></div>
									<div class="row_infos">
										<div class="row_name category" id="<?php echo $categoryRow["id"]; ?>"><?php echo $categoryRow["name"]; ?></div>
										<div class="row_description"><?php echo $categoryRow["description"]; ?></div>
									</div>
									<?php
									$topicInfo = $db->executeQuery('SELECT * FROM forums_topics WHERE category_id=? ORDER BY last_update_comment DESC', array($categoryRow["id"]));
									if(count($topicInfo) > 0)
									{
										$userInfoTopic = $db->executeQuery('SELECT * FROM users WHERE id = ? LIMIT 1', array($topicInfo[0]["last_user"]));
									?>
									<div class="row_last_topic">
										<div class="avatar"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userInfoTopic[0]["look"]; ?>&head_direction=3&gesture=sml&size=n&headonly=1"></div>
										<div class="topic_name" id="<?php echo $topicInfo[0]["id"]; ?>"><?php echo strlen(htmlentities($topicInfo[0]["name"])) > 40 ? substr(htmlentities($topicInfo[0]["name"]),0,40)."..." : htmlentities($topicInfo[0]["name"]); ?></div>
										<div class="topic_author">Le <?php echo date("d/m/Y", strtotime($topicInfo[0]["last_update_comment"])); ?> à <?php echo date("H:i", strtotime($topicInfo[0]["last_update_comment"])); ?>, <span><?php echo $userInfoTopic[0]["username"]; ?></span></div>
									</div>
									<?php
									}
									?>
									
									<div class="clearfix"></div>
								</div>
								<?php
								}
								?>
							</div>
							<div class="clearfix"></div>
						</div>
						<?php
						}
						?>
					</div>
					
					<div class="clearfix"></div>
<?php } ?>
