<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
?>
					<div class="column50 left">
						<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/friend.gif"> Quelques civils en ligne</div></h1>
						<div class="community">
							<?php
							$usersOnline = $db->executeQuery('SELECT * FROM users WHERE online = "1" ORDER BY RAND() LIMIT 6');
							foreach ($usersOnline as $usersOnlineRow) {
								$userTravail = $db->executeQuery('SELECT * FROM group_memberships WHERE user_id = ?', array($usersOnlineRow["id"]));
								$userTravailInfo = $db->executeQuery('SELECT * FROM groups WHERE id = ?', array($userTravail[0]["group_id"]));
							?>
							<div class="row">
								<div class="avatar"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=avatarimage?figure=<?php echo $usersOnlineRow["look"]; ?>&direction=3&head_direction=3&action=wlk&gesture=sml&size=l&size=l"></div>
								<div class="username"><?php echo $usersOnlineRow["username"]; ?></div>
								<div class="badge"><img src="<?php echo $configSwfUrL; ?>/habbo-imaging/badges/<?php echo $userTravailInfo[0]["badge"]; ?>.gif"></div>
							</div>
							<?php
							}
							?>
						</div>
					</div>
					
					<div class="column50 right">
						<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/sujet.gif"> Derniers sujets</div></h1>
						<div class="last_topics">
						<?php
						$lastTopic = $db->executeQuery('SELECT * FROM forums_topics ORDER BY id DESC LIMIT 7');
						foreach ($lastTopic as $lastTopicRow) {
							$categoryInfo = $db->executeQuery('SELECT * FROM forums_category WHERE id = ? LIMIT 1', array($lastTopicRow["category_id"]));
						?>
							<div class="row" id="<?php echo $lastTopicRow["id"]; ?>">
								<div class="icon"><img src="<?php echo $configAssetsUrL; ?>/images/forum/<?php echo $categoryInfo[0]["icon"]; ?>"></div>
								<div class="name"><?php echo strlen(htmlentities($lastTopicRow["name"])) > 40 ? substr(htmlentities($lastTopicRow["name"]),0,40)."..." : htmlentities($lastTopicRow["name"]); ?></div>
								<div class="clearfix"></div>
							</div>
						<?php
						}
						?>
						<div class="clearfix"></div>
						</div>
						
					</div>
					
					<div class="column100 right">
						<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/article.gif"> Derniers articles</div></h1>
						<?php
						$newList = $db->executeQuery('SELECT * FROM forums_topics WHERE category_id = 1 ORDER BY id DESC LIMIT 3');
						foreach ($newList as $newListRow) {
						?>
						<article id="<?php echo $newListRow["id"]; ?>">
							<img src="<?php echo $newListRow["image"]; ?>">
							<div class="title"><?php echo strlen(htmlentities($newListRow["name"])) > 35 ? substr(htmlentities($newListRow["name"]),0,35)."..." : htmlentities($newListRow["name"]); ?></div>
						</article>
						<?php
						}
						?>
						
					</div>
					
					
					<div class="clearfix"></div>

<?php } ?>
