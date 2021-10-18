<?php 
include("../../includes/config.php");
include("global.php");

if($sessionLogin == true) {
?>
					<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/look.gif"> Les looks universel</div></h1>
					<div class="looks">
						<?php
						$lookList = $db->executeQuery('SELECT * FROM looks WHERE gender = "u" ORDER by type');
						foreach ($lookList as $lookListRow) {
							if($lookListRow["type"] == "ha")
							{
								$margin = "-20px";
							}
							elseif($lookListRow["type"] == "fa")
							{
								$margin = "-30px";
							}
							elseif($lookListRow["type"] == "ea")
							{
								$margin = "-30px";
							}
							elseif($lookListRow["type"] == "ch")
							{
								$margin = "-40px";
							}
							elseif($lookListRow["type"] == "ca")
							{
								$margin = "-25px";
							}
							elseif($lookListRow["type"] == "wa")
							{
								$margin = "-60px";
							}
							elseif($lookListRow["type"] == "lg")
							{
								$margin = "-60px";
							}
							elseif($lookListRow["type"] == "sh")
							{
								$margin = "-80px";
							}
						?>
						<div class="row <?php if($lookListRow["invente"] == 0) { echo 'inactive'; } ?>" id="<?php echo $lookListRow["id"]; ?>">
							<div class="price"><?php echo $lookListRow["price"]; ?></div>
							<img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $lookListRow["type"]; ?>-<?php echo $lookListRow["code"]; ?>-66&amp;gender=M" style="margin-left: -10px; margin-top: <?php echo $margin; ?>">
						</div>
						<?php
						}
						?>
					</div>
					
					<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/lookf.png"> Les looks filles</div></h1>
						<div class="looks">
						<?php
						$lookList = $db->executeQuery('SELECT * FROM looks WHERE gender = "F" ORDER by type');
						foreach ($lookList as $lookListRow) {
							if($lookListRow["type"] == "ha")
							{
								$margin = "-20px";
							}
							elseif($lookListRow["type"] == "fa")
							{
								$margin = "-30px";
							}
							elseif($lookListRow["type"] == "ea")
							{
								$margin = "-30px";
							}
							elseif($lookListRow["type"] == "ch")
							{
								$margin = "-40px";
							}
							elseif($lookListRow["type"] == "ca")
							{
								$margin = "-25px";
							}
							elseif($lookListRow["type"] == "wa")
							{
								$margin = "-60px";
							}
							elseif($lookListRow["type"] == "lg")
							{
								$margin = "-60px";
							}
							elseif($lookListRow["type"] == "sh")
							{
								$margin = "-80px";
							}
						?>
						<div class="row <?php if($lookListRow["invente"] == 0) { echo 'inactive'; } ?>" id="<?php echo $lookListRow["id"]; ?>">
							<div class="price"><?php echo $lookListRow["price"]; ?></div>
							<img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $lookListRow["type"]; ?>-<?php echo $lookListRow["code"]; ?>-95&amp;gender=F" style="margin-left: -10px; margin-top: <?php echo $margin; ?>">
						</div>
						<?php
						}
						?>
					</div>
					
					<h1 class="title"><div class="heading"><img src="<?php echo $configAssetsUrL; ?>/images/lookh.png"> Les looks hommes</div></h1>
						<div class="looks">
						<?php
						$lookList = $db->executeQuery('SELECT * FROM looks WHERE gender = "M" ORDER by type');
						foreach ($lookList as $lookListRow) {
							if($lookListRow["type"] == "ha")
							{
								$margin = "-20px";
							}
							elseif($lookListRow["type"] == "fa")
							{
								$margin = "-30px";
							}
							elseif($lookListRow["type"] == "ea")
							{
								$margin = "-30px";
							}
							elseif($lookListRow["type"] == "ch")
							{
								$margin = "-40px";
							}
							elseif($lookListRow["type"] == "ca")
							{
								$margin = "-25px";
							}
							elseif($lookListRow["type"] == "wa")
							{
								$margin = "-60px";
							}
							elseif($lookListRow["type"] == "lg")
							{
								$margin = "-60px";
							}
							elseif($lookListRow["type"] == "sh")
							{
								$margin = "-80px";
							}
						?>
						<div class="row <?php if($lookListRow["invente"] == 0) { echo 'inactive'; } ?>" id="<?php echo $lookListRow["id"]; ?>">
							<div class="price"><?php echo $lookListRow["price"]; ?></div>
							<img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $lookListRow["type"]; ?>-<?php echo $lookListRow["code"]; ?>-82&amp;gender=M" style="margin-left: -10px; margin-top: <?php echo $margin; ?>">
						</div>
						<?php
						}
						?>
					</div>
					
					<div class="clearfix"></div>
<?php
}
