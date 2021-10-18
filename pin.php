<?php 
require_once("includes/config.php");
require_once('app/class/database.php');

// Services
$db = new Database();

// Vérification connecté
session_start();
if(!isset($_SESSION['login'])) {
	header("Location: $configBaseUrL");
	exit();
}

if(isset($_SESSION['pin'])) {
	header("Location: $configBaseUrL/home");
	exit();
}

$userInfo = $db->executeQuery('SELECT * FROM users WHERE id=?', array($_SESSION['login']));
if($userInfo[0]["pin"] == "0")
{
	$pin = false;
}
else
{
	$pin = true;
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $configName; ?></title>
		<link rel="icon" type="image/png" href="<?php echo $configAssetsUrL; ?>/images/favicon.png" />
		<meta charset="UTF-8"/>
		<link type="text/css" rel="stylesheet" href="<?php echo $configAssetsUrL; ?>/css/pin.css"/>
		<link rel="stylesheet" href="<?php echo $configAssetsUrL; ?>/css/animate.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css?family=Oswald|Open+Sans|Roboto" rel="stylesheet">
	</head>
	
	<body>
		<div id="alertJs" class="error">
			<div class="description">fdsfdsfds</div>
			<div class="close"><i class="fas fa-times"></i></div>
		</div>
		
		<img src="//habbo.fr/habbo-imaging/avatarimage?figure=<?php echo $userInfo[0]["look"]; ?>&direction=2&head_direction=3&action=wav&gesture=sml&size=l&size=l" class="avatar animated fadeInUp">
		
		<div id="global" class="animated fadeInDown">
			<img src="<?php echo $configAssetsUrL; ?>/images/logo.png" class="logo">
			
			<?php if($pin == false) { ?>
			<h1>Définissez votre code PIN</h1>
			<?php } else { ?>
			<h1>Entrez votre code PIN</h1>
			<?php } ?>
			
			<div class="pin">
				<div class="pin_code">
					<div class="circle one"></div>
					<div class="circle two"></div>
					<div class="circle three"></div>
					<div class="circle four"></div>
				</div>
				
				<div class="pin_key">
					<div class="circle one">1</div>
					<div class="circle two">2</div>
					<div class="circle three">3</div>
					<div class="clearfix"></div>
					<div class="circle four">4</div>
					<div class="circle five">5</div>
					<div class="circle six">6</div>
					<div class="clearfix"></div>
					<div class="circle seven">7</div>
					<div class="circle eight">8</div>
					<div class="circle nine">9</div>
					<div class="clearfix"></div>
					<div class="circle zero">0</div>
				</div>
				
				<input type="hidden" id="pin_code"></input>
			</div>
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="<?php echo $configAssetsUrL; ?>/js/pin.js"></script>
	</body>
</html>