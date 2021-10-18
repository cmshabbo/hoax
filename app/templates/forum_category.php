<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
	$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
	
	if(!isset($_GET["id"]))
		return;
	
	if(!is_numeric($_GET["id"]))
		return;
?>
					<div class="forum">
						<div class="back" id="backToHomeForum"><img src="<?php echo $configAssetsUrL; ?>/images/forum/back.png"> Retour à l'accueil du forum</div>
						<div class="clearfix"></div>
						<?php
						$category = $db->executeQuery('SELECT * FROM forums_category WHERE id = ? LIMIT 1', array($_GET["id"]));
						foreach ($category as $categoryRow) {
						?>
						<div class="section">
							<div class="name" id="newTopic">
								<img src="<?php echo $configAssetsUrL; ?>/images/forum/<?php echo $categoryRow["icon"]; ?>"><?php echo $categoryRow["name"]; ?>
								<div class="icon NewTopic" id="<?php echo $categoryRow["id"]; ?>"><img src="<?php echo $configAssetsUrL; ?>/images/forum/new.png"></div>
							</div>
							<div class="content">
								<?php
								$messagesParPage = 10;
 
								$retour_total = $db->executeQuery('SELECT COUNT(*) AS count_row FROM forums_topics WHERE category_id = ?', array($categoryRow['id']));
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
									$topic = $db->executeQueryBind('SELECT * FROM forums_topics WHERE category_id = :id ORDER by last_update_comment DESC LIMIT :premiereEntree, :page_value', $categoryRow["id"], $premiereEntree, $messagesParPage);
								} else
								{
									$topic = $db->executeQuery('SELECT * FROM forums_topics WHERE category_id = ? ORDER by last_update_comment DESC', array($categoryRow["id"]));
								}
								foreach ($topic as $topicRow) {
									$authorInfoTopic = $db->executeQuery('SELECT * FROM users WHERE id = ? LIMIT 1', array($topicRow["author"]));
								?>
								<div class="row">
									<div class="icon"><img src="<?php echo $configAssetsUrL; ?>/images/menu/community.png"></div>
									<div class="row_infos">
										<div class="row_name topicList" id="<?php echo $topicRow["id"]; ?>"><?php echo htmlentities($topicRow["name"]); ?></div>
										<div class="row_description">Le <?php echo date("d/m/Y", strtotime($topicRow["last_update"])); ?> à <?php echo date("H:i", strtotime($topicRow["last_update"])); ?> par <span><?php echo $authorInfoTopic[0]["username"]; ?></span></div>
									</div>
									<?php
									$userInfoTopic = $db->executeQuery('SELECT * FROM users WHERE id = ? LIMIT 1', array($topicRow["last_user"]));
									?>
									<div class="row_last_topic" style="width: 180px">
										<div class="avatar"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userInfoTopic[0]["look"]; ?>&head_direction=3&gesture=sml&size=n&headonly=1"></div>
										<div class="topic_author" style="width: 120px; float: right">Dernière réponse par <span><?php echo $userInfoTopic[0]["username"]; ?></span>, le <?php echo date("d/m/Y", strtotime($topicRow["last_update_comment"])); ?> à <?php echo date("H:i", strtotime($topicRow["last_update_comment"])); ?></div>
									</div>
									
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
									  echo '<span onclick="loadCategoryPage(\''.$_GET["id"].'\', \''.$i.'\')">'.$i.'</span>';
								 }
							}
							echo '';
							?>
						</div>
					</div>
					
					<div class="clearfix"></div>
<?php } ?>
