<?php 
include("../../includes/config.php");
require_once('../class/database.php');
$db = new Database();
?>
								<?php
								$userRecherched = $db->executeQuery('SELECT * FROM users_wanted ORDER BY id DESC');
								foreach ($userRecherched as $userRecherchedRow) {
									$userWantedInfo = $db->executeQuery('SELECT * FROM users WHERE id = ? LIMIT 1', array($userRecherchedRow["user_id"]));
								?>
								<div class="row">
									<div class="avatar"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userWantedInfo[0]["look"]; ?>&action=wav&head_direction=3&direction=3&gesture=sml"></div>
									<div class="username"><?php echo $userWantedInfo[0]["username"]; ?></div>
									<div class="stars">
										<?php if($userRecherchedRow["level"] == 1) { ?>
										<i class="fas fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i>
										<?php } elseif($userRecherchedRow["level"] == 2) { ?>
										<i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i>
										<?php } elseif($userRecherchedRow["level"] == 3) { ?>
										<i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i>
										<?php } elseif($userRecherchedRow["level"] == 4) { ?>
										<i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="far fa-star"></i>
										<?php } elseif($userRecherchedRow["level"] == 5) { ?>
										<i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
										<?php } ?>
									</div>
									<div class="clearfix"></div>
								</div>
								<?php
								}