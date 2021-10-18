<?php 
require_once("includes/config.php");
require_once('app/class/database.php');

// Services
$db = new Database();

session_start();
if(!isset($_GET["user_id"]) || !is_numeric($_GET["user_id"]) || isset($_SESSION['login']) && $_SESSION['login'] != $_GET["user_id"])
	return;

$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_GET["user_id"]));

$mapLieux = $db->executeQuery('SELECT * FROM maps');
$mapLine = $db->executeQuery('SELECT * FROM maps_line');
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $configName; ?></title>
		<link rel="icon" type="image/png" href="<?php echo $configAssetsUrL; ?>/images/favicon.png" />
		<meta charset="UTF-8"/>
		<link type="text/css" rel="stylesheet" href="<?php echo $configAssetsUrL; ?>/css/map.css"/>
		<link rel="stylesheet" href="<?php echo $configAssetsUrL; ?>/css/animate.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css?family=Oswald|Open+Sans|Roboto" rel="stylesheet">
	</head>
	
	<body>
		<div class="all_map">
			<div id="map">
				<?php if($userInfo != null && $userInfo[0]["gps"] == 1) { ?>
				<div class="gps">
					<div id="here"><img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userInfo[0]["look"]; ?>&head_direction=3&gesture=sml&headonly=1" class="avatar"> Vous êtes ici !</div>
					
					<?php 
					foreach ($mapLieux as $mapLieuxRow) { 
						$roomInfo = $db->executeQuery('SELECT * FROM rooms WHERE id = ?', array($mapLieuxRow["room_id"]));
					?>
					<div class="item <?php if($mapLieuxRow["type"] == "1") { echo "row"; } else { echo "little_row"; } ?>" id="<?php echo $mapLieuxRow["room_id"]; ?>" style="top: <?php echo $mapLieuxRow["y"]; ?>px; left: <?php echo $mapLieuxRow["x"]; ?>px">
						<div class="icon"><img src="<?php echo $mapLieuxRow["image"]; ?>"></div>
						<div class="desc"><?php echo strlen(htmlentities(utf8_decode($roomInfo[0]["caption"]))) > 20 ? substr(htmlentities(utf8_decode($roomInfo[0]["caption"])),0,20)."..." : htmlentities(utf8_decode($roomInfo[0]["caption"])); ?></div>
						<div class="id"><?php echo $mapLieuxRow["room_id"]; ?></div>
					</div>
					<?php 
					} 
					foreach ($mapLine as $mapLineRow) {
					?>
					<div class="<?php echo $mapLineRow["type"]; ?>" style="top: <?php echo $mapLineRow["y"]; ?>; left: <?php echo $mapLineRow["x"]; ?>; width: <?php echo $mapLineRow["width"]; ?>px;" id="<?php echo $mapLineRow["id"]; ?>"></div>
					<?php 
					} 
					?>
				</div>
				
				<?php } else { ?>
				<div id="message">Vous n'avez pas de GPS.</div>
				<?php } ?>
			</div>
		</div>
		
		<?php if($userInfo[0]["rank"] == 8) { ?>
		<div id="save">Sauvegarder</div>
		<div id="new">Nouveau lieu</div>
		<div id="new_line">Nouvelle ligne</div>
		
		<div id="newLieu">
			<h1>Ajouter un lieu</h1>
			<input type="text" id="inputLieuId" placeholder="Appart ID"></input>
			<input type="text" id="inputLieuImage" placeholder="Image png"></input>
			<input type="text" id="inputLieuType" placeholder="Type (1 ou 2)"></input>
			<input type="submit" id="newLieuButton" value="Nouveau lieu"></input>
		</div>
		
		<div id="newLine">
			<h1>Ajouter une ligne</h1>
			<div class="clearfix"></div>
			<div class="lines_dispo">
				<div class="line type1" style="width: 100px;"></div>
				<div class="line type2" style="width: 100px;"></div>
				<div class="line type3" style="width: 100px;"></div>
				<div class="line type4" style="width: 100px;"></div>
				<div class="line type5" style="width: 100px;"></div>
				<div class="line type6" style="width: 100px;"></div>
			</div>
			<div class="clearfix"></div>
		</div>
		
		<div id="lineWidth">
			<input type="text" id="lineWidthValue" placeholder="Longueur"></input>
		</div>
		
		<div id="trash"><i class="fas fa-trash-alt"></i></div>
		<?php } ?>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
		<script src="<?php echo $configAssetsUrL; ?>/js/map.js"></script>
		<?php if($userInfo != null && $userInfo[0]["gps"] == 1) { ?>
		<script>$('#' + <?php echo $userInfo[0]["home_room"]; ?>).center();</script>
		<?php } if($userInfo != null && $userInfo[0]["rank"] == 8) { ?>
		<script>
		$('.row, .little_row').draggable({
			start: function(event, ui) {
				$('#save').show();
			}
		});
		
		$('.gps .line').draggable({
			start: function(event, ui) {
				$('#trash').show();
				$('#save').show();
			},
			
			stop: function(event, ui) {
				if($('#trash').css("opacity") == 1)
				{
					$("#lineWidth").hide();
					$(this).hide();
				}
				$('#trash').hide();
			}
		});
		
		$('#new').show();
		$('#new_line').show();
		</script>
		
		<?php } ?>
	</body>
</html>